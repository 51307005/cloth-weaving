<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HelperController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\ThemDonHangKhachHangRequest;
use App\Http\Repositories\KhachHangRepository;
use App\Http\Repositories\HoaDonXuatRepository;
use App\Http\Repositories\ThuChiRepository;

class KhachHangController extends HelperController
{
    public function getKhachHang(Request $request)
    {
        
    }

    public function postKhachHang(Request $request)
    {
        
    }

    public function getThemKhachHang()
    {
        
    }

    public function postThemKhachHang(ThemDonHangKhachHangRequest $request)
    {
        
    }

    public function getCapNhatKhachHang($id_khach_hang = null)
    {
        
    }

    public function postCapNhatKhachHang(Request $request, $id_khach_hang)
    {
        
    }
}
