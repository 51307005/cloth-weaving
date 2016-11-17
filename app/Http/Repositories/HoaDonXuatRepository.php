<?php

namespace App\Http\Repositories;

use DB;
use Illuminate\Http\Request;
use App\Http\Entities\HoaDonXuat;
use App\Http\Repositories\DonHangKhachHangRepository;

class HoaDonXuatRepository
{
    public function getHoaDonXuatById($id_hoa_don_xuat)
    {
        $hoa_don_xuat = new HoaDonXuat();
        $hoa_don_xuat->id = $id_hoa_don_xuat;
        $thongTin = $hoa_don_xuat->getThongTinById();

        if (count($thongTin) == 1)  // Lấy được thông tin của hóa đơn xuất bằng id
        {
            $hoa_don_xuat->id_don_hang_khach_hang = $thongTin->id_don_hang_khach_hang;
            $hoa_don_xuat->id_khach_hang = $thongTin->id_khach_hang;
            $hoa_don_xuat->id_loai_vai = $thongTin->id_loai_vai;
            $hoa_don_xuat->id_mau = $thongTin->id_mau;
            $hoa_don_xuat->kho = $thongTin->kho;
            $hoa_don_xuat->tong_so_cay_vai = $thongTin->tong_so_cay_vai;
            $hoa_don_xuat->tong_so_met = $thongTin->tong_so_met;
            $hoa_don_xuat->tong_tien = $thongTin->tong_tien;
            $hoa_don_xuat->id_kho = $thongTin->id_kho;
            $hoa_don_xuat->id_nhan_vien_xuat = $thongTin->id_nhan_vien_xuat;
            $hoa_don_xuat->ngay_gio_xuat_hoa_don = $thongTin->ngay_gio_xuat_hoa_don;
            $hoa_don_xuat->tinh_chat = $thongTin->tinh_chat;
            $hoa_don_xuat->da_xoa = $thongTin->da_xoa;
            $hoa_don_xuat->ten_khach_hang = $thongTin->ten_khach_hang;
            $hoa_don_xuat->ten_loai_vai = $thongTin->ten_loai_vai;
            $hoa_don_xuat->ten_mau = $thongTin->ten_mau;
            $hoa_don_xuat->ten_kho = $thongTin->ten_kho;
            $hoa_don_xuat->ten_nhan_vien_xuat = $thongTin->ten_nhan_vien_xuat;

            return $hoa_don_xuat;
        }

        // Id hóa đơn xuất không tồn tại trong database
        return false;
    }

    public function getDanhSachIdHoaDonXuat()
    {
        $list_id_hoa_don_xuat = DB::table('hoa_don_xuat')
                                  ->select('id')
                                  ->where('da_xoa', '=', 0)
                                  ->get();
        return $list_id_hoa_don_xuat;
    }

