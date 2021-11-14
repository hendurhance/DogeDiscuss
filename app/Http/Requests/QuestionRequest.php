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
            'title' => 'required|string|min:5|max:255',
            'body' => 'required|string|min:5',
            'category_id' => 'required|integer|exists:categories,id',
            'user_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'title.string' => 'The title must be a string',
            'title.min' => 'A title must be at least :min characters',
            'title.max' => 'A title must be at most :max characters',
            'body.required' => 'A body is required',
            'body.string' => 'The body must be a string',
            'body.min' => 'A body must be at least :min characters',
            'category_id.required' => 'A category is required',
            'category_id.integer' => 'A category must be an integer',
            'category_id.exists' => 'The category must exist',
            'user_id.required' => 'A user is required',
            'user_id.integer' => 'A user must be an integer',
        ];
    }
}
