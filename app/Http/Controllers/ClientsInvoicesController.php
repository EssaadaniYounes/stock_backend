<?php

namespace App\Http\Controllers;

use App\Models\ClientsInvoices;
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
        $invoice = ClientsInvoices::create($request->all());
        if($invoice){
            return response()->json([
                'success'=>true,
                'data'=>$invoice,
                'message'=>'Invoice added successfully!'
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>'Cannot add this invoice..try again!!!'
            ],400);
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
            ],404);
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
        $invoice= ClientsInvoices::find($id);
        if(!$invoice){
            return response()->json([
                'success'=>false,
                'message'=>'This invoice not found!'
            ],404);
        }
        else{
            $updated=$invoice->update($request->all());
            if($updated){
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
