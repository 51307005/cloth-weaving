<?php

namespace App\Http\Repositories;

use DB;
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
            $nhanVien->id = $thongTin->id;
            $nhanVien->ho_ten = $thongTin->ho_ten;
            $nhanVien->mat_khau = $thongTin->mat_khau;
            $nhanVien->chuc_vu = $thongTin->chuc_vu;
            $nhanVien->quyen = $thongTin->quyen;
            $nhanVien->luong = $thongTin->luong;
            $nhanVien->ghi_chu = $thongTin->ghi_chu;
            $nhanVien->ngay_thang_nam_sinh = $thongTin->ngay_thang_nam_sinh;
            $nhanVien->gioi_tinh = $thongTin->gioi_tinh;
            $nhanVien->dia_chi = $thongTin->dia_chi;
            $nhanVien->email = $thongTin->email;
            $nhanVien->so_dien_thoai = $thongTin->so_dien_thoai;
            $nhanVien->da_xoa = $thongTin->da_xoa;

            return $nhanVien;
        }

        // Username không tồn tại trong database
        return false;
    }

    public function getDanhSachNhanVienDet()
    {
        $list_nhan_vien_det = DB::table('nhan_vien')
                                ->where('da_xoa', '=', 0)
                                ->where('chuc_vu', 'like', '%Nhân viên dệt%')
                                ->get();
        return $list_nhan_vien_det;
    }

    public function getDanhSachNhanVienKhoMoc()
    {
        $list_nhan_vien_kho_moc = DB::table('nhan_vien')
                                    ->where('da_xoa', '=', 0)
                                    ->where('chuc_vu', 'like', '%Nhân viên kho mộc%')
                                    ->get();
        return $list_nhan_vien_kho_moc;
    }
}