<?php

namespace App\Http\Controllers;

use App\Models\PayMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $methods =DB::table('pay_methods')
            ->where('company_id','=',$company_id)
            ->get();
        return response([
            'success'=>true,
            'data'=>$methods
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
        $method = PayMethod::create($data);
        if($method){
            return response()->json([
                'success'=>true,
                'data'=>$method
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
     * @param  \App\Models\PayMethod  $payMethod
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $method = PayMethod::find($id);
        if($method){
            return response()->json([
                'success'=>true,
                'data'=>$method
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'data'=>'Method not found'
            ],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PayMethod  $payMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(PayMethod $payMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PayMethod  $payMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $method = PayMethod::find($id);
        if($method){
            $updated = $method->update($request->all());
            if($updated){
                return response()->json([
                    'success'=>true,
                    'data'=>$updated
                ],200);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'data'=>'Cannot update this method try again!!'
                ],400);
            }

        }
        else{

            return response()->json([
                'success'=>false,
                'data'=>'Method not found'
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PayMethod  $payMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $method=PayMethod::find($id);
        if($method){
            if($method->delete())
            {
                return response()->json([
                    'success'=>true,
                    'message'=>'Method deleted successfully'
                ],200);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Cannot delete this method'
                ],400);
            }
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'Method not found'
            ],404);
        }
    }
}
