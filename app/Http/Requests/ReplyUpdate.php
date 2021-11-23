<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplyUpdate extends FormRequest
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
            'body' => 'required|string|min:5|max:1000'
        ];
    }

    public function messages()
    {
        return [
            'body.required' => 'Body is required',
            'body.min' => 'Body must be at least 5 characters',
            'body.max' => 'Body must be at most 1000 characters'
        ];
    }
}
