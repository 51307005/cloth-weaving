<?php

namespace App\Http\Repositories;

use DB;

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
}