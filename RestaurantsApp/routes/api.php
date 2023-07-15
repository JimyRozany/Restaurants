<?php

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\User\AuthController as AuhtUserController;
use App\Http\Controllers\Api\Restaurant\AuthController as AuhtRestaurantController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

 /*  ********* Admin Routes ******** */
Route::post('admin-register' ,[AuthController::class ,'register']);
Route::post('admin-login' ,[AuthController::class ,'login']);
Route::middleware('jwt.verify:admin-guard')->group(function () {
    Route::post('admin-logout' ,[AuthController::class ,'logout']);
});
 /*  ********* end Admin Routes ******** */


 /*  ********* User Routes ******** */
Route::post('user-register' ,[AuhtUserController::class ,'register']);
Route::post('user-login' ,[AuhtUserController::class ,'login']);
Route::middleware('jwt.verify:user-guard')->group(function () {
    Route::post('user-logout' ,[AuhtUserController::class ,'logout']);
});
 /*  ********* end User Routes ******** */


 /*  ********* Restaurant Routes ******** */
Route::post('restaurant-register' ,[AuhtRestaurantController::class ,'register']);
Route::post('restaurant-login' ,[AuhtRestaurantController::class ,'login']);
Route::middleware('jwt.verify:restaurant-guard')->group(function () {
    Route::post('restaurant-logout' ,[AuhtRestaurantController::class ,'logout']);
});
 /*  ********* end User Routes ******** */
