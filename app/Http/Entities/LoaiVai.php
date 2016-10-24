<?php

namespace App\Http\Entities;

use DB;

class LoaiVai
{
    var $id;
    var $ten;
    var $don_gia;
    var $da_xoa;

    public function getThongTinById()
    {
        $thongTin = DB::table('loai_vai')
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

    public function getDon_gia()
    {
        return $this->don_gia;
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

    public function setDon_gia($don_gia)
    {
        $this->don_gia = $don_gia;
    }

    public function setDa_xoa($da_xoa)
    {
        $this->da_xoa = $da_xoa;
    }
}