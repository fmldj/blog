<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => '原始密码不能为空',
            'password.required' => '新密码不能为空',
            'password.min' => '新密码长度不能小于6位',
            'password.confirmed' => '2次密码输入不一致',
        ];
    }
}
