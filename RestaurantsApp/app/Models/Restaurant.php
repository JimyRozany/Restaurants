<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
