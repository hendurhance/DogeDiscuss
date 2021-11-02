<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'title' => 'required|min:5|max:255',
            'slug' => 'required|min:5|max:255|unique:questions,slug',
            'body' => 'required|min:5',
            'category_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'title.min' => 'A title must be at least :min characters',
            'title.max' => 'A title must be at most :max characters',
            'slug.required' => 'A slug is required',
            'slug.min' => 'A slug must be at least :min characters',
            'slug.max' => 'A slug must be at most :max characters',
            'slug.unique' => 'A slug must be unique',
            'body.required' => 'A body is required',
            'body.min' => 'A body must be at least :min characters',
            'category_id.required' => 'A category is required',
            'category_id.integer' => 'A category must be an integer',
            'user_id.required' => 'A user is required',
            'user_id.integer' => 'A user must be an integer',
        ];
    }
}
