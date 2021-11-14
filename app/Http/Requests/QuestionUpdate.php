<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionUpdate extends FormRequest
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
            // all fields are for update only
            'title' => 'string|max:255',
            'body' => 'string|max:255',
            'category_id' => 'integer|exists:categories,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.string' => 'Title must be a string',
            'title.max' => 'Title must be less than 255 characters',
            'body.string' => 'Body must be a string',
            'body.max' => 'Body must be less than 255 characters',
            'category_id.integer' => 'Category ID must be an integer',
            'category_id.exists' => 'Category ID must exist in the database',
        ];
    }
}
