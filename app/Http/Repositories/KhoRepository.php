<?php

namespace App\Http\Repositories;

use DB;
use App\Http\Entities\Kho;

class KhoRepository
{
    public function getDanhSachKhoMoc()
    {
        $list_kho_moc = DB::table('kho')
                          ->where('da_xoa', '=', 0)
                          ->where('ten', 'like', '%Kho mộc%')
                          ->get();
        return $list_kho_moc;
    }

    public function getKhoMocById($id_kho)
    {
        $kho_moc = new Kho();
        $kho_moc->id = $id_kho;
        $thongTin = $kho_moc->getThongTinById();

        if (count($thongTin) == 1)  // Lấy được thông tin của kho mộc bằng id
        {
            $kho_moc->ten = $thongTin->ten;
            $kho_moc->id_nhan_vien_quan_ly = $thongTin->id_nhan_vien_quan_ly;
            $kho_moc->dien_tich = $thongTin->dien_tich;
            $kho_moc->dia_chi = $thongTin->dia_chi;
            $kho_moc->so_dien_thoai = $thongTin->so_dien_thoai;
            $kho_moc->da_xoa = $thongTin->da_xoa;

            return $kho_moc;
        }

        // Id kho mộc không tồn tại trong database
        return false;
    }

    public function getDanhSachKhoThanhPham()
    {
        $list_kho_thanh_pham = DB::table('kho')
                                 ->where('da_xoa', '=', 0)
                                 ->where('ten', 'like', '%Kho thành phẩm%')
                                 ->get();
        return $list_kho_thanh_pham;
    }
}