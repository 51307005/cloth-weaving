<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HelperController;
use Illuminate\Support\Facades\Session;

class SanXuatController extends HelperController
{
    public function getTrangChu()
    {
        // Check Login
        if (Session::has('username') && Session::has('quyen'))  // Đã Login
        {
            // Redirect tới view mà tương ứng với quyền của user
            switch (Session::get('quyen'))
            {
                case self::QUYEN_BAN_HANG:
                    return redirect()->to(route('route_get_trang_chu_ban_hang'));
                case self::QUYEN_KHO:
                    return redirect()->to(route('route_get_trang_chu_kho'));
                case self::QUYEN_ADMIN:
                case self::QUYEN_SAN_XUAT:
                    // Lấy danh sách chức năng tương ứng với quyền của user
                    $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_SAN_XUAT);
                    //$list_chuc_nang = $this->taoLinkChoListChucNang(Session::get('quyen'));

                    return view('san_xuat')->with('list_chuc_nang', $list_chuc_nang);
            }
        }

        // Chưa Login
        return redirect()->to(route('route_get_login_he_thong'));
    }
}
