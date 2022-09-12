<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $company = DB::table('companies')
            ->where('id','=',$company_id)
            ->first();
        if($company){
            return response()->json([
                'success'=>true,
                'data'=>$company
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'data'=>null,
                'message'=>"Company not found"
            ],404);
        }
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

        $company = Company::create($request->all());
        if($company){
            return response()->json([
                'success'=>true,
                'data'=>$company
            ],200);
        }
        else{
            return response()->json([
                'success'=>false
            ],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        if(!$company){
            return response()->json([
                'success'=>false,
                'data'=>'Cannot find company with this id!'
            ],404);
        }
        $updated = $company->update($request->all());
        if($updated){
            return response()->json([
                'success'=>true,
                'data'=>$updated
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'data'=>'Cannot update this company try again!!'
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }

    public function store_imgs(Request $request)
    {
        if($request->hasFile('logo')){
            $file = $request->file('logo');
            $file_name = $file->getClientOriginalName();
            $file->move(storage_path('images/companies'), $file_name);
            return response()->json([
                'message' => 'file uploaded',
                'file' => $file_name
            ], 200);
        }

    }
}
