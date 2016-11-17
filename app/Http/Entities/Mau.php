<?php

namespace App\Http\Entities;

use DB;

class Mau
{
    var $id;
    var $ten;
    var $cong_thuc;
    var $id_nhan_vien_pha_che;
    var $ngay_gio_tao;
    var $da_xoa;

    public function getThongTinById()
    {
        $thongTin = DB::table('mau')
                      ->leftJoin('nhan_vien', 'mau.id_nhan_vien_pha_che', '=', 'nhan_vien.id')
                      ->select('mau.*', 'nhan_vien.ho_ten as ten_nhan_vien_pha_che')
                      ->where('mau.da_xoa', '=', 0)
                      ->where('mau.id', '=', $this->id)
                      ->first();
        return $thongTin;
    }

    function getId()
    {
        return $this->id;
    }

    function getTen()
    {
        return $this->ten;
    }

    function getCong_thuc()
    {
        return $this->cong_thuc;
    }

    function getId_nhan_vien_pha_che()
    {
        return $this->id_nhan_vien_pha_che;
    }

    function getNgay_gio_tao()
    {
        return $this->ngay_gio_tao;
    }

    function getDa_xoa()
    {
        return $this->da_xoa;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setTen($ten)
    {
        $this->ten = $ten;
    }

    function setCong_thuc($cong_thuc)
    {
        $this->cong_thuc = $cong_thuc;
    }

    function setId_nhan_vien_pha_che($id_nhan_vien_pha_che)
    {
        $this->id_nhan_vien_pha_che = $id_nhan_vien_pha_che;
    }

    function setNgay_gio_tao($ngay_gio_tao)
    {
        $this->ngay_gio_tao = $ngay_gio_tao;
    }

    function setDa_xoa($da_xoa)
    {
        $this->da_xoa = $da_xoa;
    }
}