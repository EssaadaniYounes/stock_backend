<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $vendors =DB::table('vendors')
            ->join('cities','cities.id','vendors.city_id')
            ->selectRaw('vendors.*, cities.name as city')
            ->where('vendors.company_id','=',$company_id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $vendors
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
        $vendor=Vendor::create($data);
        if ($vendor)
            return response()->json([
                'success' => true,
                'data' => $vendor
            ],200);
        else
            return response()->json([
                'success' => false,
                'message' => 'Vendor not added'
            ], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor=Vendor::find($id);

        if (!$vendor) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor not found '
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $vendor
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vendor = Vendor::find($id);

        if(!$vendor) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor not found'
            ], 404);
        }

        $updated = $vendor->update($request->all());

        if ($updated)
            return response()->json([
                'success' => true,
                'data'=>$updated
            ],200);
        else
            return response()->json([
                'success' => false,
                'message' => 'Vendor can not be updated'
            ], 400);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor=Vendor::find($id);

        if (!$vendor) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor not found'
            ], 404);
        }

        if ($vendor->delete()) {
            return response()->json([
                'success' => true,
                'message'=> 'Vendor deleted successfully'
            ],200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Vendor can not be deleted'
            ], 400);
        }
    }
}
