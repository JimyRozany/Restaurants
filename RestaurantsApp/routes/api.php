<?php

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\PublicController;
use App\Http\Controllers\Api\Restaurant\FoodController;
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

 /* ********* Public Routes ******** */
 Route::middleware(['jwt.verify'] )->group(function () {
    // get menu by restaurant id 
    Route::post('all-restaurants' ,[PublicController::class,'allRestaurants']);
    Route::post('dishes-in-category' ,[PublicController::class,'dishesByCategory']);
    Route::post('dishes-in-menu' ,[PublicController::class,'dishesByMenu']);
});
 /*  ********* end Public Routes ******** */
 /*  ********* Admin Routes ******** */
Route::post('admin-register' ,[AuthController::class ,'register']);
Route::post('admin-login' ,[AuthController::class ,'login']);
Route::middleware(['jwt.verify' ,'checkGuard:admin-guard'])->group(function () {
    Route::post('admin-logout' ,[AuthController::class ,'logout']);
});
 /*  ********* end Admin Routes ******** */


 /*  ********* User Routes ******** */
Route::post('user-register' ,[AuhtUserController::class ,'register']);
Route::post('user-login' ,[AuhtUserController::class ,'login']);
Route::middleware(['jwt.verify' ,'checkGuard:user-guard'])->group(function () {
    Route::post('user-logout' ,[AuhtUserController::class ,'logout']);
});
 /*  ********* end User Routes ******** */


 /*  ********* Restaurant Routes ******** */
Route::post('restaurant-register' ,[AuhtRestaurantController::class ,'register']);
Route::post('restaurant-login' ,[AuhtRestaurantController::class ,'login']);
Route::middleware(['jwt.verify' ,'checkGuard:restaurant-guard'])->group(function () {
    Route::post('restaurant-logout' ,[AuhtRestaurantController::class ,'logout']);
    /*********** restaurant is approved by admin *********** */
    Route::middleware('approvedByAdmin')->group(function () {
        Route::post('add-category' ,[FoodController::class ,'addCategory']);
        Route::post('add-dish' ,[FoodController::class ,'addDish']);
        Route::post('edit-dish' ,[FoodController::class ,'editDish']);
        Route::post('delete-dish' ,[FoodController::class ,'destroy']);
        Route::post('add-extra' ,[FoodController::class ,'addExtra']);
        Route::post('edit-extra' ,[FoodController::class ,'editExtra']);
        Route::post('delete-extra' ,[FoodController::class ,'removeExtra']);
        
    });
});
 /*  ********* end User Routes ******** */


//  test 

// Route::get('test' , function(){
//     return 'done';
// })->middleware(['jwt.verify','checkGuard:admin-guard' ]);