    public function capNhatCayThanhPham(Request $request)
    {
        $cay_thanh_pham_cu = $request->get('cay_thanh_pham_cu');
        $cay_thanh_pham_cu = json_decode($cay_thanh_pham_cu);

        $id_hoa_don_xuat_cu = $cay_thanh_pham_cu->id_hoa_don_xuat;
        $id_hoa_don_xuat_moi = (int)($request->get('id_hoa_don_xuat'));
        $so_met_cu = $cay_thanh_pham_cu->so_met;
        $so_met_moi = (int)($request->get('so_met'));
        $thanh_tien_cu = $cay_thanh_pham_cu->thanh_tien;
        $thanh_tien_moi = $request->get('thanh_tien');
        if ($thanh_tien_cu == null)
        {
            $thanh_tien_cu = 0;
        }
        if ($thanh_tien_moi == '')
        {
            $thanh_tien_moi = 0;
        }
        else
        {
            $thanh_tien_moi = (int)$thanh_tien_moi;
        }

        $hoa_don_xuat_cu = $this->getHoaDonXuatById($id_hoa_don_xuat_cu);
        $hoa_don_xuat_moi = $this->getHoaDonXuatById($id_hoa_don_xuat_moi);
        $id_don_hang_khach_hang_cu = $hoa_don_xuat_cu->id_don_hang_khach_hang;
        $id_don_hang_khach_hang_moi = $hoa_don_xuat_moi->id_don_hang_khach_hang;

        // Tạo đối tượng DonHangKhachHangRepository
        $donHangKhachHangRepository = new DonHangKhachHangRepository();

        if ($id_hoa_don_xuat_cu == null && $id_hoa_don_xuat_moi != 0)   // Lúc đầu cây thành phẩm không nằm trong hóa đơn xuất nào, lúc sau cây thành phẩm nằm trong 1 hóa đơn xuất nào đó
        {
            $sql = 'UPDATE hoa_don_xuat
                    SET tong_so_cay_vai = tong_so_cay_vai + 1,
                        tong_so_met = tong_so_met + '.$so_met_moi.',
                        tong_tien = tong_tien + '.$thanh_tien_moi.'
                    WHERE da_xoa = 0 AND id = '.$id_hoa_don_xuat_moi;

            DB::transaction(function() use ($sql) {
                DB::update($sql);
            });

            // Update lại Tình trạng của Đơn hàng khách hàng mới mà tương ứng với Hóa đơn xuất mới
            $tong_so_met_da_giao = $this->tinhTongSoMetDaGiaoCuaDonHangKhachHang($id_don_hang_khach_hang_moi);
            $donHangKhachHangRepository->updateTinhTrangDonHangKhachHang($id_don_hang_khach_hang_moi, $tong_so_met_da_giao);
        }
        else if ($id_hoa_don_xuat_cu != null && $id_hoa_don_xuat_moi == 0)  // Lúc đầu cây thành phẩm nằm trong 1 hóa đơn xuất nào đó, lúc sau cây thành phẩm không nằm trong hóa đơn xuất nào
        {
            $sql = 'UPDATE hoa_don_xuat
                    SET tong_so_cay_vai = tong_so_cay_vai - 1,
                        tong_so_met = tong_so_met - '.$so_met_cu.',
                        tong_tien = tong_tien - '.$thanh_tien_cu.'
                    WHERE da_xoa = 0 AND id = '.$id_hoa_don_xuat_cu;

            DB::transaction(function() use ($sql) {
                DB::update($sql);
            });

            // Update lại Tình trạng của Đơn hàng khách hàng cũ mà tương ứng với Hóa đơn xuất cũ
            $tong_so_met_da_giao = $this->tinhTongSoMetDaGiaoCuaDonHangKhachHang($id_don_hang_khach_hang_cu);
            $donHangKhachHangRepository->updateTinhTrangDonHangKhachHang($id_don_hang_khach_hang_cu, $tong_so_met_da_giao);
        }
        else if ($id_hoa_don_xuat_cu != null && $id_hoa_don_xuat_moi != 0 && $id_hoa_don_xuat_cu == $id_hoa_don_xuat_moi)   // Lúc đầu cây thành phẩm nằm trong hóa đơn xuất này và lúc sau cây thành phẩm vẫn nằm trong hóa đơn xuất đó
        {
            $sql = 'UPDATE hoa_don_xuat
                    SET tong_so_met = tong_so_met - '.$so_met_cu.' + '.$so_met_moi.',
                        tong_tien = tong_tien - '.$thanh_tien_cu.' + '.$thanh_tien_moi.'
                    WHERE da_xoa = 0 AND id = '.$id_hoa_don_xuat_moi;

            DB::transaction(function() use ($sql) {
                DB::update($sql);
            });

            // Update lại Tình trạng của Đơn hàng khách hàng mới (cũng chính là Đơn hàng khách hàng cũ) mà tương ứng với Hóa đơn xuất mới (cũng chính là Hóa đơn xuất cũ)
            $tong_so_met_da_giao = $this->tinhTongSoMetDaGiaoCuaDonHangKhachHang($id_don_hang_khach_hang_moi);
            $donHangKhachHangRepository->updateTinhTrangDonHangKhachHang($id_don_hang_khach_hang_moi, $tong_so_met_da_giao);
        }
        else if ($id_hoa_don_xuat_cu != null && $id_hoa_don_xuat_moi != 0 && $id_hoa_don_xuat_cu != $id_hoa_don_xuat_moi)   // Lúc đầu cây thành phẩm nằm trong hóa đơn xuất này nhưng lúc sau cây thành phẩm lại nằm trong hóa đơn xuất khác
        {
            $sql_1 = 'UPDATE hoa_don_xuat
                      SET tong_so_cay_vai = tong_so_cay_vai - 1,
                          tong_so_met = tong_so_met - '.$so_met_cu.',
                          tong_tien = tong_tien - '.$thanh_tien_cu.'
                      WHERE da_xoa = 0 AND id = '.$id_hoa_don_xuat_cu;

            $sql_2 = 'UPDATE hoa_don_xuat
                      SET tong_so_cay_vai = tong_so_cay_vai + 1,
                          tong_so_met = tong_so_met + '.$so_met_moi.',
                          tong_tien = tong_tien + '.$thanh_tien_moi.'
                      WHERE da_xoa = 0 AND id = '.$id_hoa_don_xuat_moi;

            DB::transaction(function() use ($sql_1, $sql_2) {
                DB::update($sql_1);
                DB::update($sql_2);
            });

            // Update lại Tình trạng của Đơn hàng khách hàng cũ mà tương ứng với Hóa đơn xuất cũ
            $tong_so_met_da_giao = $this->tinhTongSoMetDaGiaoCuaDonHangKhachHang($id_don_hang_khach_hang_cu);
            $donHangKhachHangRepository->updateTinhTrangDonHangKhachHang($id_don_hang_khach_hang_cu, $tong_so_met_da_giao);

            // Update lại Tình trạng của Đơn hàng khách hàng mới mà tương ứng với Hóa đơn xuất mới
            $tong_so_met_da_giao = $this->tinhTongSoMetDaGiaoCuaDonHangKhachHang($id_don_hang_khach_hang_moi);
            $donHangKhachHangRepository->updateTinhTrangDonHangKhachHang($id_don_hang_khach_hang_moi, $tong_so_met_da_giao);
        }
    }

