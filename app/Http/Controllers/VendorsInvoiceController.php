<?php

namespace App\Http\Controllers;

use App\Helpers\RelatedItems;
use App\Models\Product;
use App\Models\VendorsInvoice;
use App\Models\VendorsInvoicesItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorsInvoiceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_id = auth()->user()->company_id;

        $bls= DB::table('vendors_invoices')
            ->join('vendors','vendors.id','=','vendors_invoices.vendor_id')
            ->join('users','users.id','=','vendors_invoices.created_by')
            ->selectRaw('vendors.full_name as vendor_name, vendors_invoices.*,users.name as user')
            ->where('vendors_invoices.company_id','=',$company_id)
            ->get();
        $invoices = new RelatedItems();
        $data = $invoices->invoiceRelatedItems($company_id);
        return response([
            'success'=>true,
            'data'=>['bls'=>$bls,'vendors'=>$data['vendors']]
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
        $invoice = VendorsInvoice::create($invoice_data);

        $invoice_items = $request->invoice_items;

        foreach($invoice_items as $item){
            $item['invoice_id']=$invoice->id;
            $item['company_id']=$company_id;
            $item['dt']=$invoice_data['invoice_date'];
            $product= Product::find($item['product_id']);
            if($product){
                $product->suppliers_invoices_qty = $product->suppliers_invoices_qty + $item['quantity'];
                $product->save();
            }
            VendorsInvoicesItems::create($item);
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
     * @param  \App\Models\VendorsInvoice  $vednorsInvoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice= VendorsInvoice::find($id);
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
     * @param  \App\Models\VendorsInvoice  $vednorsInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(VendorsInvoice $vednorsInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VendorsInvoice  $vednorsInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $invoice= VendorsInvoice::find($id);
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
                        $old_item = VendorsInvoicesItems::find($item['id']);
                        if($old_item != null){
                            $dif_qty = $item['quantity'] - $old_item['quantity'];
                            $product->suppliers_invoices_qty = $product->suppliers_invoices_qty + $dif_qty;
                            $old_item->delete();
                        }
                    }
                    else{
                        $product->suppliers_invoices_qty = $product->suppliers_invoices_qty +  $item['quantity'];
                    }
                    VendorsInvoicesItems::create($item);
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
     * @param  \App\Models\VendorsInvoice  $vednorsInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = VendorsInvoice::find($id);
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
