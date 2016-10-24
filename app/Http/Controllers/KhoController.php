<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HelperController;
use Illuminate\Support\Facades\Session;

class KhoController extends HelperController
{
    public function getTrangChu()
    {
        if (Session::has('username') && Session::has('quyen'))  // Đã Login
        {
            // Lấy danh sách chức năng tương ứng với quyền của user
            $list_chuc_nang = $this->taoLinkChoListChucNang(Session::get('quyen'));

            // Redirect tới view mà tương ứng với quyền của user
            switch (Session::get('quyen'))
            {
                case self::QUYEN_ADMIN:
                    //return view('manager')->with('list_chuc_nang', $list_chuc_nang);
                case self::QUYEN_SAN_XUAT:
                    //return view('san_xuat')->with('list_chuc_nang', $list_chuc_nang);
                case self::QUYEN_KHO:
                    return view('kho')->with('list_chuc_nang', $list_chuc_nang);
                case self::QUYEN_BAN_HANG:
                    //return view('ban_hang')->with('list_chuc_nang', $list_chuc_nang);
            }
        }

        // Chưa Login
        return view('login_he_thong');
    }
}
