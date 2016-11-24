<?php

namespace App\Http\Repositories;

use DB;
use App\Http\Entities\Mau;

class MauRepository
{
    public function getDanhSachMau()
    {
        $list_mau = DB::table('mau')
                      ->leftJoin('nhan_vien', 'mau.id_nhan_vien_pha_che', '=', 'nhan_vien.id')
                      ->select('mau.*', 'nhan_vien.ho_ten as ten_nhan_vien_pha_che')
                      ->where('mau.da_xoa', '=', 0)
                      ->get();
        return $list_mau;
    }

    public function getMauById($id_mau)
    {
        $mau = new Mau();
        $mau->id = $id_mau;
        $thongTin = $mau->getThongTinById();

        if (count($thongTin) == 1)  // Lấy được thông tin của màu bằng id
        {
            $mau->ten = $thongTin->ten;
            $mau->cong_thuc = $thongTin->cong_thuc;
            $mau->id_nhan_vien_pha_che = $thongTin->id_nhan_vien_pha_che;
            $mau->ngay_gio_tao = $thongTin->ngay_gio_tao;
            $mau->da_xoa = $thongTin->da_xoa;
            $mau->ten_nhan_vien_pha_che = $thongTin->ten_nhan_vien_pha_che;

            return $mau;
        }

        // Id màu không tồn tại trong database
        return false;
    }
}