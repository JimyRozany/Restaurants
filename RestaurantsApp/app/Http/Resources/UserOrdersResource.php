<?php

namespace App\Http\Resources;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserOrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $restaurant = Restaurant::find($this->restaurant_id);
        return [
            'order_id' => $this->id,
            'restaurant_name' => $restaurant->restaurant_name,
            'restaurant_id' => $restaurant->id,
            'user_address' => $this->user_address,
            'total_amount' => $this->total_amount,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
