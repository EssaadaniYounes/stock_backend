<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrinterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $printers =DB::table('printers')
            ->where('company_id','=',$company_id)
            ->get();
        return response([
            'success'=>true,
            'data'=>$printers
        ],200);
    }
    public function makeDefault(Request $request, $id){
        $printers= Printer::all();
        $new_printer = Printer::find($id);
        foreach($printers as $printer){
            if($printer->id!=$id && $printer->is_default==1){
                $printer->update(['is_default' => 0]);
            }
        }
        $updated = $new_printer->update(['is_default' => 1]);
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
        $data=$request->all();
        $data['company_id']=auth()->user()->company_id;
        $printer = Printer::create($data);
        if($printer){
            return response()->json([
                'success'=>true,
                'message'=>'Printer added successfully',
                'data'=>$printer
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>"Cannot add this printer"
            ],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $printer = Printer::find($id);
        if($printer){
            return response()->json([
                'success'=>true,
                'data'=>$printer
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
     * @param  \App\Models\Printer  $printer
     * @return \Illuminate\Http\Response
     */
    public function edit(Printer $printer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $printer = Printer::find($id);
        if($printer){
            $updated = $printer->update($request->all());

            if($updated){
                return response()->json([
                    'success'=>true,
                    'data'=>$updated
                ],200);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'data'=>'Cannot update this printer try again!!'
                ],400);
            }

        }
        else{

            return response()->json([
                'success'=>false,
                'data'=>'Printer not found'
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $printer = Printer::find($id);
        if($printer){
            if($printer->delete())
            {
                return response()->json([
                    'success'=>true,
                    'message'=>'Printer deleted successfully'
                ],200);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Cannot delete this printer'
                ],400);
            }
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'Printer not found'
            ],404);
        }
    }
}
