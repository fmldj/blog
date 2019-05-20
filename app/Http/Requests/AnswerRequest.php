<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
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
            'body' => 'required|string|min:10',
        ];
    }

    public function messages()
    {
        return [
            'body.required' => '回答不能为空',
            'body.min' => '回答数不能低于10个字',
        ];
    }
}
