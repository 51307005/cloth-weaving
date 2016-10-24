<?php

namespace App\Http\Repositories;

use App\Http\Entities\NhanVien;

class NhanVienRepository
{
    public function getNhanVienByUsername($username)
    {
        $nhanVien = new NhanVien();
        $nhanVien->ten_dang_nhap = $username;
        $thongTin = $nhanVien->getThongTinByUsername();

        if (count($thongTin) == 1)  // Lấy được thông tin của nhân viên bằng username
        {
            $nhanVien->id = $thongTin[0]->id;
            $nhanVien->ho_ten = $thongTin[0]->ho_ten;
            $nhanVien->mat_khau = $thongTin[0]->mat_khau;
            $nhanVien->chuc_vu = $thongTin[0]->chuc_vu;
            $nhanVien->quyen = $thongTin[0]->quyen;
            $nhanVien->luong = $thongTin[0]->luong;
            $nhanVien->ghi_chu = $thongTin[0]->ghi_chu;
            $nhanVien->ngay_thang_nam_sinh = $thongTin[0]->ngay_thang_nam_sinh;
            $nhanVien->gioi_tinh = $thongTin[0]->gioi_tinh;
            $nhanVien->dia_chi = $thongTin[0]->dia_chi;
            $nhanVien->email = $thongTin[0]->email;
            $nhanVien->so_dien_thoai = $thongTin[0]->so_dien_thoai;
            $nhanVien->da_xoa = $thongTin[0]->da_xoa;

            return $nhanVien;
        }

        // Username không tồn tại trong database
        return false;
    }
}