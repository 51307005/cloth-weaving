<?php

namespace App\Http\Repositories;

use DB;
use App\Http\Entities\Moc;
use Illuminate\Http\Request;

class MocRepository
{
    public function demTongSoCayMocTonKho($id_kho, $id_loai_vai = null)
    {
        if ($id_loai_vai == null)
        {
            $count = DB::table('cay_vai_moc')
                       ->where('da_xoa', '=', 0)
                       ->where('tinh_trang', '=', 'Chưa xuất')
                       ->where('id_kho', '=', $id_kho)
                       ->count();
        }
        else
        {
            $count = DB::table('cay_vai_moc')
                       ->where('da_xoa', '=', 0)
                       ->where('tinh_trang', '=', 'Chưa xuất')
                       ->where('id_kho', '=', $id_kho)
                       ->where('id_loai_vai', '=', $id_loai_vai)
                       ->count();
        }

        return $count;
    }

    public function demTongSoCayMoc($id_kho)
    {
        $count = DB::table('cay_vai_moc')
                   ->where('da_xoa', '=', 0)
                   ->where('id_kho', '=', $id_kho)
                   ->count();
        return $count;
    }

    public function getSoCayMocTonKhoTheoLoaiVai($id_kho)
    {
        $soCayMocTonKhoTheoLoaiVai = DB::table('cay_vai_moc')
                                       ->join('loai_vai', 'cay_vai_moc.id_loai_vai', '=', 'loai_vai.id')
                                       ->select(DB::raw('loai_vai.ten as ten_loai_vai, count(cay_vai_moc.id) as so_cay_moc'))
                                       ->where('cay_vai_moc.da_xoa', '=', 0)
                                       ->where('cay_vai_moc.tinh_trang', '=', 'Chưa xuất')
                                       ->where('cay_vai_moc.id_kho', '=', $id_kho)
                                       ->groupBy('cay_vai_moc.id_loai_vai')
                                       ->get();
        return $soCayMocTonKhoTheoLoaiVai;
    }

    public function getSoCayMocTheoLoaiVai($id_kho)
    {
        $soCayMocTheoLoaiVai = DB::table('cay_vai_moc')
                                       ->join('loai_vai', 'cay_vai_moc.id_loai_vai', '=', 'loai_vai.id')
                                       ->select(DB::raw('loai_vai.ten as ten_loai_vai, count(cay_vai_moc.id) as so_cay_moc'))
                                       ->where('cay_vai_moc.da_xoa', '=', 0)
                                       ->where('cay_vai_moc.id_kho', '=', $id_kho)
                                       ->groupBy('cay_vai_moc.id_loai_vai')
                                       ->get();
        return $soCayMocTheoLoaiVai;
    }

    public function getCacLoaiVaiKhongConCayMocTonKhoTrongKhoMoc($id_kho)
    {
        $sql = "SELECT lv.ten AS ten_loai_vai
                FROM cay_vai_moc cvm, loai_vai lv
                WHERE cvm.id_loai_vai = lv.id AND cvm.da_xoa = 0 AND cvm.id_kho = ".$id_kho.
                " AND cvm.id_loai_vai NOT IN (SELECT DISTINCT id_loai_vai
                                              FROM cay_vai_moc cvm
                                              WHERE cvm.da_xoa = 0 AND cvm.tinh_trang = 'Chưa xuất' AND cvm.id_kho = ".$id_kho.")
                GROUP BY cvm.id_loai_vai";
        $cacLoaiVaiKhongConCayMocTonKhoTrongKhoMoc = DB::select($sql);

