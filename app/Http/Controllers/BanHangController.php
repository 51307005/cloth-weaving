<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HelperController;
use Illuminate\Support\Facades\Session;

class BanHangController extends HelperController
{
    public function getTrangChu()
    {
        // Check Login
        if (Session::has('username') && Session::has('quyen'))  // Đã Login
        {
            // Redirect tới view mà tương ứng với quyền của user
            switch (Session::get('quyen'))
            {
                case self::QUYEN_ADMIN:
                    //return redirect()->to(route('route_get_trang_chu_manager'));
                case self::QUYEN_SAN_XUAT:
                    //return redirect()->to(route('route_get_trang_chu_san_xuat'));
                case self::QUYEN_KHO:
                    return redirect()->to(route('route_get_trang_chu_kho'));
                case self::QUYEN_BAN_HANG:
                    // Lấy danh sách chức năng tương ứng với quyền của user
                    $list_chuc_nang = $this->taoLinkChoListChucNang(Session::get('quyen'));

                    return view('ban_hang')->with('list_chuc_nang', $list_chuc_nang);
            }
        }

        // Chưa Login
        return redirect()->to(route('route_get_login_he_thong'));
    }
}
