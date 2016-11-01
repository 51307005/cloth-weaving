<?php

namespace App\Http\Entities;

use DB;

class PhieuXuatMoc
{
    var $id;
    var $tong_so_cay_moc;
    var $tong_so_met;
    var $id_kho;
    var $id_nhan_vien_xuat;
    var $ngay_gio_xuat_kho;
    var $da_xoa;

    public function getThongTinById()
    {
        $thongTin = DB::table('phieu_xuat_moc')
                      ->where('da_xoa', '=', 0)
                      ->where('id', '=', $this->id)
                      ->first();
        return $thongTin;
    }

    public function insert()
    {
        return DB::transaction(function() {
            DB::table('phieu_xuat_moc')
              ->insert([
                  'tong_so_cay_moc' => $this->tong_so_cay_moc,
                  'tong_so_met' => $this->tong_so_met,
                  'id_kho' => $this->id_kho,
                  'id_nhan_vien_xuat' => $this->id_nhan_vien_xuat,
                  'ngay_gio_xuat_kho' => $this->ngay_gio_xuat_kho,
                ]);
       });
    }

    public function update()
    {
        return DB::transaction(function() {
            DB::table('phieu_xuat_moc')
              ->where('da_xoa', '=', 0)
              ->where('id', '=', $this->id)
              ->update([
                  'id_kho' => $this->id_kho,
                  'id_nhan_vien_xuat' => $this->id_nhan_vien_xuat,
                  'ngay_gio_xuat_kho' => $this->ngay_gio_xuat_kho
                ]);
       });
    }

    function getId()
    {
        return $this->id;
    }

    function getTong_so_cay_moc()
    {
        return $this->tong_so_cay_moc;
    }

    function getTong_so_met()
    {
        return $this->tong_so_met;
    }

    function getId_kho()
    {
        return $this->id_kho;
    }

    function getId_nhan_vien_xuat()
    {
        return $this->id_nhan_vien_xuat;
    }

    function getNgay_gio_xuat_kho()
    {
        return $this->ngay_gio_xuat_kho;
    }

    function getDa_xoa()
    {
        return $this->da_xoa;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setTong_so_cay_moc($tong_so_cay_moc)
    {
        $this->tong_so_cay_moc = $tong_so_cay_moc;
    }

    function setTong_so_met($tong_so_met)
    {
        $this->tong_so_met = $tong_so_met;
    }

    function setId_kho($id_kho)
    {
        $this->id_kho = $id_kho;
    }

    function setId_nhan_vien_xuat($id_nhan_vien_xuat)
    {
        $this->id_nhan_vien_xuat = $id_nhan_vien_xuat;
    }

    function setNgay_gio_xuat_kho($ngay_gio_xuat_kho)
    {
        $this->ngay_gio_xuat_kho = $ngay_gio_xuat_kho;
    }

    function setDa_xoa($da_xoa)
    {
        $this->da_xoa = $da_xoa;
    }
}