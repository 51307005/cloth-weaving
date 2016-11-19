<?php

namespace App\Http\Entities;

use DB;

class ThuChi
{
    var $id;
    var $loai;
    var $id_nha_cung_cap;
    var $id_khach_hang;
    var $so_tien;
    var $ngay_gio;
    var $phuong_thuc;
    var $da_xoa;

    public function getThongTinById()
    {
        $thongTin = DB::table('thu_chi')
                      ->leftJoin('nha_cung_cap', 'thu_chi.id_nha_cung_cap', '=', 'nha_cung_cap.id')
                      ->leftJoin('khach_hang', 'thu_chi.id_khach_hang', '=', 'khach_hang.id')
                      ->select('thu_chi.*', 'nha_cung_cap.ten as ten_nha_cung_cap', 'khach_hang.ho_ten as ten_khach_hang')
                      ->where('thu_chi.da_xoa', '=', 0)
                      ->where('thu_chi.id', '=', $this->id)
                      ->first();
        return $thongTin;
    }

    function getId()
    {
        return $this->id;
    }

    function getLoai()
    {
        return $this->loai;
    }

    function getId_nha_cung_cap()
    {
        return $this->id_nha_cung_cap;
    }

    function getId_khach_hang()
    {
        return $this->id_khach_hang;
    }

    function getSo_tien()
    {
        return $this->so_tien;
    }

    function getNgay_gio()
    {
        return $this->ngay_gio;
    }

    function getPhuong_thuc()
    {
        return $this->phuong_thuc;
    }

    function getDa_xoa()
    {
        return $this->da_xoa;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setLoai($loai)
    {
        $this->loai = $loai;
    }

    function setId_nha_cung_cap($id_nha_cung_cap)
    {
        $this->id_nha_cung_cap = $id_nha_cung_cap;
    }

    function setId_khach_hang($id_khach_hang)
    {
        $this->id_khach_hang = $id_khach_hang;
    }

    function setSo_tien($so_tien)
    {
        $this->so_tien = $so_tien;
    }

    function setNgay_gio($ngay_gio)
    {
        $this->ngay_gio = $ngay_gio;
    }

    function setPhuong_thuc($phuong_thuc)
    {
        $this->phuong_thuc = $phuong_thuc;
    }

    function setDa_xoa($da_xoa)
    {
        $this->da_xoa = $da_xoa;
    }
}