<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ThemDonHangKhachHangRequest extends Request
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
            'tong_so_met' => 'required|integer|min:1',
            'han_chot' => 'date',
            'ngay_gio_dat_hang' => 'required|date'
        ];
    }

    public function messages()
    {
        return [
            'tong_so_met.required' => 'Bạn chưa nhập tổng số mét !',
            'tong_so_met.integer' => 'Tổng số mét phải là số nguyên dương !',
            'tong_so_met.min' => 'Tổng số mét ít nhất phải là 1 !',
            'han_chot.date' => 'Hạn chót không hợp lệ !',
            'ngay_gio_dat_hang.required' => 'Bạn chưa nhập ngày giờ đặt hàng !',
            'ngay_gio_dat_hang.date' => 'Ngày giờ đặt hàng không hợp lệ !'
        ];
    }
}
