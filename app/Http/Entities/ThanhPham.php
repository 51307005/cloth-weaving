<?php

namespace App\Http\Entities;

use DB;

class ThanhPham
{
    var $id;
    var $id_cay_vai_moc;
    var $id_loai_vai;
    var $id_mau;
    var $kho;
    var $so_met;
    var $don_gia;
    var $thanh_tien;
    var $id_lo_nhuom;
    var $id_kho;
    var $ngay_gio_nhap_kho;
    var $id_hoa_don_xuat;
    var $tinh_trang;
    var $da_xoa;

    public function getThongTinById()
    {
        $thongTin = DB::table('cay_vai_thanh_pham')
                      ->join('loai_vai', 'cay_vai_thanh_pham.id_loai_vai', '=', 'loai_vai.id')
                      ->join('mau', 'cay_vai_thanh_pham.id_mau', '=', 'mau.id')
                      ->join('kho', 'cay_vai_thanh_pham.id_kho', '=', 'kho.id')
                      ->select('cay_vai_thanh_pham.*', 'loai_vai.ten as ten_loai_vai', 'mau.ten as ten_mau', 'kho.ten as ten_kho')
                      ->where('cay_vai_thanh_pham.da_xoa', '=', 0)
                      ->where('cay_vai_thanh_pham.id', '=', $this->id)
                      ->first();
        return $thongTin;
    }

    public function update()
    {
        return DB::transaction(function() {
            DB::table('cay_vai_thanh_pham')
              ->where('da_xoa', '=', 0)
              ->where('id', '=', $this->id)
              ->update([
                  'id_cay_vai_moc' => $this->id_cay_vai_moc,
                  'id_loai_vai' => $this->id_loai_vai,
                  'id_mau' => $this->id_mau,
                  'kho' => $this->kho,
                  'so_met' => $this->so_met,
                  'don_gia' => $this->don_gia,
                  'thanh_tien' => $this->thanh_tien,
                  'id_lo_nhuom' => $this->id_lo_nhuom,
                  'id_kho' => $this->id_kho,
                  'ngay_gio_nhap_kho' => $this->ngay_gio_nhap_kho,
                  'id_hoa_don_xuat' => $this->id_hoa_don_xuat,
                  'tinh_trang' => $this->tinh_trang
                ]);
        });
    }

    function getId()
    {
        return $this->id;
    }

    function getId_cay_vai_moc()
    {
        return $this->id_cay_vai_moc;
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

    function getSo_met()
    {
        return $this->so_met;
    }

    function getDon_gia()
    {
        return $this->don_gia;
    }

    function getThanh_tien()
    {
        return $this->thanh_tien;
    }

    function getId_lo_nhuom()
    {
        return $this->id_lo_nhuom;
    }

    function getId_kho()
    {
        return $this->id_kho;
    }

    function getNgay_gio_nhap_kho()
    {
        return $this->ngay_gio_nhap_kho;
    }

    function getId_hoa_don_xuat()
    {
        return $this->id_hoa_don_xuat;
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

    function setId_cay_vai_moc($id_cay_vai_moc)
    {
        $this->id_cay_vai_moc = $id_cay_vai_moc;
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

    function setSo_met($so_met)
    {
        $this->so_met = $so_met;
    }

    function setDon_gia($don_gia)
    {
        $this->don_gia = $don_gia;
    }

    function setThanh_tien($thanh_tien)
    {
        $this->thanh_tien = $thanh_tien;
    }

    function setId_lo_nhuom($id_lo_nhuom)
    {
        $this->id_lo_nhuom = $id_lo_nhuom;
    }

    function setId_kho($id_kho)
    {
        $this->id_kho = $id_kho;
    }

    function setNgay_gio_nhap_kho($ngay_gio_nhap_kho)
    {
        $this->ngay_gio_nhap_kho = $ngay_gio_nhap_kho;
    }

    function setId_hoa_don_xuat($id_hoa_don_xuat)
    {
        $this->id_hoa_don_xuat = $id_hoa_don_xuat;
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