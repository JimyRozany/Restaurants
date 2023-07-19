<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DishesResource;
use App\Http\Resources\RestaurantResource;

class PublicController extends Controller
{
    /* get all restaurants */
    public function allRestaurants(){
        /* fetch date paginate restaurants and  menu and categorise */
        $restaurants = Restaurant::with('menu')->with('categories')->paginate(10);
        return RestaurantResource::collection($restaurants);
    }
    // get all dishes by category 
    public function dishesByCategory(Request $request)
    {
        $request->validate([
            'menu_id' =>'required',
            'category_id' =>'required'
        ]);
        $menu = Menu::find($request->menu_id);
        $allDishes = $menu->categories
                    ->find($request->input('category_id'))
                    ->dishes;
        return DishesResource::collection($allDishes);
    }
    // get all dishes in specific menu 
    public function dishesByMenu(Request $request)
    {
        $request->validate(['menu_id' =>'required']);
        $allDishes = Menu::find($request->menu_id)->dishes;
        return DishesResource::collection($allDishes);
    }

}
