<?php
namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\User;
use App\Models\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            //added fields 
            'role_id' => ['required', 'string', 'max:255'],
        ]);

        if($validator->fails()){
            return ['message' => $validator->errors()];       
        }
        //
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
         ]);


        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Successfully registered',
            'data' => $user,
            'access_token' => $token, 
            'token_type' => 'Bearer',
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if($validator->fails()){
            return ['message' => [$validator->errors()]];       
        }
        //
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Successfully logged in',
            'data' => $user,
            'access_token' => $token, 
            'token_type' => 'Bearer',
        ], 200);
    }

  
    public function logout(Request $request)
    {
        if($request->user){
            $request->user()->tokens()->delete();
        }


        return [
            'message' => 'Success'
        ];
    }

    public function test(Request $request){

        return [
            'message' => 'Success'
        ];

    }
}