<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminRegisterRequest;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    // registeration admin
    public function register(AdminRegisterRequest $request){
       try {
        $data = $request->validated();
        $admin = Admin::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password']),
            'phone'=>$data['phone'],
        ]);
        return response()->json([
            'status'=>'success',
            'message'=>'admin registration successful',
        ],201);
       } catch (\Exception $e) {
            return response()->json([
                'status'=>'error',
                'message'=>'registration failed',
            ]);
       }
    }
    
    // login admin
    public function login(AdminLoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            if(!$token = auth('admin-guard')->attempt($credentials)){
                return response()->json([
                    'status'=>'error',
                    'message'=>'email or password incorrect',
                ] ,401);
            }
            return response()->json([
                'status'=>'success',
                'message'=>'login successful',
                'token'=>$token
            ] ,200);

        } catch (\Exception $e) {
            return response()->json([
                'status'=>'error',
                'message'=>$e->getMessage(),
            ] ,422);
        }
    }

    // logout 
    public function logout(Request $request){
        $token = $request->input('token');
        if($token){
            try {
                JWTAuth::setToken($token)->invalidate();
                return response()->json([
                    'status' =>'success',
                    'message' =>'Successfully logged out'
                ] ,200);
            } catch (TokenInvalidException $e) {
                return response()->json([
                    'status' =>'error',
                    'message' =>'token invalid'
                ]);
            }
        }else{
            return response()->json([
                'status' =>'error',
                'message' =>'token not found',
            ] ,404);
        }
    }
}
