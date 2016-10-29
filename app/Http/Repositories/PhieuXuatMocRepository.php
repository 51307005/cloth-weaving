<?php

namespace App\Http\Repositories;

use DB;

class PhieuXuatMocRepository
{
    public function getDanhSachIdPhieuXuatMoc()
    {
        $list_id_phieu_xuat_moc = DB::table('phieu_xuat_moc')
                                    ->select('id')
                                    ->where('da_xoa', '=', 0)
                                    ->get();
        return $list_id_phieu_xuat_moc;
    }
}