<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantLoginRequest;
use App\Http\Requests\RestaurantRegisterRequest;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    // registeration restaurant 
    public function register(RestaurantRegisterRequest $request){
       try {
        $data = $request->validated();
        // handle image 
        $newNameImage = time() . '.' . $data['restaurant_photo']->getClientOriginalExtension();
        $data['restaurant_photo']->move(public_path('images/restaurant/') ,$newNameImage);
        $path_image = 'images/restaurant/'.$newNameImage;
        $restaurant = Restaurant::create([
            'restaurant_name' => $data['restaurant_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'address' => $data['address'],
            'restaurant_photo' => $path_image,
            'verified' => false,
            'status' => 'open',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Registration is done and waiting for administrator verification',
        ] ,201);
       } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => 'Registration is failed',
                // 'message' => $ex->getMessage(),
            ] );
       }

    }
    
    // login restaurant
    public function login(RestaurantLoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            if (!$token = auth('restaurant-guard')->attempt($credentials)){
                return response()->json([
                    'status'=>'error',
                    'message'=>'email or password incorrect',
                ] ,401);
            }else{
                return response()->json([
                    'status'=>'success',
                    'message'=>'login successful',
                    'token'=>$token,
                ] ,200);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status'=>'error',
                'message'=>$e->getMessage(),
            ] ,422);
        }
    }

    // restaurant logout 
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
