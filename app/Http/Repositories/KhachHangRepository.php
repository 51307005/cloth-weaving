<?php

namespace App\Http\Repositories;

use DB;
use App\Http\Entities\KhachHang;

class KhachHangRepository
{
    public function getKhachHangByUsername($username)
    {
        $khach_hang = new KhachHang();
        $khach_hang->ten_dang_nhap = $username;
        $thongTin = $khach_hang->getThongTinByUsername();

        if (count($thongTin) == 1)  // Lấy được thông tin của khách hàng bằng username
        {
            $khach_hang->id = $thongTin->id;
            $khach_hang->ho_ten = $thongTin->ho_ten;
            $khach_hang->mat_khau = $thongTin->mat_khau;
            $khach_hang->dia_chi = $thongTin->dia_chi;
            $khach_hang->email = $thongTin->email;
            $khach_hang->so_dien_thoai = $thongTin->so_dien_thoai;
            $khach_hang->cong_no = $thongTin->cong_no;
            $khach_hang->da_xoa = $thongTin->da_xoa;

            return $khach_hang;
        }

        // Username không tồn tại trong database
        return false;
    }

    public function getKhachHangById($id_khach_hang)
    {
        $khach_hang = new KhachHang();
        $khach_hang->id = $id_khach_hang;
        $thongTin = $khach_hang->getThongTinById();

        if (count($thongTin) == 1)  // Lấy được thông tin của khách hàng bằng id
        {
            $khach_hang->ho_ten = $thongTin->ho_ten;
            $khach_hang->ten_dang_nhap = $thongTin->ten_dang_nhap;
            $khach_hang->mat_khau = $thongTin->mat_khau;
            $khach_hang->dia_chi = $thongTin->dia_chi;
            $khach_hang->email = $thongTin->email;
            $khach_hang->so_dien_thoai = $thongTin->so_dien_thoai;
            $khach_hang->cong_no = $thongTin->cong_no;
            $khach_hang->da_xoa = $thongTin->da_xoa;

            return $khach_hang;
        }

        // Id khách hàng không tồn tại trong database
        return false;
    }

    public function getDanhSachKhachHang()
    {
        $list_khach_hang = DB::table('khach_hang')
                             ->where('da_xoa', '=', 0)
                             ->get();
        return $list_khach_hang;
    }
}