<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CategoriesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
                'id' => $this->id,
                'restaurant_name' => $this->restaurant_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'restaurant_photo' => $this->restaurant_photo,
                'verified' => $this->verified,
                'status' => $this->status,
                'created_at' => $this->created_at->format('Y-m-d H:i:s'),
                'menu' => [
                    'menu_id' => $this->menu->id,
                    'menu_name' => $this->menu->menu_name,
                    'menu_photo' => $this->menu->menu_photo,
                ],
                'categories' => CategoriesResource::collection($this->categories)
                // 'categories' => [
                //     'menu_id' => $this->categories->category->menu->id,
                //     'category_id' => $this->categories->id,
                //     'category_name' => $this->categories->category_namesds,
                // ],
        ];
    }
}
