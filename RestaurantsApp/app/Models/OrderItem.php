<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'dish_id',
        'extra_id',
        'dish_quantity',
        'extra_quantity',
    ];

    public function order (){
        return $this->belongsTo(Order::class);
    }
}
