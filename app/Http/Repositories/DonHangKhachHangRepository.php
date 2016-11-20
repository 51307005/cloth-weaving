<?php

namespace App\Http\Repositories;

use DB;
use App\Http\Entities\DonHangKhachHang;

class DonHangKhachHangRepository
{
    public function getDonHangKhachHangById($id_don_hang_khach_hang)
    {
        $don_hang_khach_hang = new DonHangKhachHang();
        $don_hang_khach_hang->id = $id_don_hang_khach_hang;
        $thongTin = $don_hang_khach_hang->getThongTinById();

        if (count($thongTin) == 1)  // Lấy được thông tin của đơn hàng khách hàng bằng id
        {
            $don_hang_khach_hang->id_khach_hang = $thongTin->id_khach_hang;
            $don_hang_khach_hang->id_loai_vai = $thongTin->id_loai_vai;
            $don_hang_khach_hang->id_mau = $thongTin->id_mau;
            $don_hang_khach_hang->kho = $thongTin->kho;
            $don_hang_khach_hang->tong_so_met = $thongTin->tong_so_met;
            $don_hang_khach_hang->han_chot = $thongTin->han_chot;
            $don_hang_khach_hang->ngay_gio_dat_hang = $thongTin->ngay_gio_dat_hang;
            $don_hang_khach_hang->tinh_trang = $thongTin->tinh_trang;
            $don_hang_khach_hang->da_xoa = $thongTin->da_xoa;
            $don_hang_khach_hang->ten_khach_hang = $thongTin->ten_khach_hang;
            $don_hang_khach_hang->ten_loai_vai = $thongTin->ten_loai_vai;
            $don_hang_khach_hang->ten_mau = $thongTin->ten_mau;

            return $don_hang_khach_hang;
        }

        // Id đơn hàng khách hàng không tồn tại trong database
        return false;
    }

    public function getDanhSachDonHangKhachHangChuaHoanThanh_Moi($id_khach_hang = null)
    {
        if ($id_khach_hang == null)
        {
            $listDonHangKhachHang_ChuaHoanThanh_Moi = DB::table('don_hang_khach_hang')
                                                        ->join('khach_hang', 'don_hang_khach_hang.id_khach_hang', '=', 'khach_hang.id')
                                                        ->join('loai_vai', 'don_hang_khach_hang.id_loai_vai', '=', 'loai_vai.id')
                                                        ->join('mau', 'don_hang_khach_hang.id_mau', '=', 'mau.id')
                                                        ->select('don_hang_khach_hang.*', 'khach_hang.ho_ten as ten_khach_hang', 'loai_vai.ten as ten_loai_vai', 'mau.ten as ten_mau')
                                                        ->where('don_hang_khach_hang.da_xoa', '=', 0)
                                                        ->where('don_hang_khach_hang.tinh_trang', '!=', 'Hoàn thành')
                                                        ->paginate(10);
        }
        else
        {
            $listDonHangKhachHang_ChuaHoanThanh_Moi = DB::table('don_hang_khach_hang')
                                                        ->join('khach_hang', 'don_hang_khach_hang.id_khach_hang', '=', 'khach_hang.id')
                                                        ->join('loai_vai', 'don_hang_khach_hang.id_loai_vai', '=', 'loai_vai.id')
                                                        ->join('mau', 'don_hang_khach_hang.id_mau', '=', 'mau.id')
                                                        ->select('don_hang_khach_hang.*', 'khach_hang.ho_ten as ten_khach_hang', 'loai_vai.ten as ten_loai_vai', 'mau.ten as ten_mau')
                                                        ->where('don_hang_khach_hang.da_xoa', '=', 0)
                                                        ->where('don_hang_khach_hang.tinh_trang', '!=', 'Hoàn thành')
                                                        ->where('don_hang_khach_hang.id_khach_hang', '=', $id_khach_hang)
                                                        ->paginate(10);
        }

        return $listDonHangKhachHang_ChuaHoanThanh_Moi;
    }

