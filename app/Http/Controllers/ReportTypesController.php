<?php

namespace App\Http\Controllers;

use App\Models\ReportTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $types =DB::table('report_types')
            ->where('company_id','=',$company_id)
            ->get();
        return response([
            'success'=>true,
            'data'=>$types
        ],200);
    }
    public function makeDefault(Request $request,$id){
        $types= ReportTypes::all();
        $new_type = ReportTypes::find($id);
        foreach($types as $type){
            if($type->id!=$id && $type->is_default==1){
                $type->update(['is_default' => 0]);
            }
        }
        $updated = $new_type->update(['is_default' => 1]);
        return response()->json(['success'=>$updated],200);
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
     * @param  \App\Models\ReportTypes  $reportTypes
     * @return \Illuminate\Http\Response
     */
    public function show(ReportTypes $reportTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportTypes  $reportTypes
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportTypes $reportTypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReportTypes  $reportTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReportTypes $reportTypes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportTypes  $reportTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportTypes $reportTypes)
    {
        //
    }
}
