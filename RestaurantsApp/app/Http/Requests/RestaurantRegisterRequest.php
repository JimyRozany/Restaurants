<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RestaurantRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'restaurant_name'=>'required|string|max:55',
            'email'=>'required|email|unique:restaurants,email',
            'password'=>[
                'required',
                Password::min(8)
                ->letters()
                ->symbols()
            ],
            'phone' => 'required|numeric',
            'address'=>'required|string',
            'restaurant_photo'=>'required|image|mimes:jpg,bmp,png',
        ];
    }
}
