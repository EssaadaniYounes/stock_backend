<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $products =DB::table('products')
            ->join('categories','categories.id','products.category_id')
            ->join('vendors','vendors.id','products.vendor_id')
            ->join('units','units.id','products.unit_id')
            ->selectRaw(' products.*, categories.name as category_name, vendors.full_name as vendor_name, units.name as unit_name')
            ->where('products.company_id','=',$company_id)
            ->get();
        return response([
            'success'=>true,
            'data'=>$products
        ],200);
    }

    public function relatedItems()
    {
        $units = DB::table('units')
        ->selectRaw('units.id as value,units.name as label')
            ->where('units.company_id','=',auth()->user()->company_id)
        ->get();
        $categories = DB::table('categories')
            ->selectRaw('categories.id as value,categories.name as label')
            ->where('categories.company_id','=',auth()->user()->company_id)
            ->get();
        $vendors = DB::table('vendors')
            ->selectRaw('vendors.id as value,vendors.full_name as label')
            ->where('vendors.company_id','=',auth()->user()->company_id)
            ->get();
        $cities = DB::table('cities')
            ->selectRaw('cities.id as value,cities.name as label')
            ->where('cities.company_id','=',auth()->user()->company_id)
            ->get();

        return response()->json([
            'success'=>true,
            'data'=>[
                'units'=>$units,
                'categories'=>$categories,
                'vendors'=>$vendors,
                'cities'=>$cities
            ]
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
        $product = Product::create($data);
        if($product){
            return response()->json([
                'success'=>true,
                'data'=>$product
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if($product){
            return response()->json([
                'success'=>true,
                'data'=>$product
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'data'=>'Product not found'
            ],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if($product){
            $updated = $product->update($request->all());
            if($updated){
                return response()->json([
                    'success'=>true,
                    'data'=>$updated
                ],200);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'data'=>'Cannot update this product try again!!'
                ],400);
            }

        }
        else{

            return response()->json([
                'success'=>false,
                'data'=>'Product not found'
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::find($id);
        if($product){
            if($product->delete())
            {
                return response()->json([
                    'success'=>true,
                    'message'=>'Product deleted successfully'
                ],200);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Cannot delete this product'
                ],400);
            }
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'Product not found'
            ],404);
        }
    }
}
