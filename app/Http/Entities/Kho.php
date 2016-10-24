<?php

namespace App\Http\Entities;

use DB;

class Kho
{
    var $id;
    var $ten;
    var $id_nhan_vien_quan_ly;
    var $dien_tich;
    var $dia_chi;
    var $so_dien_thoai;
    var $da_xoa;

    public function getThongTinById()
    {
        $thongTin = DB::table('kho')
                      ->where('da_xoa', '=', 0)
                      ->where('id', '=', $this->id)
                      ->first();
        return $thongTin;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTen()
    {
        return $this->ten;
    }

    public function getId_nhan_vien_quan_ly()
    {
        return $this->id_nhan_vien_quan_ly;
    }

    public function getDien_tich()
    {
        return $this->dien_tich;
    }

    public function getDia_chi()
    {
        return $this->dia_chi;
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

    public function setTen($ten)
    {
        $this->ten = $ten;
    }

    public function setId_nhan_vien_quan_ly($id_nhan_vien_quan_ly)
    {
        $this->id_nhan_vien_quan_ly = $id_nhan_vien_quan_ly;
    }

    public function setDien_tich($dien_tich)
    {
        $this->dien_tich = $dien_tich;
    }

    public function setDia_chi($dia_chi)
    {
        $this->dia_chi = $dia_chi;
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