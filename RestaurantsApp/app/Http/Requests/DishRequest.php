<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DishRequest extends FormRequest
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
            'category_id'=>'required',
            'name'=>'required|string',
            'price' => 'required|numeric',
            'time' => 'required|numeric',
            'description'=>'required|string',
            'photo'=>'required|image|mimes:jpg,bmp,png',
        ];
    }
}
