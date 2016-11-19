<?php

namespace App\Http\Entities;

use DB;

class LoNhuom
{
    var $id;
    var $id_mau;
    var $id_nhan_vien_nhuom;
    var $ngay_gio_nhuom;
    var $da_xoa;

    public function getThongTinById()
    {
        $thongTin = DB::table('lo_nhuom')
                      ->join('mau', 'lo_nhuom.id_mau', '=', 'mau.id')
                      ->leftJoin('nhan_vien', 'lo_nhuom.id_nhan_vien_nhuom', '=', 'nhan_vien.id')
                      ->select('lo_nhuom.*', 'mau.ten as ten_mau', 'nhan_vien.ho_ten as ten_nhan_vien_nhuom')
                      ->where('lo_nhuom.da_xoa', '=', 0)
                      ->where('lo_nhuom.id', '=', $this->id)
                      ->first();
        return $thongTin;
    }

    function getId()
    {
        return $this->id;
    }

    function getId_mau()
    {
        return $this->id_mau;
    }

    function getId_nhan_vien_nhuom()
    {
        return $this->id_nhan_vien_nhuom;
    }

    function getNgay_gio_nhuom()
    {
        return $this->ngay_gio_nhuom;
    }

    function getDa_xoa()
    {
        return $this->da_xoa;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setId_mau($id_mau)
    {
        $this->id_mau = $id_mau;
    }

    function setId_nhan_vien_nhuom($id_nhan_vien_nhuom)
    {
        $this->id_nhan_vien_nhuom = $id_nhan_vien_nhuom;
    }

    function setNgay_gio_nhuom($ngay_gio_nhuom)
    {
        $this->ngay_gio_nhuom = $ngay_gio_nhuom;
    }

    function setDa_xoa($da_xoa)
    {
        $this->da_xoa = $da_xoa;
    }
}