<?php

namespace App\Http\Entities;

use DB;

class HoaDonXuat
{
    var $id;
    var $id_don_hang_khach_hang;
    var $id_khach_hang;
    var $id_loai_vai;
    var $id_mau;
    var $kho;
    var $tong_so_cay_vai;
    var $tong_so_met;
    var $tong_tien;
    var $id_kho;
    var $id_nhan_vien_xuat;
    var $ngay_gio_xuat_hoa_don;
    var $tinh_chat;
    var $da_xoa;

    public function getThongTinById()
    {
        $thongTin = DB::table('hoa_don_xuat')
                      ->join('khach_hang', 'hoa_don_xuat.id_khach_hang', '=', 'khach_hang.id')
                      ->join('loai_vai', 'hoa_don_xuat.id_loai_vai', '=', 'loai_vai.id')
                      ->join('mau', 'hoa_don_xuat.id_mau', '=', 'mau.id')
                      ->join('kho', 'hoa_don_xuat.id_kho', '=', 'kho.id')
                      ->join('nhan_vien', 'hoa_don_xuat.id_nhan_vien_xuat', '=', 'nhan_vien.id')
                      ->select('hoa_don_xuat.*', 'khach_hang.ho_ten as ten_khach_hang', 'loai_vai.ten as ten_loai_vai', 'mau.ten as ten_mau', 'kho.ten as ten_kho', 'nhan_vien.ho_ten as ten_nhan_vien_xuat')
                      ->where('hoa_don_xuat.da_xoa', '=', 0)
                      ->where('hoa_don_xuat.id', '=', $this->id)
                      ->first();
        return $thongTin;
    }

    public function insert()
    {
        return DB::transaction(function() {
            DB::table('hoa_don_xuat')
              ->insert([
                  'id_don_hang_khach_hang' => $this->id_don_hang_khach_hang,
                  'id_khach_hang' => $this->id_khach_hang,
                  'id_loai_vai' => $this->id_loai_vai,
                  'id_mau' => $this->id_mau,
                  'kho' => $this->kho,
                  'tong_so_cay_vai' => $this->tong_so_cay_vai,
                  'tong_so_met' => $this->tong_so_met,
                  'tong_tien' => $this->tong_tien,
                  'id_kho' => $this->id_kho,
                  'id_nhan_vien_xuat' => $this->id_nhan_vien_xuat,
                  'ngay_gio_xuat_hoa_don' => $this->ngay_gio_xuat_hoa_don,
                  'tinh_chat' => $this->tinh_chat
                ]);
        });
    }

    public function update()
    {
        return DB::transaction(function() {
            DB::table('hoa_don_xuat')
              ->where('da_xoa', '=', 0)
              ->where('id', '=', $this->id)
              ->update([
                  'id_don_hang_khach_hang' => $this->id_don_hang_khach_hang,
                  'id_khach_hang' => $this->id_khach_hang,
                  'id_loai_vai' => $this->id_loai_vai,
                  'id_mau' => $this->id_mau,
                  'kho' => $this->kho,
                  'id_kho' => $this->id_kho,
                  'id_nhan_vien_xuat' => $this->id_nhan_vien_xuat,
                  'ngay_gio_xuat_hoa_don' => $this->ngay_gio_xuat_hoa_don,
                  'tinh_chat' => $this->tinh_chat
                ]);
        });
    }

    function getId()
    {
        return $this->id;
    }

    function getId_don_hang_khach_hang()
    {
        return $this->id_don_hang_khach_hang;
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

    function getTong_so_cay_vai()
    {
        return $this->tong_so_cay_vai;
    }

    function getTong_so_met()
    {
        return $this->tong_so_met;
    }

    function getTong_tien()
    {
        return $this->tong_tien;
    }

    function getId_kho()
    {
        return $this->id_kho;
    }

    function getId_nhan_vien_xuat()
    {
        return $this->id_nhan_vien_xuat;
    }

    function getNgay_gio_xuat_hoa_don()
    {
        return $this->ngay_gio_xuat_hoa_don;
    }

    function getTinh_chat()
    {
        return $this->tinh_chat;
    }

    function getDa_xoa()
    {
        return $this->da_xoa;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setId_don_hang_khach_hang($id_don_hang_khach_hang)
    {
        $this->id_don_hang_khach_hang = $id_don_hang_khach_hang;
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

    function setTong_so_cay_vai($tong_so_cay_vai)
    {
        $this->tong_so_cay_vai = $tong_so_cay_vai;
    }

    function setTong_so_met($tong_so_met)
    {
        $this->tong_so_met = $tong_so_met;
    }

    function setTong_tien($tong_tien)
    {
        $this->tong_tien = $tong_tien;
    }

    function setId_kho($id_kho)
    {
        $this->id_kho = $id_kho;
    }

    function setId_nhan_vien_xuat($id_nhan_vien_xuat)
    {
        $this->id_nhan_vien_xuat = $id_nhan_vien_xuat;
    }

    function setNgay_gio_xuat_hoa_don($ngay_gio_xuat_hoa_don)
    {
        $this->ngay_gio_xuat_hoa_don = $ngay_gio_xuat_hoa_don;
    }

    function setTinh_chat($tinh_chat)
    {
        $this->tinh_chat = $tinh_chat;
    }

    function setDa_xoa($da_xoa)
    {
        $this->da_xoa = $da_xoa;
    }
}