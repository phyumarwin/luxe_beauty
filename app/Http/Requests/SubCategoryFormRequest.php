<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryFormRequest extends FormRequest
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
            'name'=>['required','string'],
            'category_id'=>['required','integer'],
            'slug'=>['required','string'],
            'description'=>['required',],
            'image'=>['nullable','mimes:png,jpg,jpeg'],
            'meta_title'=>['required','string'],
            'meta_keyword'=>['required','string'],
            'meta_description'=>['required','string'],
        ];
    }
}