    public function capNhatXuatThanhPham($id_hoa_don_xuat, $tong_so_cay_thanh_pham, $tong_so_met, $tong_tien)
    {
        $sql = 'UPDATE hoa_don_xuat
                SET tong_so_cay_vai = '.$tong_so_cay_thanh_pham.',
                    tong_so_met = '.$tong_so_met.',
                    tong_tien = '.$tong_tien.'
                WHERE da_xoa = 0 AND id = '.$id_hoa_don_xuat;

        return DB::transaction(function() use ($sql) {
            DB::update($sql);
        });
    }

    public function tinhTongSoMetDaGiaoCuaDonHangKhachHang($id_don_hang_khach_hang)
    {
        $tong_so_met_da_giao = DB::table('hoa_don_xuat')
                                 ->selectRaw('SUM(tong_so_met) as tong_so_met_da_giao')
                                 ->where('da_xoa', '=', 0)
                                 ->where('id_don_hang_khach_hang', '=', $id_don_hang_khach_hang)
                                 ->first();
        $tong_so_met_da_giao = $tong_so_met_da_giao->tong_so_met_da_giao;

        if ($tong_so_met_da_giao == null)
        {
            $tong_so_met_da_giao = 0;
        }

        return $tong_so_met_da_giao;
    }

    public function getDanhSachHoaDonXuat()
    {
        $list_hoa_don_xuat = DB::table('hoa_don_xuat')
                               ->join('khach_hang', 'hoa_don_xuat.id_khach_hang', '=', 'khach_hang.id')
                               ->join('loai_vai', 'hoa_don_xuat.id_loai_vai', '=', 'loai_vai.id')
                               ->join('mau', 'hoa_don_xuat.id_mau', '=', 'mau.id')
                               ->join('kho', 'hoa_don_xuat.id_kho', '=', 'kho.id')
                               ->join('nhan_vien', 'hoa_don_xuat.id_nhan_vien_xuat', '=', 'nhan_vien.id')
                               ->select('hoa_don_xuat.*', 'khach_hang.ho_ten as ten_khach_hang', 'loai_vai.ten as ten_loai_vai', 'mau.ten as ten_mau', 'kho.ten as ten_kho', 'nhan_vien.ho_ten as ten_nhan_vien_xuat')
                               ->where('hoa_don_xuat.da_xoa', '=', 0)
                               ->paginate(10);
        return $list_hoa_don_xuat;
    }