    public function getDanhSachDonHangKhachHang($id_khach_hang = null)
    {
        if ($id_khach_hang == null)
        {
            $list_don_hang_khach_hang = DB::table('don_hang_khach_hang')
                                          ->join('khach_hang', 'don_hang_khach_hang.id_khach_hang', '=', 'khach_hang.id')
                                          ->join('loai_vai', 'don_hang_khach_hang.id_loai_vai', '=', 'loai_vai.id')
                                          ->join('mau', 'don_hang_khach_hang.id_mau', '=', 'mau.id')
                                          ->select('don_hang_khach_hang.*', 'khach_hang.ho_ten as ten_khach_hang', 'loai_vai.ten as ten_loai_vai', 'mau.ten as ten_mau')
                                          ->where('don_hang_khach_hang.da_xoa', '=', 0)
                                          ->paginate(10);
        }
        else
        {
            $list_don_hang_khach_hang = DB::table('don_hang_khach_hang')
                                          ->join('khach_hang', 'don_hang_khach_hang.id_khach_hang', '=', 'khach_hang.id')
                                          ->join('loai_vai', 'don_hang_khach_hang.id_loai_vai', '=', 'loai_vai.id')
                                          ->join('mau', 'don_hang_khach_hang.id_mau', '=', 'mau.id')
                                          ->select('don_hang_khach_hang.*', 'khach_hang.ho_ten as ten_khach_hang', 'loai_vai.ten as ten_loai_vai', 'mau.ten as ten_mau')
                                          ->where('don_hang_khach_hang.da_xoa', '=', 0)
                                          ->where('don_hang_khach_hang.id_khach_hang', '=', $id_khach_hang)
                                          ->paginate(10);
        }

        return $list_don_hang_khach_hang;
    }

    public function demTongSoDonHangKhachHangTheoTinhTrang($id_khach_hang = null)
    {
        $tong_so_don_hang_khach_hang_theo_tinh_trang = array(
            'Mới' => 0,
            'Chưa hoàn thành' => 0,
            'Hoàn thành' => 0
        );

        if ($id_khach_hang == null)
        {
            $temp = DB::table('don_hang_khach_hang')
                      ->selectRaw('tinh_trang as ten_tinh_trang, COUNT(id) as tong_so_don_hang_khach_hang')
                      ->where('da_xoa', '=', 0)
                      ->groupBy('tinh_trang')
                      ->get();
        }
        else
        {
            $temp = DB::table('don_hang_khach_hang')
                      ->selectRaw('tinh_trang as ten_tinh_trang, COUNT(id) as tong_so_don_hang_khach_hang')
                      ->where('da_xoa', '=', 0)
                      ->where('id_khach_hang', '=', $id_khach_hang)
                      ->groupBy('tinh_trang')
                      ->get();
        }

        foreach ($temp as $tinhTrang)
        {
            foreach ($tong_so_don_hang_khach_hang_theo_tinh_trang as $tinh_trang => &$tong_so_don_hang_khach_hang)
            {
                if ($tinh_trang == $tinhTrang->ten_tinh_trang)
                {
                    $tong_so_don_hang_khach_hang = $tinhTrang->tong_so_don_hang_khach_hang;
                    break;
                }
            }
        }
        unset($tong_so_don_hang_khach_hang);

        return $tong_so_don_hang_khach_hang_theo_tinh_trang;
    }

    public function getDanhSachIdDonHangKhachHangChuaHoanThanh_Moi()
    {
        $listIdDonHangKhachHangChuaHoanThanh_Moi = DB::table('don_hang_khach_hang')
                                                     ->select('id')
                                                     ->where('da_xoa', '=', 0)
                                                     ->where('tinh_trang', '!=', 'Hoàn thành')
                                                     ->get();
        return $listIdDonHangKhachHangChuaHoanThanh_Moi;
    }

    public function updateTinhTrangDonHangKhachHang($id_don_hang_khach_hang, $tong_so_met_da_giao)
    {
        if ($tong_so_met_da_giao == 0)
        {
            $sql = 'UPDATE don_hang_khach_hang
                    SET tinh_trang = "Mới"
                    WHERE da_xoa = 0 AND id = '.$id_don_hang_khach_hang;
        }
        else
        {
            $tong_so_met = DB::table('don_hang_khach_hang')
                             ->select('tong_so_met')
                             ->where('da_xoa', '=', 0)
                             ->where('id', '=', $id_don_hang_khach_hang)
                             ->first();
            $tong_so_met = $tong_so_met->tong_so_met;

            if ($tong_so_met_da_giao >= $tong_so_met)
            {
                $sql = 'UPDATE don_hang_khach_hang
                        SET tinh_trang = "Hoàn thành"
                        WHERE da_xoa = 0 AND id = '.$id_don_hang_khach_hang;
            }
            else if ($tong_so_met_da_giao < $tong_so_met)
            {
                $sql = 'UPDATE don_hang_khach_hang
                        SET tinh_trang = "Chưa hoàn thành"
                        WHERE da_xoa = 0 AND id = '.$id_don_hang_khach_hang;
            }
        }

        return DB::transaction(function() use ($sql) {
            DB::update($sql);
        });
    }
}