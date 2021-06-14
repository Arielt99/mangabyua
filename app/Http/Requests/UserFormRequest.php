<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserFormRequest extends FormRequest
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
        $uniqueRule = Rule::unique('users');

        $passwordRequirement = 'required';

        if(!is_null($this->route()->parameter('id'))){
            $uniqueRule = Rule::unique('users')->ignore($this->route()->parameter('id'));
            $passwordRequirement = 'nullable';
        };

        return [
            'first_name' => ['nullable','string','max:255'],
            'last_name' => ['nullable','string','max:255'],
            'username' => ['required','string',$uniqueRule,'max:255'],
            'birthday' => ['nullable'],
            'roles' => ['required','array','min:1'],
            'roles.*' => ['required','exists:Spatie\Permission\Models\Role,id'],
            'email' => ['required','string','email',$uniqueRule,'max:255'],
            'password' => [$passwordRequirement,'string',Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),'confirmed'],
        ];
    }
}
