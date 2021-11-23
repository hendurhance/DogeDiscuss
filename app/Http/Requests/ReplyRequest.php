<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplyRequest extends FormRequest
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
            'question_id' => 'required|integer',
            'body' => 'required|string|min:5',
            'user_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'question_id.required' => 'Question id is required',
            'question_id.integer' => 'Question id must be an integer',
            'body.required' => 'Body is required',
            'body.string' => 'Body must be a string',
            'body.min' => 'Body must be at least 5 characters',
            'user_id.required' => 'User id is required',
            'user_id.integer' => 'User id must be an integer',
        ];
    }
}
