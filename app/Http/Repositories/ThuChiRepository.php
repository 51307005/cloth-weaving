<?php

namespace App\Http\Repositories;

use DB;
use App\Http\Entities\ThuChi;

class ThuChiRepository
{
    public function getDanhSachIdPhieuThuChi()
    {
        $list_id_phieu_thu_chi = DB::table('thu_chi')
                                   ->select('id')
                                   ->where('da_xoa', '=', 0)
                                   ->get();
        return $list_id_phieu_thu_chi;
    }

    public function getPhieuThuChiById($id_phieu_thu_chi)
    {
        $phieu_thu_chi = new ThuChi();
        $phieu_thu_chi->id = $id_phieu_thu_chi;
        $thongTin = $phieu_thu_chi->getThongTinById();

        if (count($thongTin) == 1)  // Lấy được thông tin của phiếu thu chi bằng id
        {
            $phieu_thu_chi->loai = $thongTin->loai;
            $phieu_thu_chi->id_nha_cung_cap = $thongTin->id_nha_cung_cap;
            $phieu_thu_chi->id_khach_hang = $thongTin->id_khach_hang;
            $phieu_thu_chi->so_tien = $thongTin->so_tien;
            $phieu_thu_chi->ngay_gio = $thongTin->ngay_gio;
            $phieu_thu_chi->phuong_thuc = $thongTin->phuong_thuc;
            $phieu_thu_chi->da_xoa = $thongTin->da_xoa;
            $phieu_thu_chi->ten_nha_cung_cap = $thongTin->ten_nha_cung_cap;
            $phieu_thu_chi->ten_khach_hang = $thongTin->ten_khach_hang;

            return $phieu_thu_chi;
        }

        // Id phiếu thu chi không tồn tại trong database
        return false;
    }

    public function getTongSoTienTraCuaKhachHang($id_khach_hang)
    {
        $tong_so_tien_tra = DB::table('thu_chi')
                              ->selectRaw('SUM(so_tien) as tong_so_tien_tra')
                              ->where('da_xoa', '=', 0)
                              ->where('loai', '=', 'Thu')
                              ->where('id_khach_hang', '=', $id_khach_hang)
                              ->first();
        $tong_so_tien_tra = $tong_so_tien_tra->tong_so_tien_tra;

        if ($tong_so_tien_tra == null)
        {
            $tong_so_tien_tra = 0;
        }

        return $tong_so_tien_tra;
    }

    public function getTongSoTienTraChoNhaCungCap($id_nha_cung_cap)
    {
        $tong_so_tien_tra = DB::table('thu_chi')
                              ->selectRaw('SUM(so_tien) as tong_so_tien_tra')
                              ->where('da_xoa', '=', 0)
                              ->where('loai', '=', 'Chi')
                              ->where('id_nha_cung_cap', '=', $id_nha_cung_cap)
                              ->first();
        $tong_so_tien_tra = $tong_so_tien_tra->tong_so_tien_tra;

        if ($tong_so_tien_tra == null)
        {
            $tong_so_tien_tra = 0;
        }

        return $tong_so_tien_tra;
    }
}