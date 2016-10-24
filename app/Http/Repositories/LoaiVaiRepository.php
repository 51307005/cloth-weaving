<?php

namespace App\Http\Repositories;

use DB;
use App\Http\Entities\LoaiVai;

class LoaiVaiRepository
{
    public function getDanhSachLoaiVai()
    {
        $list_loai_vai = DB::table('loai_vai')
                           ->where('da_xoa', '=', 0)
                           ->get();
        return $list_loai_vai;
    }

    public function getLoaiVaiById($id_loai_vai)
    {
        $loai_vai = new LoaiVai();
        $loai_vai->id = $id_loai_vai;
        $thongTin = $loai_vai->getThongTinById();

        if (count($thongTin) == 1)  // Lấy được thông tin của loại vải bằng id
        {
            $loai_vai->ten = $thongTin[0]->ten;
            $loai_vai->don_gia = $thongTin[0]->don_gia;
            $loai_vai->da_xoa = $thongTin[0]->da_xoa;

            return $loai_vai;
        }

        // Id loại vải không tồn tại trong database
        return false;
    }
}