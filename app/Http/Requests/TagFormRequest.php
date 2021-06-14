<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TagFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::user()->hasRole('Super-Admin')){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $uniqueRule = Rule::unique('tags');

        if(!is_null($this->route()->parameter('tag'))){
            $uniqueRule = Rule::unique('tags')->ignore($this->route()->parameter('tag'));
        };

        return [
            'name' => ['required','string',$uniqueRule,'max:255'],
            'slug' => ['nullable','regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',$uniqueRule,'max:255'],
            'isMature' => ['required','boolean'],
        ];
    }
}
