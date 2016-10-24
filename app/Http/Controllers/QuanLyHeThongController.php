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
        }

        // Username không tồn tại trong database hoặc Password không đúng
        $errorMessage = 'Tên đăng nhập hoặc mật khẩu không đúng !';
        return view('login_he_thong')->with('errorMessage', $errorMessage);
    }

    public function getLogout()
    {
        // Xóa Session
        Session::flush();

        return view('login_he_thong');
    }
}
