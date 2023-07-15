<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dish extends Model
{
    use HasFactory;
    protected $fillable = [
        'menu_id',
        'category_id',
        'name',
        'price',
        'time',
        'description',
        'photo',
    ];

    /************** relationships ************* */

    public function menu(){
        return $this->belongsTo(Menu::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
}

