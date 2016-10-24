<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DangNhapHeThongRequest extends Request
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
            'username' => 'required|min:2',
            'password' => 'required|min:6'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Bạn chưa nhập tên đăng nhập !',
            'password.required' => 'Bạn chưa nhập mật khẩu !',
            'username.min' => 'Tên đăng nhập phải dài ít nhất 2 ký tự !',
            'password.min' => 'Mật khẩu phải dài ít nhất 6 ký tự !'
        ];
    }
}
