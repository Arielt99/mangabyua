<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'last_name' => 'required|string|between:2,100',
            'first_name' => 'required|string|between:2,100',
            'username' => 'required|string|max:100|unique:users',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ];
    }
}
