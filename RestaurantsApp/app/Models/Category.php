<?php

namespace App\Models;

use App\Models\Dish;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'menu_id',
        'category_name',
    ] ;

    /********************** relationships ***************** */

    public function menu ()
    {
        return $this->belongsTo(Menu::class);
    }
    public function dishes ()
    {
        return $this->hasMany(Dish::class);
    }
}
