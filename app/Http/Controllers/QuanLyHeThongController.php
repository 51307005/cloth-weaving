<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HelperController;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\DangNhapHeThongRequest;
use App\Http\Repositories\NhanVienRepository;

class QuanLyHeThongController extends HelperController
{
    public function getLogin()
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
                    //return redirect()->to(route('route_get_trang_chu_ban_hang'));
            }
        }

        // Chưa Login
        return view('login_he_thong');
    }

    public function postLogin(DangNhapHeThongRequest $request)
    {
        $nhanVienRepository = new NhanVienRepository();
        $nhanVien = $nhanVienRepository->getNhanVienByUsername($request->get('username'));

        if ($nhanVien != false)     // Username có tồn tại trong database
        {
            if (md5($request->get('password')) == $nhanVien->mat_khau)  // Login thành công
            {
                // Thiết lập Session
                Session::put('username', $nhanVien->ten_dang_nhap);
                Session::put('quyen', $nhanVien->quyen);

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
                        //return redirect()->to(route('route_get_trang_chu_ban_hang'));
                }
            }
        }

        // Username không tồn tại trong database hoặc Password không đúng
        $errorMessage = 'Tên đăng nhập hoặc mật khẩu không đúng !';
        return view('login_he_thong')->with('errorMessage', $errorMessage);
    }

    public function getLogout()
    {
        // Xóa Session
        Session::flush();

        return redirect()->to(route('route_get_login_he_thong'));
    }
}
