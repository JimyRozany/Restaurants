<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantOrdersResource;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /* get my order */
    public function myOrders(){
        $restaurant = auth('restaurant-guard')->user();
        return RestaurantOrdersResource::collection($restaurant->orders) ;
    }
    /** edit order */
    public function editOrder(Request $request){
        $request->validate([
            'order_id' => 'required',
            'status' => 'required',
        ]);
        
        $restaurant = auth('restaurant-guard')->user();
        $order = $restaurant->orders->find($request->order_id);
        $order->status = $request->status;
        $order->save();
        return response()->json([
            'status' => 'success',
            'message' => 'order updated successfully'
        ] ,200);
    }

}
