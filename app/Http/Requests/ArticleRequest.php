<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title' => 'required|min:6|max:100',
            'description' => 'required|max:150',
            'keywords' => 'max:60',
            'body' => 'required|min:10',
            'image' => 'mimes:jpeg,png'
        ];
    }
}
