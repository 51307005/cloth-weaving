<?php

namespace App\Http\Repositories;

use DB;
use App\Http\Entities\NhanVien;

class NhanVienRepository
{
    public function getNhanVienByUsername($username)
    {
        $nhan_vien = new NhanVien();
        $nhan_vien->ten_dang_nhap = $username;
        $thongTin = $nhan_vien->getThongTinByUsername();

        if (count($thongTin) == 1)  // Lấy được thông tin của nhân viên bằng username
        {
            $nhan_vien->id = $thongTin->id;
            $nhan_vien->ho_ten = $thongTin->ho_ten;
            $nhan_vien->mat_khau = $thongTin->mat_khau;
            $nhan_vien->chuc_vu = $thongTin->chuc_vu;
            $nhan_vien->quyen = $thongTin->quyen;
            $nhan_vien->luong = $thongTin->luong;
            $nhan_vien->ghi_chu = $thongTin->ghi_chu;
            $nhan_vien->ngay_thang_nam_sinh = $thongTin->ngay_thang_nam_sinh;
            $nhan_vien->gioi_tinh = $thongTin->gioi_tinh;
            $nhan_vien->dia_chi = $thongTin->dia_chi;
            $nhan_vien->email = $thongTin->email;
            $nhan_vien->so_dien_thoai = $thongTin->so_dien_thoai;
            $nhan_vien->da_xoa = $thongTin->da_xoa;

            return $nhan_vien;
        }

        // Username không tồn tại trong database
        return false;
    }

    public function getNhanVienById($id_nhan_vien)
    {
        $nhan_vien = new NhanVien();
        $nhan_vien->id = $id_nhan_vien;
        $thongTin = $nhan_vien->getThongTinById();

        if (count($thongTin) == 1)  // Lấy được thông tin của nhân viên bằng id
        {
            $nhan_vien->ho_ten = $thongTin->ho_ten;
            $nhan_vien->ten_dang_nhap = $thongTin->ten_dang_nhap;
            $nhan_vien->mat_khau = $thongTin->mat_khau;
            $nhan_vien->chuc_vu = $thongTin->chuc_vu;
            $nhan_vien->quyen = $thongTin->quyen;
            $nhan_vien->luong = $thongTin->luong;
            $nhan_vien->ghi_chu = $thongTin->ghi_chu;
            $nhan_vien->ngay_thang_nam_sinh = $thongTin->ngay_thang_nam_sinh;
            $nhan_vien->gioi_tinh = $thongTin->gioi_tinh;
            $nhan_vien->dia_chi = $thongTin->dia_chi;
            $nhan_vien->email = $thongTin->email;
            $nhan_vien->so_dien_thoai = $thongTin->so_dien_thoai;
            $nhan_vien->da_xoa = $thongTin->da_xoa;

            return $nhan_vien;
        }

        // Id nhân viên không tồn tại trong database
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

    public function getDanhSachNhanVienXuatHoaDon()
    {
        $list_nhan_vien_xuat_hoa_don = DB::table('nhan_vien')
                                         ->where('da_xoa', '=', 0)
                                         ->where('chuc_vu', 'like', '%Nhân viên Bán hàng%')
                                         ->get();
        return $list_nhan_vien_xuat_hoa_don;
    }
}