<?php

namespace App\Http\Controllers;

use App\Models\ClientsInvoicesItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientsInvoicesItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function getInvoiceItems($id){
        $invoiceProducts=DB::table('clients_invoices_items')
            ->where('invoice_id','=',$id)
            ->get();

        return response()->json(['success'=>true,'data'=>$invoiceProducts],200);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientsInvoicesItems  $clientsInvoicesItems
     * @return \Illuminate\Http\Response
     */
    public function show(ClientsInvoicesItems $clientsInvoicesItems)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientsInvoicesItems  $clientsInvoicesItems
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientsInvoicesItems $clientsInvoicesItems)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClientsInvoicesItems  $clientsInvoicesItems
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientsInvoicesItems $clientsInvoicesItems)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClientsInvoicesItems  $clientsInvoicesItems
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice_item=ClientsInvoicesItems::find($id);
        if($invoice_item){
            $product = Product::find($invoice_item->product_id);
            $product->clients_invoices_qty = $product->clients_invoices_qty-$invoice_item->quantity;
            $product->save();
            if ($invoice_item->delete()) {
                return response()->json([
                    'success' => true,
                    'message'=> 'Invoice item deleted successfully'
                ],200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice item can not be deleted'
                ], 400);
            }
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Invoice item not found!'
            ], 404);
        }
    }
}
