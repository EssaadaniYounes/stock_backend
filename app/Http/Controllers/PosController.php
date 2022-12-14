<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\RelatedItems;
use App\Models\ClientsInvoices;
use App\Models\ClientsInvoicesItems;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
class PosController extends Controller
{

    public function index()
    {
        $company_id = auth()->user()->company_id;
        $invoices= DB::table('clients_invoices')
            ->join('clients','clients.id','=','clients_invoices.client_id')
            ->join('users','users.id','=','clients_invoices.created_by')
            ->selectRaw('clients_invoices.*, clients.full_name as client_name, users.name as user')
            ->where([
                ['clients_invoices.company_id',$company_id],
                ['clients_invoices.is_pos',1]
            ])
            ->get();

        return response()->json([
            'success'=>true,
            'data'=>$invoices
        ],200);
    }

    public function store(Request $request)
    {
        $company_id=auth()->user()->company_id;
        $invoice_data = $request->invoice;
        $invoice_data['created_by'] = auth()->user()->id;
        $invoice_data['company_id'] = $company_id;
        $invoice_data['is_pos'] = 1;
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
    public function update(Request $request, $id)
    {
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
