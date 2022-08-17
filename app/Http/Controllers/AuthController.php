<?php
namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json(['token' => $token], 200);
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
            $role= Role::find( auth()->user()->role_id);
            
            $user = auth()
                    ->user()
                    ->join('roles', 'roles.id', '=', 'users.role_id')
                    ->select('users.*', 'roles.*')
                    ->first();
            
            return response()->json(['token' => $token,'data'=>$user], 200);
        } else {
            return response()->json(['success'=>false,'error' => 'Unauthorised'] );
        }
    }
}
