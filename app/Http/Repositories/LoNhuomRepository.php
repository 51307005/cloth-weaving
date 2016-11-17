<?php

namespace App\Http\Repositories;

use DB;
use App\Http\Entities\LoNhuom;

class LoNhuomRepository
{
    public function getDanhSachIdLoNhuom()
    {
        $list_id_lo_nhuom = DB::table('lo_nhuom')
                              ->select('id')
                              ->where('da_xoa', '=', 0)
                              ->get();
        return $list_id_lo_nhuom;
    }

    public function getLoNhuomById($id_lo_nhuom)
    {
        $lo_nhuom = new LoNhuom();
        $lo_nhuom->id = $id_lo_nhuom;
        $thongTin = $lo_nhuom->getThongTinById();

        if (count($thongTin) == 1)  // Lấy được thông tin của lô nhuộm bằng id
        {
            $lo_nhuom->id_mau = $thongTin->id_mau;
            $lo_nhuom->id_nhan_vien_nhuom = $thongTin->id_nhan_vien_nhuom;
            $lo_nhuom->ngay_gio_nhuom = $thongTin->ngay_gio_nhuom;
            $lo_nhuom->da_xoa = $thongTin->da_xoa;
            $lo_nhuom->ten_mau = $thongTin->ten_mau;
            $lo_nhuom->ten_nhan_vien_nhuom = $thongTin->ten_nhan_vien_nhuom;

            return $lo_nhuom;
        }

        // Id lô nhuộm không tồn tại trong database
        return false;
    }
}