        return $cacLoaiVaiKhongConCayMocTonKhoTrongKhoMoc;
    }

    public function getDanhSachCayMocTonKho($id_kho, $id_loai_vai = null)
    {
        if ($id_loai_vai == null)
        {
            $list_cay_moc_ton_kho = DB::table('cay_vai_moc')
                                      ->join('loai_vai', 'cay_vai_moc.id_loai_vai', '=', 'loai_vai.id')
                                      ->join('nhan_vien', 'cay_vai_moc.id_nhan_vien_det', '=', 'nhan_vien.id')
                                      ->select('cay_vai_moc.*', 'loai_vai.ten as ten_loai_vai', 'nhan_vien.ho_ten as ten_nhan_vien_det')
                                      ->where('cay_vai_moc.da_xoa', '=', 0)
                                      ->where('cay_vai_moc.tinh_trang', '=', 'Chưa xuất')
                                      ->where('cay_vai_moc.id_kho', '=', $id_kho)
                                      ->paginate(10);
        }
        else
        {
            $list_cay_moc_ton_kho = DB::table('cay_vai_moc')
                                      ->join('loai_vai', 'cay_vai_moc.id_loai_vai', '=', 'loai_vai.id')
                                      ->join('nhan_vien', 'cay_vai_moc.id_nhan_vien_det', '=', 'nhan_vien.id')
                                      ->select('cay_vai_moc.*', 'loai_vai.ten as ten_loai_vai', 'nhan_vien.ho_ten as ten_nhan_vien_det')
                                      ->where('cay_vai_moc.da_xoa', '=', 0)
                                      ->where('cay_vai_moc.tinh_trang', '=', 'Chưa xuất')
                                      ->where('cay_vai_moc.id_kho', '=', $id_kho)
                                      ->where('cay_vai_moc.id_loai_vai', '=', $id_loai_vai)
                                      ->paginate(10);
        }

        return $list_cay_moc_ton_kho;
    }

    public function getDanhSachCayMoc($id_kho)
    {
        $list_cay_moc = DB::table('cay_vai_moc')
                          ->join('loai_vai', 'cay_vai_moc.id_loai_vai', '=', 'loai_vai.id')
                          ->join('nhan_vien', 'cay_vai_moc.id_nhan_vien_det', '=', 'nhan_vien.id')
                          ->select('cay_vai_moc.*', 'loai_vai.ten as ten_loai_vai', 'nhan_vien.ho_ten as ten_nhan_vien_det')
                          ->where('cay_vai_moc.da_xoa', '=', 0)
                          ->where('cay_vai_moc.id_kho', '=', $id_kho)
                          ->paginate(10);
        return $list_cay_moc;
    }

    public function deleteCacCayMoc($list_id_cay_moc_muon_xoa)
    {
        return DB::transaction(function() use ($list_id_cay_moc_muon_xoa) {
            $sql = 'UPDATE cay_vai_moc
                    SET da_xoa = 1
                    WHERE id IN ('.$list_id_cay_moc_muon_xoa.')';

            DB::update($sql);
        });
    }

    public function getDanhSachIdCayMoc()
    {
        $list_id_cay_moc = DB::table('cay_vai_moc')
                             ->select('id')
                             ->where('da_xoa', '=', 0)
                             ->get();
        return $list_id_cay_moc;
    }

    public function getCayMocById($id_cay_moc)
    {
        $cay_moc = new Moc();
        $cay_moc->id = $id_cay_moc;
        $thongTin = $cay_moc->getThongTinById();

        if (count($thongTin) == 1)  // Lấy được thông tin của cây mộc bằng id
        {
            $cay_moc->id_loai_vai = $thongTin->id_loai_vai;
            $cay_moc->id_loai_soi = $thongTin->id_loai_soi;
            $cay_moc->so_met = $thongTin->so_met;
            $cay_moc->id_nhan_vien_det = $thongTin->id_nhan_vien_det;
            $cay_moc->ma_may_det = $thongTin->ma_may_det;
            $cay_moc->ngay_gio_det = $thongTin->ngay_gio_det;
            $cay_moc->id_kho = $thongTin->id_kho;
            $cay_moc->ngay_gio_nhap_kho = $thongTin->ngay_gio_nhap_kho;
            $cay_moc->id_phieu_xuat_moc = $thongTin->id_phieu_xuat_moc;
            $cay_moc->tinh_trang = $thongTin->tinh_trang;
            $cay_moc->id_lo_nhuom = $thongTin->id_lo_nhuom;
            $cay_moc->da_xoa = $thongTin->da_xoa;

            return $cay_moc;
        }

        // Id cây mộc không tồn tại trong database
        return false;
    }

    public function capNhatCayMoc(Request $request)
    {
        // Format lại cho "ngay_gio_det" và "ngay_gio_nhap_kho"
        $ngay_gio_det = $request->get('ngay_gio_det');
        $ngay_gio_det = date('Y-m-d H:i:s', strtotime($ngay_gio_det));
        $ngay_gio_nhap_kho = $request->get('ngay_gio_nhap_kho');
        $ngay_gio_nhap_kho = date('Y-m-d H:i:s', strtotime($ngay_gio_nhap_kho));

        // Xử lý trường hợp "id_phieu_xuat_moc" null hoặc "id_lo_nhuom" null
        $id_phieu_xuat_moc = $request->get('id_phieu_xuat_moc');
        $id_lo_nhuom = $request->get('id_lo_nhuom');
        if ($id_phieu_xuat_moc == 'null')
        {
            $id_phieu_xuat_moc = null;
        }
        else
        {
            $id_phieu_xuat_moc = (int)$id_phieu_xuat_moc;
        }
        if ($id_lo_nhuom == 'null')
        {
            $id_lo_nhuom = null;
        }
        else
        {
            $id_lo_nhuom = (int)$id_lo_nhuom;
        }

        // Cập nhật cây mộc
        $cay_moc = new Moc();
        $cay_moc->id = (int)($request->get('idCayMoc'));
        $cay_moc->id_loai_vai = (int)($request->get('id_loai_vai'));
        $cay_moc->id_loai_soi = (int)($request->get('id_loai_soi'));
        $cay_moc->so_met = (int)($request->get('so_met'));
        $cay_moc->id_nhan_vien_det = (int)($request->get('id_nhan_vien_det'));
        $cay_moc->ma_may_det = (int)($request->get('id_may_det'));
        $cay_moc->ngay_gio_det = $ngay_gio_det;
        $cay_moc->id_kho = (int)($request->get('id_kho'));
        $cay_moc->ngay_gio_nhap_kho = $ngay_gio_nhap_kho;
        $cay_moc->id_phieu_xuat_moc = $id_phieu_xuat_moc;
        $cay_moc->tinh_trang = $request->get('tinh_trang');
        $cay_moc->id_lo_nhuom = $id_lo_nhuom;

        $cay_moc->update();
    }
}