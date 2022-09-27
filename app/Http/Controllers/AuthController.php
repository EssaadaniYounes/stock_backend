<?php
namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $users = DB::table('users')
            ->join('roles','roles.id','=','users.role_id')
            ->selectRaw('users.*, roles.role_name')
            ->where('users.company_id','=',$company_id)
            ->get();
        return response()->json([
            'success'=>true,
            'data'=>$users,
            'company_id'=>$company_id,
        ],200);
    }
    /**
     * Registration
     */
    public function register(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => bcrypt($request->password),
            'company_id'=>$request->company_id
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json(['token' => $token,'success'=>true], 200);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;

            $user = auth()
                    ->user()
                    ->join('roles', 'roles.id', '=', 'users.role_id')
                    ->join('companies','companies.id','=','users.company_id')
                    ->where([
                        ['users.id','=',auth()->user()->id],
                        ['users.company_id','=',auth()->user()->company_id]
                    ])
                    ->select('users.*', 'roles.role_name','roles.permissions', 'companies.company_name')
                    ->first();

            return response()->json(['success'=>true,'token' => $token,'data'=>$user], 200);
        } else {
            return response()->json(['success'=>false,'error' => 'Email or password incorrect try again!'] );
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::find($id);
        if($user){
            return response()->json([
                'success'=>true,
                'data'=>$user
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'data'=>'User not found'
            ],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'success'=>false,
                'data'=>'Cannot find user with this id!'
            ],404);
        }
        $data = [
            'name'=>$request->name,
            'email' => $request->email,
            'role_id' => $request->role_id
        ];
        $updated=$user->update($data);
        if($updated){
            return response()->json([
                'success'=>true,
                'data'=>$updated
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'data'=>'Cannot update this user try again!!'
            ],400);
        }

    }

}
