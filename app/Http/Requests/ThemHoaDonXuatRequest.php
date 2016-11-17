<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ThemHoaDonXuatRequest extends Request
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
            'tong_so_cay_vai' => 'required|integer|min:1',
            'tong_so_met' => 'required|integer|min:1',
            'tong_tien' => 'required|integer|min:1',
            'ngay_gio_xuat_hoa_don' => 'required|date'
        ];
    }

    public function messages()
    {
        return [
            'tong_so_cay_vai.required' => 'Bạn chưa nhập tổng số cây vải !',
            'tong_so_cay_vai.integer' => 'Tổng số cây vải phải là số nguyên dương !',
            'tong_so_cay_vai.min' => 'Tổng số cây vải ít nhất phải là 1 !',
            'tong_so_met.required' => 'Bạn chưa nhập tổng số mét !',
            'tong_so_met.integer' => 'Tổng số mét phải là số nguyên dương !',
            'tong_so_met.min' => 'Tổng số mét ít nhất phải là 1 !',
            'tong_tien.required' => 'Bạn chưa nhập tổng tiền !',
            'tong_tien.integer' => 'Tổng tiền phải là số nguyên dương !',
            'tong_tien.min' => 'Tổng tiền ít nhất phải là 1 !',
            'ngay_gio_xuat_hoa_don.required' => 'Bạn chưa nhập ngày giờ xuất hóa đơn !',
            'ngay_gio_xuat_hoa_don.date' => 'Ngày giờ xuất hóa đơn không hợp lệ !'
        ];
    }
}
