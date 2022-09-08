<?php

namespace App\Http\Controllers;

use App\Models\ClientsInvoices;
use App\Models\ClientsInvoicesItems;
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
        $invoices= DB::table('clients_invoices')
            ->join('clients','clients.id','=','clients_invoices.client_id')
            ->selectRaw('clients_invoices.*, clients.full_name as client_name')
            ->get();

        return response()->json([
            'success'=>true,
            'data'=>$invoices
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
        $invoice = ClientsInvoices::create($request->invoice);
        $invoice_items=$request->invoice_items;
        foreach($invoice_items as $item){
            $item['invoice_id']=$invoice->id;

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
        DB::table('clients_invoices_items')->where('invoice_id','=',$id)->delete();
        $invoice= ClientsInvoices::find($id);
        if(!$invoice){
            return response()->json([
                'success'=>false,
                'message'=>'This invoice not found!'
            ],404);
        }
        else{
            $updated=$invoice->update($request->invoice);
            $invoice_items=$request->invoice_items;
            if($updated){
                foreach ($invoice_items as $item){
                    $item['invoice_id']=$invoice->id;
                    ClientsInvoicesItems::create($item);
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
