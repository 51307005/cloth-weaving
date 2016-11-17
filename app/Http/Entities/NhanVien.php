<?php

namespace App\Http\Entities;

use DB;

class NhanVien
{
    var $id;
    var $ho_ten;
    var $ten_dang_nhap;
    var $mat_khau;
    var $chuc_vu;
    var $quyen;
    var $luong;
    var $ghi_chu;
    var $ngay_thang_nam_sinh;
    var $gioi_tinh;
    var $dia_chi;
    var $email;
    var $so_dien_thoai;
    var $da_xoa;

    public function getThongTinByUsername()
    {
        $thongTin = DB::table('nhan_vien')
                      ->where('da_xoa', '=', 0)
                      ->where('ten_dang_nhap', '=', $this->ten_dang_nhap)
                      ->first();
        return $thongTin;
    }

    public function getThongTinById()
    {
        $thongTin = DB::table('nhan_vien')
                      ->where('da_xoa', '=', 0)
                      ->where('id', '=', $this->id)
                      ->first();
        return $thongTin;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getHo_ten()
    {
        return $this->ho_ten;
    }

    public function getTen_dang_nhap()
    {
        return $this->ten_dang_nhap;
    }

    public function getMat_khau()
    {
        return $this->mat_khau;
    }

    public function getChuc_vu()
    {
        return $this->chuc_vu;
    }

    public function getQuyen()
    {
        return $this->quyen;
    }

    public function getLuong()
    {
        return $this->luong;
    }

    public function getGhi_chu()
    {
        return $this->ghi_chu;
    }

    public function getNgay_thang_nam_sinh()
    {
        return $this->ngay_thang_nam_sinh;
    }

    public function getGioi_tinh()
    {
        return $this->gioi_tinh;
    }

    public function getDia_chi()
    {
        return $this->dia_chi;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getSo_dien_thoai()
    {
        return $this->so_dien_thoai;
    }

    public function getDa_xoa()
    {
        return $this->da_xoa;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setHo_ten($ho_ten)
    {
        $this->ho_ten = $ho_ten;
    }

    public function setTen_dang_nhap($ten_dang_nhap)
    {
        $this->ten_dang_nhap = $ten_dang_nhap;
    }

    public function setMat_khau($mat_khau)
    {
        $this->mat_khau = $mat_khau;
    }

    public function setChuc_vu($chuc_vu)
    {
        $this->chuc_vu = $chuc_vu;
    }

    public function setQuyen($quyen)
    {
        $this->quyen = $quyen;
    }

    public function setLuong($luong)
    {
        $this->luong = $luong;
    }

    public function setGhi_chu($ghi_chu)
    {
        $this->ghi_chu = $ghi_chu;
    }

    public function setNgay_thang_nam_sinh($ngay_thang_nam_sinh)
    {
        $this->ngay_thang_nam_sinh = $ngay_thang_nam_sinh;
    }

    public function setGioi_tinh($gioi_tinh)
    {
        $this->gioi_tinh = $gioi_tinh;
    }

    public function setDia_chi($dia_chi)
    {
        $this->dia_chi = $dia_chi;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setSo_dien_thoai($so_dien_thoai)
    {
        $this->so_dien_thoai = $so_dien_thoai;
    }

    public function setDa_xoa($da_xoa)
    {
        $this->da_xoa = $da_xoa;
    }
}