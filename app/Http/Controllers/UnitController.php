<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units =Unit::all();
        return response([
            'success'=>true,
            'data'=>$units
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
        $unit = Unit::create($request->all());
        if($unit){
            return response()->json([
                'success'=>true,
                'data'=>$unit
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
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unit = Unit::find($id);
        if($unit){
            return response()->json([
                'success'=>true,
                'data'=>$unit
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'data'=>'Unit not found'
            ],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $unit = Unit::find($id);
        if($unit){
            $updated = $unit->update($request->all());

            if($updated){
                return response()->json([
                    'success'=>true,
                    'data'=>$updated,
                    'message'=>'unit updated successfully'
                ],200);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Cannot update this unit try again!!'
                ],400);
            }

        }
        else{

            return response()->json([
                'success'=>false,
                'message'=>'Unit not found'
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit=Unit::find($id);
        if($unit){
            if($unit->delete())
            {
                return response()->json([
                    'success'=>true,
                    'message'=>'Unit deleted successfully'
                ],200);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Cannot delete this unit'
                ],400);
            }
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'Unit not found'
            ],404);
        }
    }
}
