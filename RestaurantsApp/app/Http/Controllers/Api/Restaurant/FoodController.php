<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Models\Dish;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\DishRequest;
use App\Http\Controllers\Controller;
use App\Models\Extra;
use Illuminate\Support\Facades\File;

class FoodController extends Controller
{
    /** add categories  */
    public function addCategory(Request $request)
    {
        // validation 
        $request->validate([
            'category_name'=>'required'
        ]);
        $restaurant = auth('restaurant-guard')->user();
        $category = Category::create([
            'menu_id' => $restaurant->menu->id ,
            'category_name' => $request->category_name
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Added category',
        ] ,201);
    }
    /**  add dish */
    public function addDish(DishRequest $request)
    {
       try {
            $restaurant = auth('restaurant-guard')->user();
            $data = $request->validated();
            // handle photo 
            $newNameImage = time() .'.' . $data['photo']->getClientOriginalExtension();
            $data['photo']->move(public_path('images/restaurant/'.$restaurant->email ), $newNameImage);
            $path_image = 'images/restaurant/'.$restaurant->email .'/' . $newNameImage ;
            $dish = Dish::create([
                'menu_id' => $restaurant->menu->id,
                'category_id'=>$data['category_id'],
                'name'=>$data['name'],
                'price'=>$data['price'],
                'time'=>$data['time'],
                'description'=>$data['description'],
                'photo' => $path_image
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'dish created',
            ]);
       } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => 'something error',
                // 'exception' => $ex->getMessage()
            ]);
       }
    }
    /** edit dish */
    public function editDish(Request $request)
    {
        $data = $request->validate([
            'dish_id' => 'required',
            'category_id'=>'nullable',
            'name'=>'nullable|string',
            'price' => 'nullable|numeric',
            'time' => 'nullable|numeric',
            'description'=>'nullable|string',
            'photo'=>'nullable|image|mimes:jpg,bmp,png',
        ]);
        
        $dish = Dish::find($request->dish_id);
        $restaurant = auth('restaurant-guard')->user();
        if($restaurant->menu->id === $dish->menu_id){
            if($request->file('photo')){
                // Delete the previous image and add a new one
                if(File::exists(public_path($dish->photo))) {
                    File::delete(public_path($dish->photo));
                }

                $newNameImage = time() .'.' . $request->file('photo')->getClientOriginalExtension();
                $request->file('photo')->move(public_path('images/restaurant/'.$restaurant->email ), $newNameImage);
                $path_image = 'images/restaurant/'.$restaurant->email .'/' . $newNameImage ;

                $dish->update([
                    'category_id'=>$request->category_id ? $request->category_id : $dish->category_id,
                    'name'=>$request->name ?$request->name :$dish->name,
                    'price' => $request->price ? $request->price:$dish->price,
                    'time' =>  $request->time ?  $request->time : $dish->time,
                    'description'=>$request->description ? $request->description : $dish->description,
                    'photo'=>$path_image ,
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' =>'dish updated'
                ] ,200);
            }else{
                $dish->update($data);
                return response()->json([
                    'status' => 'success',
                    'message' =>'dish updated'
                ] ,200);
            }
        }else{

            return response()->json([
                'status' => 'error',
                'message' =>'unauthorized'
            ] ,401);
        }
    }
    /** delete dish */
    public function destroy(Request $request)
    {
      try {
        $request->validate([
            'dish_id'=> 'required'
        ]);

        $dish = Dish::find($request->dish_id);
        $restaurant = auth('restaurant-guard')->user();
        if($restaurant->menu->id === $dish->menu_id)
        {
            /** remove dish photo */
            if(File::exists(public_path($dish->photo))) {
                File::delete(public_path($dish->photo));
            }
            $dish->delete();
            return response()->json([
                'status' => 'success',
                'message' =>'dish deleted'
            ] ,200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' =>'unauthorized'
            ] ,401);
        }
      } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' =>$ex->getMessage()
            ]);
      }
    }
    /** add extras to dish */
    public function addExtra(Request $request)
    {
      try {
        $request->validate([
            'menu_id'=> 'required',
            'dish_id'=> 'required',
            'name'=> 'required|string',
            'description'=> 'required|string',
            'photo'=> 'required|image|mimes:jpg,bmp,png',
            'price'=> 'required|numeric',
        ]);

        $dish = Dish::find($request->dish_id);
        $restaurant = auth('restaurant-guard')->user();
        if($restaurant->menu->id === $dish->menu_id)
        {
            // handle photo 
            $newNameImage = time()  . '.'. $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(public_path('images/restaurant/'.$restaurant->email .'/extras/') ,$newNameImage);
            $path_image = 'images/restaurant/'.$restaurant->email .'/extras/'.$newNameImage;
            $extra =Extra::create([
                'menu_id'=> $request->menu_id,
                'dish_id'=> $dish->id,
                'name'=> $request->name,
                'description'=> $request->description,
                'photo'=> $path_image ,
                'price'=> $request->price,
            ]);
            return response()->json([
                'status' => 'success',
                'message' =>'extra added successful'
            ] ,201);
        }else{
            return response()->json([
                'status' => 'error',
                'message' =>'unauthorized'
            ] ,401);
        }
      } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' =>$ex->getMessage()
            ]);
      }
    }
    /** edit extra */
    public function editExtra(Request $request)
    {
        // i need  dish id  ,extra id and restaurant id 
        $data = $request->validate([
            'dish_id'=> 'required',
            'extra_id'=> 'required',
            'name'=> 'nullable|string',
            'description'=> 'nullable|string',
            'photo'=> 'nullable|image|mimes:jpg,bmp,png',
            'price'=> 'nullable|numeric',
        ]);
        $dish = Dish::find($request->dish_id);
        $extra = $dish->extras->find($request->extra_id);
        $restaurant = auth('restaurant-guard')->user();
        if($restaurant->menu->id === $dish->menu_id){
            if(!$request->file('photo')){
                $extra->update($data);
                 return response()->json([
                    'status' => 'success',
                    'message' =>'extra updated'
                ] ,200);
            }else{
                /** remove previous image */
                if(File::exists(public_path($extra->photo))) {
                    File::delete(public_path($extra->photo));
                }
                $newNameImage = time() . '.' . $request->file('photo')->getClientOriginalExtension();
                $request->file('photo')->move(public_path('images/restaurant/' . $restaurant->email .'/extras/'),$newNameImage);
                $path_image = 'images/restaurant/' . $restaurant->email .'/extras/' . $newNameImage;
                $extra->update([
                    'name' => $data['name'] ? $data['name'] : $extra->name ,
                    'description'=>$data['description'] ? $data['description'] : $extra->description  ,
                    'photo'=>$path_image ,
                    'price'=>$data['price'] ? $data['price'] : $extra->description  , 
                ]);
                 return response()->json([
                    'status' => 'success',
                    'message' =>'extra updated'
                ] ,200);

            }
        }else{
             return response()->json([
                    'status' => 'error',
                    'message' =>'unauthenticated'
                ] ,401);
        }
    }
    /** remove extra  */
    public function removeExtra(Request $request)
    {
        $request->validate([
            'dish_id'=> 'required',
            'extra_id'=> 'required',
        ]);
        $dish = Dish::find($request->dish_id);
        $extra = $dish->extras->find($request->extra_id);
        $restaurant = auth('restaurant-guard')->user();
        if($restaurant->menu->id === $dish->menu_id){
            /** remove image */
            if(File::exists(public_path($extra->photo))){
                File::delete(public_path($extra->photo));
            }
            $extra->delete();
            return response()->json([
                'status' => 'success',
                'message' =>'extra deleted successfully'
            ] ,200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' =>'unauthenticated'
            ] ,401);
        }

    }
}
