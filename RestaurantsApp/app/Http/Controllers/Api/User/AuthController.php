<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    // registeration user 
    public function register(UserRegisterRequest $request){
        
       try {
        $data = $request->validated();
        // handle photo 
        $newNamePhoto = time() .'.'. $data['photo']->getClientOriginalExtension();
        // store image 
        $data['photo']->move(public_path('images/user/photo'),$newNamePhoto);
        $image_path = 'images/user/photo' . $newNamePhoto ;
        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password']),
            'phone'=>$data['phone'],
            'address'=>$data['address'],
            'photo'=> $image_path,
        ]);
        return response()->json([
            'status'=>'success',
            'message'=>'user registration successful',
        ],201);
       } catch (\Exception $e) {
            return response()->json([
                'status'=>'error',
                'message'=>'registration failed',
            ]);
       }
    }
    
    // // login user
    public function login(UserLoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            if(!$token = auth('user-guard')->attempt($credentials)){
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