    public function deleteCacHoaDonXuat($list_id_hoa_don_xuat_muon_xoa)
    {
        return DB::transaction(function() use ($list_id_hoa_don_xuat_muon_xoa) {
            $sql = 'UPDATE hoa_don_xuat
                    SET da_xoa = 1
                    WHERE da_xoa = 0 AND id IN ('.$list_id_hoa_don_xuat_muon_xoa.')';

            DB::update($sql);
        });
    }

    public function getIdHoaDonXuatCuoiCung()
    {
        $id_hoa_don_xuat_cuoi_cung = DB::table('hoa_don_xuat')
                                       ->select('id')
                                       ->orderBy('id', 'desc')
                                       ->first();
        $id_hoa_don_xuat_cuoi_cung = $id_hoa_don_xuat_cuoi_cung->id;
        return $id_hoa_don_xuat_cuoi_cung;
    }

    public function themHoaDonXuat(Request $request)
    {
        // Format lại cho "ngay_gio_xuat_hoa_don"
        $ngay_gio_xuat_hoa_don = $request->get('ngay_gio_xuat_hoa_don');
        $ngay_gio_xuat_hoa_don = date('Y-m-d H:i:s', strtotime($ngay_gio_xuat_hoa_don));

        // Thêm hóa đơn xuất
        $hoa_don_xuat = new HoaDonXuat();
        $hoa_don_xuat->id_don_hang_khach_hang = (int)($request->get('id_don_hang_khach_hang'));
        $hoa_don_xuat->id_khach_hang = (int)($request->get('id_khach_hang'));
        $hoa_don_xuat->id_loai_vai = (int)($request->get('id_loai_vai'));
        $hoa_don_xuat->id_mau = (int)($request->get('id_mau'));
        $hoa_don_xuat->kho = (float)($request->get('kho'));
        $hoa_don_xuat->tong_so_cay_vai = (int)($request->get('tong_so_cay_vai'));
        $hoa_don_xuat->tong_so_met = (int)($request->get('tong_so_met'));
        $hoa_don_xuat->tong_tien = (int)($request->get('tong_tien'));
        $hoa_don_xuat->id_kho = (int)($request->get('id_kho'));
        $hoa_don_xuat->id_nhan_vien_xuat = (int)($request->get('id_nhan_vien_xuat'));
        $hoa_don_xuat->ngay_gio_xuat_hoa_don = $ngay_gio_xuat_hoa_don;
        $hoa_don_xuat->tinh_chat = $request->get('tinh_chat');

        $hoa_don_xuat->insert();
    }




































    // TỪ ĐÂY TRỞ XUỐNG LÀ XÓA
    public function capNhatPhieuXuatMoc(Request $request)
    {
        // Format lại cho "ngay_gio_xuat_kho"
        $ngay_gio_xuat_kho = $request->get('ngay_gio_xuat_kho');
        $ngay_gio_xuat_kho = date('Y-m-d H:i:s', strtotime($ngay_gio_xuat_kho));

        // Cập nhật phiếu xuất mộc
        $phieu_xuat_moc = new PhieuXuatMoc();
        $phieu_xuat_moc->id = (int)($request->get('idPhieuXuatMoc'));
        $phieu_xuat_moc->id_kho = (int)($request->get('id_kho'));
        $phieu_xuat_moc->id_nhan_vien_xuat = (int)($request->get('id_nhan_vien_xuat'));
        $phieu_xuat_moc->ngay_gio_xuat_kho = $ngay_gio_xuat_kho;

        $phieu_xuat_moc->update();
    }
}