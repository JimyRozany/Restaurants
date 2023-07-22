<?php

namespace App\Http\Controllers\Api\User;

// use App\Models\Cart;
use App\Models\Dish;
use App\Models\Extra;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserOrdersResource;

class UserController extends Controller
{
    
    /** make order */
    public function makeOrder(Request $request)
    {
       $total_amount = 0;
        $request -> validate([
            'restaurant_id' => 'required',
            'user_address' => 'required',
            'dishes_quantity' => 'required', // array of dish IDs and quantity 
            'extras_quantity' => 'nullable', //  array of dish IDs and quantity 
        ]);
        $user = auth('user-guard')->user();

        $order = Order::create([
            'restaurant_id' => $request->restaurant_id,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_phone' => $user->phone,
            'user_address' => $request->user_address,
            'total_amount' => $total_amount,
            'status' => 'createing',
        ]);
        foreach ($request->dishes_quantity as $item){
            $total_amount += Dish::find($item['dish_id'])->price;
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'dish_id' => $item['dish_id'],
                'extra_id' => null,
                'dish_quantity'=> $item['quantity'],
                'extra_quantity' => null,
            ]);
        }
        if($request->extras_quantity){
        foreach ($request->extras_quantity as $item){
            $total_amount += Extra::find($item['extra_id'])->price;
            $orderItem->extra_id = $item['extra_id'];
            $orderItem->extra_quantity = $item['quantity'];
            $orderItem->save();
            }
        }
        $order->total_amount =  $total_amount ;
        $order->status =  'preparing food' ;
        $order->save();

        return response()->json([
        'status' => 'success',
        'message' => 'order created successfully'
        ]);

    }
     /** get user orders */
     public function getMyOrders(){
        $user = auth('user-guard')->user();
        return UserOrdersResource::collection($user->orders);
     }
     /** get specific order with more details ( order and order Itmes ) */
     public function orderDetails(Request $request){
        $request->validate(['order_id'=> 'required']);
        $order = Order::with('orderItems')->find($request->order_id);
        return response()->json([
            'status' =>'success',
            'data' =>$order
        ] ,200);

     }
}