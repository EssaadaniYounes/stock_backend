<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $cities =DB::table('cities')
            ->where('company_id','=',$company_id)
            ->get();
        return response([
            'success'=>true,
            'data'=>$cities
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
        $data=$request->all();
        $data['company_id']=auth()->user()->company_id;
        $city = City::create($data);
        if($city){
            return response()->json([
                'success'=>true,
                'data'=>$city
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
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::find($id);
        if($city){
            return response()->json([
                'success'=>true,
                'data'=>$city
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'data'=>'City not found'
            ],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $city = City::find($id);
        if($city){
            $updated = $city->update($request->all());

            if($updated){
                return response()->json([
                    'success'=>true,
                    'data'=>$updated
                ],200);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'data'=>'Cannot update this city try again!!'
                ],400);
            }

        }
        else{

            return response()->json([
                'success'=>false,
                'data'=>'City not found'
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city=City::find($id);
        if($city){
            if($city->delete())
            {
                return response()->json([
                    'success'=>true,
                    'message'=>'City deleted successfully'
                ],200);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Cannot delete this city'
                ],400);
            }
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'City not found'
            ],404);
        }
    }
}
