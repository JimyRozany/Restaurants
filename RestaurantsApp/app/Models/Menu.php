<?php

namespace App\Models;

use App\Models\Dish;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'menu_name',
        'menu_photo',
    ];

    /**    ******** relationships  **********  */

    public function restaurant ()
    {
        return $this->belongsTo(Restaurant::class);
    }
    public function categories ()
    {
        return $this->hasMany(Category::class);
    }
    public function dishes ()
    {
        return $this->hasMany(Dish::class);
    }

}
