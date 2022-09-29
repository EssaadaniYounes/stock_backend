<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\VendorsInvoicesItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorsInvoicesItemsController extends Controller
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
        $invoiceProducts=DB::table('vendors_invoices_items')
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
     * @param  \App\Models\VendorsInvoicesItems  $vendorsInvoicesItems
     * @return \Illuminate\Http\Response
     */
    public function show(VendorsInvoicesItems $vendorsInvoicesItems)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VendorsInvoicesItems  $vendorsInvoicesItems
     * @return \Illuminate\Http\Response
     */
    public function edit(VendorsInvoicesItems $vendorsInvoicesItems)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VendorsInvoicesItems  $vendorsInvoicesItems
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VendorsInvoicesItems $vendorsInvoicesItems)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VendorsInvoicesItems  $vendorsInvoicesItems
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice_item=VendorsInvoicesItems::find($id);
        if($invoice_item){
            $product = Product::find($invoice_item->product_id);
            $product->suppliers_invoices_qty = $product->suppliers_invoices_qty - $invoice_item->quantity;
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
