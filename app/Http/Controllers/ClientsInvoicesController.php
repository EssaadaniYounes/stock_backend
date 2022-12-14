<?php

namespace App\Http\Controllers;

use App\Helpers\RelatedItems;
use App\Models\ClientsInvoices;
use App\Models\ClientsInvoicesItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientsInvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $invoices= DB::table('clients_invoices')
            ->join('clients','clients.id','=','clients_invoices.client_id')
            ->join('users','users.id','=','clients_invoices.created_by')
            ->selectRaw('clients_invoices.*, clients.full_name as client_name, users.name as user')
            ->where([
                ['clients_invoices.company_id',$company_id],
                ['clients_invoices.is_pos',0]
            ])
            ->get();

        return response()->json([
            'success'=>true,
            'data'=>$invoices
        ],200);
    }

    public function relatedItems(){
        $company_id = auth()->user()->company_id;

        $invoices = new RelatedItems();
        $data = $invoices->invoiceRelatedItems($company_id);
        return response()->json([
            "success"=>true,
            "data"=> $data
        ],200);
    }

    public function getReportData($id){
        $company_id=auth()->user()->company_id;
        $company_data = DB::table('companies')
            ->where('id',$company_id)
            ->first();
        $invoice = DB::table('clients_invoices')
            ->join('clients','clients.id','clients_invoices.client_id')
            ->join('pay_methods','pay_methods.id','clients_invoices.method_id')
            ->join('users','users.id','=','clients_invoices.created_by')
            ->selectRaw('clients_invoices.*, clients.full_name as client_name, clients.address as client_address, pay_methods.name as method_name, users.name as created_by')
            ->where([
                ['clients_invoices.id',$id],
                ['clients_invoices.company_id',$company_id]
            ])
            ->first();
        //TODO: Add Printing in pos
        $items = DB::table('clients_invoices_items')
            ->join('products','products.id','clients_invoices_items.product_id')
            ->join('units','units.id','products.unit_id')
            ->selectRaw('clients_invoices_items.*, units.name as unit_name')
            ->where([
                ['clients_invoices_items.invoice_id',$id],
                ['clients_invoices_items.company_id',$company_id]
            ])
            ->get();
        return response()->json([
            'success'=>true,
            'data'=>[
                'company'=>$company_data,
                'invoice'=>$invoice,
                'items'=>$items
            ]
        ],200);


    }
    public function getReportDataWithQuery(Request $request, $id){
        $query_string = $request->getQueryString();

        parse_str($query_string, $params);
        $company_id=$params['company'];
        $company_data = DB::table('companies')
            ->where('id',$company_id)
            ->first();
        $invoice = DB::table('clients_invoices')
            ->join('clients','clients.id','clients_invoices.client_id')
            ->join('pay_methods','pay_methods.id','clients_invoices.method_id')
            ->join('users','users.id','=','clients_invoices.created_by')
            ->selectRaw('clients_invoices.*, clients.full_name as client_name, clients.address as client_address, pay_methods.name as method_name, users.name as created_by')
            ->where([
                ['clients_invoices.id',$id],
                ['clients_invoices.company_id',$company_id]
            ])
            ->first();
        //TODO: Add Printing in pos
        $items = DB::table('clients_invoices_items')
            ->join('products','products.id','clients_invoices_items.product_id')
            ->join('units','units.id','products.unit_id')
            ->selectRaw('clients_invoices_items.*, units.name as unit_name')
            ->where([
                ['clients_invoices_items.invoice_id',$id],
                ['clients_invoices_items.company_id',$company_id]
            ])
            ->get();
        return response()->json([
            'success'=>true,
            'data'=>[
                'company'=>$company_data,
                'invoice'=>$invoice,
                'items'=>$items
            ]
        ],200);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company_id=auth()->user()->company_id;
        $invoice_data = $request->invoice;
        $invoice_data['created_by'] = auth()->user()->id;
        $invoice_data['company_id'] = $company_id;
        $invoice = ClientsInvoices::create($invoice_data);

        $invoice_items=$request->invoice_items;
        foreach($invoice_items as $item){
            $item['invoice_id']=$invoice->id;
            $item['company_id']=$company_id;
            $item['dt']=$invoice_data['invoice_date'];
            $product= Product::find($item['product_id']);
            if($product){
                $product->clients_invoices_qty = $product->clients_invoices_qty + $item['quantity'];
                $product->save();
            }
            ClientsInvoicesItems::create($item);
        }
        if($invoice){
            return response()->json(['success'=>true,'data'=>$invoice],200);
        }
        else{
            return response()->json(['success'=>false,'data'=>$invoice],200);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientsInvoices  $clientsInvoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice= ClientsInvoices::find($id);
        if(!$invoice){
            return response()->json([
                'success'=>false,
                'message'=>'This invoice not found!'
                ],404);
        }
        else{
            return response()->json([
                'success'=>true,
                'data'=>$invoice
            ],200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientsInvoices  $clientsInvoices
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientsInvoices $clientsInvoices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClientsInvoices  $clientsInvoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //DB::table('clients_invoices_items')->where('invoice_id','=',$id)->delete();
        $invoice= ClientsInvoices::find($id);
        if(!$invoice){
            return response()->json([
                'success'=>false,
                'message'=>'Invoice not found!'
            ],404);
        }
        else{
            $invoice_data = $request->invoice;
            $invoice_data['created_by'] = auth()->user()->id;
            $updated=$invoice->update($invoice_data);
            $invoice_items=$request->invoice_items;
            if($updated){
                foreach ($invoice_items as $item){
                    $product = Product::find($item['product_id']);
                    $item['invoice_id'] = $invoice->id;
                    $item['company_id'] = auth()->user()->company_id;
                    $item['dt']=$invoice_data['invoice_date'];
                    if( isset($item['id'])){
                        $old_item = ClientsInvoicesItems::find($item['id']);
                        if($old_item != null){
                            $dif_qty = $item['quantity'] - $old_item['quantity'];
                            $product->clients_invoices_qty = $product->clients_invoices_qty + $dif_qty;
                            $old_item->delete();
                        }
                    }
                    else{
                        $product->clients_invoices_qty = $product->clients_invoices_qty +  $item['quantity'];
                    }
                    ClientsInvoicesItems::create($item);
                    $product->save();
                }
                return response()->json(
                    [
                        'success'=>true,
                        'message'=>'Invoice updated successfully',
                        'data'=>$updated
                    ],200
                );
            }
            return response()->json([
                'success'=>false,
                'message'=>'Cannot update this invoice try again!'
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClientsInvoices  $clientsInvoices
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = ClientsInvoices::find($id);
        if(!$invoice){
            return response()->json([
                'success'=>false,
                'message'=>'This invoice not found!'
            ],404);
        }
        else{
            if($invoice->delete()){
                return response()->json(
                    [
                        'success'=>true,
                        'message'=>'Invoice deleted successfully'
                    ],200
                );
            }
            return response()->json([
                'success'=>false,
                'message'=>'Cannot delete this invoice try again!'
            ],400);
        }
    }
}
