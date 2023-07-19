<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'dish_id',
        'name',
        'description',
        'photo',
        'price',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}
