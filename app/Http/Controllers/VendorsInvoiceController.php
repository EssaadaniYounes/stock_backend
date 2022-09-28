<?php

namespace App\Http\Controllers;

use App\Models\VendorsInvoice;
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
            ->selectRaw('vendors.full_name as vendor_name, vendors_invoices.*')
            ->where('vendors_invoices.company_id','=',$company_id)
            ->get();
        return response([
            'success'=>true,
            'data'=>$bls
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VendorsInvoice  $vednorsInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(VendorsInvoice $vednorsInvoice)
    {
        //
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
    public function update(Request $request, VendorsInvoice $vednorsInvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VendorsInvoice  $vednorsInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendorsInvoice $vednorsInvoice)
    {
        //
    }
}
