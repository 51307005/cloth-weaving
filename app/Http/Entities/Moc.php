<?php

namespace App\Http\Entities;

use DB;

class Moc
{
    var $id;
    var $id_loai_vai;
    var $id_loai_soi;
    var $so_met;
    var $id_nhan_vien_det;
    var $ma_may_det;
    var $ngay_gio_det;
    var $id_kho;
    var $ngay_gio_nhap_kho;
    var $id_phieu_xuat_moc;
    var $tinh_trang;
    var $id_lo_nhuom;
    var $da_xoa;

    public function getThongTinById()
    {
        $thongTin = DB::table('cay_vai_moc')
                      ->where('da_xoa', '=', 0)
                      ->where('id', '=', $this->id)
                      ->first();
        return $thongTin;
    }

    public function update()
    {
        return DB::transaction(function() {
            DB::table('cay_vai_moc')
              ->where('da_xoa', '=', 0)
              ->where('id', '=', $this->id)
              ->update([
                  'id_loai_vai' => $this->id_loai_vai,
                  'id_loai_soi' => $this->id_loai_soi,
                  'so_met' => $this->so_met,
                  'id_nhan_vien_det' => $this->id_nhan_vien_det,
                  'ma_may_det' => $this->ma_may_det,
                  'ngay_gio_det' => $this->ngay_gio_det,
                  'id_kho' => $this->id_kho,
                  'ngay_gio_nhap_kho' => $this->ngay_gio_nhap_kho,
                  'id_phieu_xuat_moc' => $this->id_phieu_xuat_moc,
                  'tinh_trang' => $this->tinh_trang,
                  'id_lo_nhuom' => $this->id_lo_nhuom
                ]);
       });
    }

    function getId()
    {
        return $this->id;
    }

    function getId_loai_vai()
    {
        return $this->id_loai_vai;
    }

    function getId_loai_soi()
    {
        return $this->id_loai_soi;
    }

    function getSo_met()
    {
        return $this->so_met;
    }

    function getId_nhan_vien_det()
    {
        return $this->id_nhan_vien_det;
    }

    function getMa_may_det()
    {
        return $this->ma_may_det;
    }

    function getNgay_gio_det()
    {
        return $this->ngay_gio_det;
    }

    function getId_kho()
    {
        return $this->id_kho;
    }

    function getNgay_gio_nhap_kho()
    {
        return $this->ngay_gio_nhap_kho;
    }

    function getId_phieu_xuat_moc()
    {
        return $this->id_phieu_xuat_moc;
    }

    function getTinh_trang()
    {
        return $this->tinh_trang;
    }

    function getId_lo_nhuom()
    {
        return $this->id_lo_nhuom;
    }

    function getDa_xoa()
    {
        return $this->da_xoa;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setId_loai_vai($id_loai_vai)
    {
        $this->id_loai_vai = $id_loai_vai;
    }

    function setId_loai_soi($id_loai_soi)
    {
        $this->id_loai_soi = $id_loai_soi;
    }

    function setSo_met($so_met)
    {
        $this->so_met = $so_met;
    }

    function setId_nhan_vien_det($id_nhan_vien_det)
    {
        $this->id_nhan_vien_det = $id_nhan_vien_det;
    }

    function setMa_may_det($ma_may_det)
    {
        $this->ma_may_det = $ma_may_det;
    }

    function setNgay_gio_det($ngay_gio_det)
    {
        $this->ngay_gio_det = $ngay_gio_det;
    }

    function setId_kho($id_kho)
    {
        $this->id_kho = $id_kho;
    }

    function setNgay_gio_nhap_kho($ngay_gio_nhap_kho)
    {
        $this->ngay_gio_nhap_kho = $ngay_gio_nhap_kho;
    }

    function setId_phieu_xuat_moc($id_phieu_xuat_moc)
    {
        $this->id_phieu_xuat_moc = $id_phieu_xuat_moc;
    }

    function setTinh_trang($tinh_trang)
    {
        $this->tinh_trang = $tinh_trang;
    }

    function setId_lo_nhuom($id_lo_nhuom)
    {
        $this->id_lo_nhuom = $id_lo_nhuom;
    }

    function setDa_xoa($da_xoa)
    {
        $this->da_xoa = $da_xoa;
    }
}