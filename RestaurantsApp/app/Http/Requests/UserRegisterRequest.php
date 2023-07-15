<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
  
    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:55',
            'email' => 'nullable|email|unique:users,email',
            'password'=>[
                'nullable',
                Password::min(8)
                ->letters()
                ->symbols(),
            ],
            'phone'=>'nullable|numeric',
            'address' => 'nullable|string',
            'photo'=>'required|image|mimes:jpg,bmp,png',
        ];
    }
}
/**
 *  'name',
       * 'email',
    *    'password',
      *  'phone',
     *   'address',
      *  'photo',
 */