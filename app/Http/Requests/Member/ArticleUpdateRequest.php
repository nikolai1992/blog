<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

class ArticleUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = request()->route('id');

        return [
            "name" =>"required|max:255",
            "title" =>"required|max:255",
            'short_description' =>'required|max:450',
            "slug" =>"required|max:255|regex:#^[\w-]#|unique:articles,slug,".$id,
        ];
    }
}
