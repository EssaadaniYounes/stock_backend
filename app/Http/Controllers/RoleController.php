<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $roles =DB::table('roles')
            ->where('company_id','=',$company_id)
            ->get();
        return response()->json([
            'success'=>true,
            'data'=>$roles
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        $role = Role::create($data);
        if(!$role){
            return response()->json([
                'success'=>false,
                'data'=>'Role can not create try again!!'
            ],400);
        }
        else{
            return response()->json([
                'success'=>true,
                'data'=>$role
            ],200);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        if($role){
            return response()->json([
                'success'=>true,
                'data'=>$role
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'data'=>'Role not found'
            ],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if(!$role){
            return response()->json([
                'success'=>false,
                'data'=>'Cannot find role with this id!'
            ],404);
        }
        $updated=$role->update($request->all());
        if($updated){
            return response()->json([
                'success'=>true,
                'data'=>$updated
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'data'=>'Cannot update this role try again!!'
            ],400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role=Role::find($id);
        if(!$role){
            return response()->json([
                'success'=>false,
                'data'=>'/there\'s no role with this id!/'
            ],404);
        }
        if($role->delete()){
            return response()->json([
                'success'=>true,
                'data'=>'Role deleted successfully'
            ],200);
        }
        else{
            return response()->json([
                'success'=>true,
                'data'=>'Cannot delete this role try again!'
            ],400);
        }
    }
}
