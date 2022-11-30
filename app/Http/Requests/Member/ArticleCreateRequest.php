<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

class ArticleCreateRequest extends FormRequest
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
        return [
            //
            "name" =>"required|max:255",
            "title" =>"required|max:255",
            'image' =>'required|image|mimes:jpeg,png,jpg',
            'short_description' =>'required|max:450',
            "slug" =>"required|max:255|regex:#^[\w-]#|unique:articles,slug",
        ];
    }
}
