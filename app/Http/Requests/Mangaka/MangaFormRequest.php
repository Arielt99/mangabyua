<?php

namespace App\Http\Requests\Mangaka;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MangaFormRequest extends FormRequest
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
        $uniqueRule = Rule::unique('mangas');

        if(!is_null($this->route()->parameter('manga'))){
            $uniqueRule = Rule::unique('mangas')->ignore($this->route()->parameter('manga'));
        };

        //must have the current mangaka
        $currentMangaka = Rule::in(User::whereRoleIsMangaka()->where('id', Auth::user()->id)->pluck('id'));

        //is mature boolean must be true if any of the tag is mature content
        $isMatureMustBeTrue = null;

        //can't use it because it's a form data now that the cover is send
        // foreach ($this->input('tags') as $tag => $id) {
        //     if(Tag::findOrFail($id)->isMature == 1){
        //         $isMatureMustBeTrue = 'in:1';
        //     }
        // }

        return [
            'title' => ['required','string',$uniqueRule,'max:255'],
            'cover' => ['required', 'image'],
            'mangakas' => ['required','array','min:1'],
            'mangakas.*' => ['required', $currentMangaka],
            'tags' => ['required','array','min:1'],
            'tags.*' => ['required','exists:App\Models\Tag,id'],
            'description' => ['required','string'],
            'isMature' => ['required','boolean', $isMatureMustBeTrue],
        ];
    }
}
