<?php

namespace App\Models;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Restaurant extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'restaurant_name',
        'email',
        'password',
        'phone',
        'address',
        'restaurant_photo',
        'verified', // verify restaurant from admin
        'status', // open | closed | maintenance 
    ];



     /*************** from jwt pkg ********** */
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /***************** relationships *************** */

    public function menu()
    {
        return $this->hasOne(Menu::class);
    }
    public function categories()
    {
        return $this->hasManyThrough(Category::class ,Menu::class);
        // return $this->hasManyThrough(Category::class ,Menu::class);
    }

    public function orders (){
        return $this->hasMany(Order::class);
    }
    public function orderItems (){
        return $this->hasManyThrough(OrderItem::class ,Order::class);
    }
}
