<?php

namespace App\Http\Repositories;

use DB;
use Illuminate\Http\Request;
use App\Http\Entities\PhieuXuatMoc;

class PhieuXuatMocRepository
{
    public function getDanhSachIdPhieuXuatMoc()
    {
        $list_id_phieu_xuat_moc = DB::table('phieu_xuat_moc')
                                    ->select('id')
                                    ->where('da_xoa', '=', 0)
                                    ->get();
        return $list_id_phieu_xuat_moc;
    }

    public function getDanhSachPhieuXuatMoc()
    {
        $list_phieu_xuat_moc = DB::table('phieu_xuat_moc')
                                 ->join('kho', 'phieu_xuat_moc.id_kho', '=', 'kho.id')
                                 ->join('nhan_vien', 'phieu_xuat_moc.id_nhan_vien_xuat', '=', 'nhan_vien.id')
                                 ->select('phieu_xuat_moc.*', 'kho.ten as ten_kho', 'nhan_vien.ho_ten as ten_nhan_vien_xuat')
                                 ->where('phieu_xuat_moc.da_xoa', '=', 0)
                                 ->paginate(15);
        return $list_phieu_xuat_moc;
    }

    public function deleteCacPhieuXuatMoc($list_id_phieu_xuat_moc_muon_xoa)
    {
        return DB::transaction(function() use ($list_id_phieu_xuat_moc_muon_xoa) {
            $sql = 'UPDATE phieu_xuat_moc
                    SET da_xoa = 1
                    WHERE id IN ('.$list_id_phieu_xuat_moc_muon_xoa.')';

            DB::update($sql);
        });
    }

    public function getIdPhieuXuatMocCuoiCung()
    {
        $id_phieu_xuat_moc_cuoi_cung = DB::table('phieu_xuat_moc')
                                         ->select('id')
                                         ->orderBy('id', 'desc')
                                         ->first();
        $id_phieu_xuat_moc_cuoi_cung = $id_phieu_xuat_moc_cuoi_cung->id;
        return $id_phieu_xuat_moc_cuoi_cung;
    }

    public function themPhieuXuatMoc(Request $request)
    {
        // Format lại cho "ngay_gio_xuat_kho"
        $ngay_gio_xuat_kho = $request->get('ngay_gio_xuat_kho');
        $ngay_gio_xuat_kho = date('Y-m-d H:i:s', strtotime($ngay_gio_xuat_kho));

        // Thêm phiếu xuất mộc
        $phieu_xuat_moc = new PhieuXuatMoc();
        $phieu_xuat_moc->tong_so_cay_moc = (int)($request->get('tong_so_cay_moc'));
        $phieu_xuat_moc->tong_so_met = (int)($request->get('tong_so_met'));
        $phieu_xuat_moc->id_kho = (int)($request->get('id_kho'));
        $phieu_xuat_moc->id_nhan_vien_xuat = (int)($request->get('id_nhan_vien_xuat'));
        $phieu_xuat_moc->ngay_gio_xuat_kho = $ngay_gio_xuat_kho;

        $phieu_xuat_moc->insert();
    }

    public function getPhieuXuatMocById($id_phieu_xuat_moc)
    {
        $phieu_xuat_moc = new PhieuXuatMoc();
        $phieu_xuat_moc->id = $id_phieu_xuat_moc;
        $thongTin = $phieu_xuat_moc->getThongTinById();

        if (count($thongTin) == 1)  // Lấy được thông tin của phiếu xuất mộc bằng id
        {
            $phieu_xuat_moc->tong_so_cay_moc = $thongTin->tong_so_cay_moc;
            $phieu_xuat_moc->tong_so_met = $thongTin->tong_so_met;
            $phieu_xuat_moc->id_kho = $thongTin->id_kho;
            $phieu_xuat_moc->id_nhan_vien_xuat = $thongTin->id_nhan_vien_xuat;
            $phieu_xuat_moc->ngay_gio_xuat_kho = $thongTin->ngay_gio_xuat_kho;
            $phieu_xuat_moc->da_xoa = $thongTin->da_xoa;

            return $phieu_xuat_moc;
        }

        // Id phiếu xuất mộc không tồn tại trong database
        return false;
    }

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