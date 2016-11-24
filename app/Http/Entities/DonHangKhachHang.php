<?php

namespace App\Http\Entities;

use DB;

class DonHangKhachHang
{
    var $id;
    var $id_khach_hang;
    var $id_loai_vai;
    var $id_mau;
    var $kho;
    var $tong_so_met;
    var $han_chot;
    var $ngay_gio_dat_hang;
    var $tinh_trang;
    var $da_xoa;

    public function getThongTinById()
    {
        $thongTin = DB::table('don_hang_khach_hang')
                      ->join('khach_hang', 'don_hang_khach_hang.id_khach_hang', '=', 'khach_hang.id')
                      ->join('loai_vai', 'don_hang_khach_hang.id_loai_vai', '=', 'loai_vai.id')
                      ->join('mau', 'don_hang_khach_hang.id_mau', '=', 'mau.id')
                      ->select('don_hang_khach_hang.*', 'khach_hang.ho_ten as ten_khach_hang', 'loai_vai.ten as ten_loai_vai', 'mau.ten as ten_mau')
                      ->where('don_hang_khach_hang.da_xoa', '=', 0)
                      ->where('don_hang_khach_hang.id', '=', $this->id)
                      ->first();
        return $thongTin;
    }

    public function insert()
    {
        return DB::transaction(function() {
            DB::table('don_hang_khach_hang')
              ->insert([
                  'id_khach_hang' => $this->id_khach_hang,
                  'id_loai_vai' => $this->id_loai_vai,
                  'id_mau' => $this->id_mau,
                  'kho' => $this->kho,
                  'tong_so_met' => $this->tong_so_met,
                  'han_chot' => $this->han_chot,
                  'ngay_gio_dat_hang' => $this->ngay_gio_dat_hang
                ]);
        });
    }

    function getId()
    {
        return $this->id;
    }

    function getId_khach_hang()
    {
        return $this->id_khach_hang;
    }

    function getId_loai_vai()
    {
        return $this->id_loai_vai;
    }

    function getId_mau()
    {
        return $this->id_mau;
    }

    function getKho()
    {
        return $this->kho;
    }

    function getTong_so_met()
    {
        return $this->tong_so_met;
    }

    function getHan_chot()
    {
        return $this->han_chot;
    }

    function getNgay_gio_dat_hang()
    {
        return $this->ngay_gio_dat_hang;
    }

    function getTinh_trang()
    {
        return $this->tinh_trang;
    }

    function getDa_xoa()
    {
        return $this->da_xoa;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setId_khach_hang($id_khach_hang)
    {
        $this->id_khach_hang = $id_khach_hang;
    }

    function setId_loai_vai($id_loai_vai)
    {
        $this->id_loai_vai = $id_loai_vai;
    }

    function setId_mau($id_mau)
    {
        $this->id_mau = $id_mau;
    }

    function setKho($kho)
    {
        $this->kho = $kho;
    }

    function setTong_so_met($tong_so_met)
    {
        $this->tong_so_met = $tong_so_met;
    }

    function setHan_chot($han_chot)
    {
        $this->han_chot = $han_chot;
    }

    function setNgay_gio_dat_hang($ngay_gio_dat_hang)
    {
        $this->ngay_gio_dat_hang = $ngay_gio_dat_hang;
    }

    function setTinh_trang($tinh_trang)
    {
        $this->tinh_trang = $tinh_trang;
    }

    function setDa_xoa($da_xoa)
    {
        $this->da_xoa = $da_xoa;
    }
}