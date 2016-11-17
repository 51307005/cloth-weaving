<?php

namespace App\Http\Entities;

use DB;

class KhachHang
{
    var $id;
    var $ho_ten;
    var $ten_dang_nhap;
    var $mat_khau;
    var $dia_chi;
    var $email;
    var $so_dien_thoai;
    var $cong_no;
    var $da_xoa;

    public function getThongTinByUsername()
    {
        $thongTin = DB::table('khach_hang')
                      ->where('da_xoa', '=', 0)
                      ->where('ten_dang_nhap', '=', $this->ten_dang_nhap)
                      ->first();
        return $thongTin;
    }

    public function getThongTinById()
    {
        $thongTin = DB::table('khach_hang')
                      ->where('da_xoa', '=', 0)
                      ->where('id', '=', $this->id)
                      ->first();
        return $thongTin;
    }

    function getId()
    {
        return $this->id;
    }

    function getHo_ten()
    {
        return $this->ho_ten;
    }

    function getTen_dang_nhap()
    {
        return $this->ten_dang_nhap;
    }

    function getMat_khau()
    {
        return $this->mat_khau;
    }

    function getDia_chi()
    {
        return $this->dia_chi;
    }

    function getEmail()
    {
        return $this->email;
    }

    function getSo_dien_thoai()
    {
        return $this->so_dien_thoai;
    }

    function getCong_no()
    {
        return $this->cong_no;
    }

    function getDa_xoa()
    {
        return $this->da_xoa;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setHo_ten($ho_ten)
    {
        $this->ho_ten = $ho_ten;
    }

    function setTen_dang_nhap($ten_dang_nhap)
    {
        $this->ten_dang_nhap = $ten_dang_nhap;
    }

    function setMat_khau($mat_khau)
    {
        $this->mat_khau = $mat_khau;
    }

    function setDia_chi($dia_chi)
    {
        $this->dia_chi = $dia_chi;
    }

    function setEmail($email)
    {
        $this->email = $email;
    }

    function setSo_dien_thoai($so_dien_thoai)
    {
        $this->so_dien_thoai = $so_dien_thoai;
    }

    function setCong_no($cong_no)
    {
        $this->cong_no = $cong_no;
    }

    function setDa_xoa($da_xoa)
    {
        $this->da_xoa = $da_xoa;
    }
}