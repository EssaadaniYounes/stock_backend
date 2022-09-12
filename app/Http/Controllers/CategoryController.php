<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $categories =DB::table('categories')
            ->where('company_id','=',$company_id)
            ->get();
        return response([
            'success'=>true,
            'data'=>$categories
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
        $category = Category::create($data);
        if($category){
            return response()->json([
                'success'=>true,
                'data'=>$category
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if($category){
            return response()->json([
                'success'=>true,
                'data'=>$category
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'data'=>'Category not found'
            ],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if($category){
            $updated = $category->update($request->all());

            if($updated){
            return response()->json([
                'success'=>true,
                'data'=>$updated
            ],200);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'data'=>'Cannot update this category try again!!'
                ],400);
            }

        }
        else{

            return response()->json([
                'success'=>false,
                'data'=>'Category not found'
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=Category::find($id);
        if($category){
            if($category->delete())
            {
                return response()->json([
                    'success'=>true,
                    'message'=>'Category deleted successfully'
                ],200);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Cannot delete this category'
                ],400);
            }
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'Category not found'
            ],404);
        }
    }
}
