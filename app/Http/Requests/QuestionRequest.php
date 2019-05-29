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
            'title' => 'required|max:255',
            'desc' => 'required|max:255',
            'body' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'title.max' => '标题名字过长',
            'title.required' => '标题名字不能为空',
            'body.required' => '内容不能为空',
            'user_id.required' => '请登录',
            'desc.required' => '描述不能为空',
            'desc.max' => '描述内容过长',
        ];
    }
}
