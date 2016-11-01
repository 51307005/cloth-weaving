<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ThemPhieuXuatMocRequest extends Request
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
            'tong_so_cay_moc' => 'required|integer|min:1',
            'tong_so_met' => 'required|integer|min:1',
            'ngay_gio_xuat_kho' => 'required|date'
        ];
    }

    public function messages()
    {
        return [
            'tong_so_cay_moc.required' => 'Bạn chưa nhập tổng số cây mộc !',
            'tong_so_cay_moc.integer' => 'Tổng số cây mộc phải là số nguyên dương !',
            'tong_so_cay_moc.min' => 'Tổng số cây mộc ít nhất phải là 1 !',
            'tong_so_met.required' => 'Bạn chưa nhập tổng số mét !',
            'tong_so_met.integer' => 'Tổng số mét phải là số nguyên dương !',
            'tong_so_met.min' => 'Tổng số mét ít nhất phải là 1 !',
            'ngay_gio_xuat_kho.required' => 'Bạn chưa nhập ngày giờ xuất kho !',
            'ngay_gio_xuat_kho.date' => 'Ngày giờ xuất kho không hợp lệ !'
        ];
    }
}
