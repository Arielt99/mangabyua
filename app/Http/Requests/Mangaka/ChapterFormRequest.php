<?php

namespace App\Http\Requests\Mangaka;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ChapterFormRequest extends FormRequest
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
        //unique title
        $uniqueRule = Rule::unique('chapters')->where(function ($query){
            return $query->where('manga_id', $this->route()->parameter('manga'));
        });

        if(!is_null($this->route()->parameter('chapter'))){
            $uniqueRule = Rule::unique('chapters')->where(function ($query){
                return $query->where('manga_id', $this->route()->parameter('manga'));
            })->ignore($this->route()->parameter('chapter'));
        };

        return [
            'title' => ['required','string',$uniqueRule,'max:255'],
            'number' => ['required', 'numeric', $uniqueRule],
            'medias' => ['required','array','min:1'],
            'medias.*' => ['required','image'],
        ];
    }
}
