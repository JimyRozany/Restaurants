<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DishesResource extends JsonResource
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
            'menu_id' => $this->menu_id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'price' => $this->price,
            'time' => $this->time,
            'description' => $this->description,
            'photo' => $this->photo,
        ];
    }
}
