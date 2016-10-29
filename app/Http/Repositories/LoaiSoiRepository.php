<?php

namespace App\Http\Repositories;

use DB;

class LoaiSoiRepository
{
    public function getDanhSachLoaiSoi()
    {
        $list_loai_soi = DB::table('loai_soi')
                           ->where('da_xoa', '=', 0)
                           ->get();
        return $list_loai_soi;
    }
}