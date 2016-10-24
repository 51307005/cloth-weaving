<?php

namespace App\Http\Repositories;

use DB;

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
}