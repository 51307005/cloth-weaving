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

    public function getDanhSachIdCayMocTonKho($id_kho = null)
    {
        if ($id_kho == null)
        {
            $list_id_cay_moc_ton_kho = DB::table('cay_vai_moc')
                                         ->select('id')
                                         ->where('da_xoa', '=', 0)
                                         ->where('tinh_trang', '=', 'Chưa xuất')
                                         ->get();
        }
        else
        {
            $list_id_cay_moc_ton_kho = DB::table('cay_vai_moc')
                                         ->select('id')
                                         ->where('da_xoa', '=', 0)
                                         ->where('tinh_trang', '=', 'Chưa xuất')
                                         ->where('id_kho', '=', $id_kho)
                                         ->get();
        }

        return $list_id_cay_moc_ton_kho;
    }

    public function getDanhSachIdCayMocTonKhoVaTrongPhieuXuatMoc($id_phieu_xuat_moc, $id_kho = null)
    {
        if ($id_kho == null)
        {
            $sql = 'SELECT id
                    FROM cay_vai_moc
                    WHERE da_xoa = 0 AND (tinh_trang = "Chưa xuất" OR id_phieu_xuat_moc = '.$id_phieu_xuat_moc.')';
        }
        else
        {
            $sql = 'SELECT id
                    FROM cay_vai_moc
                    WHERE da_xoa = 0 AND ((tinh_trang = "Chưa xuất" AND id_kho = '.$id_kho.') OR (id_phieu_xuat_moc = '.$id_phieu_xuat_moc.'))';
        }

        $list_id_cay_moc_ton_kho_hoac_trong_phieu_xuat_moc_duoc_chon = DB::select($sql);

        return $list_id_cay_moc_ton_kho_hoac_trong_phieu_xuat_moc_duoc_chon;
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
            $cay_moc->ten_loai_vai = $thongTin->ten_loai_vai;
            $cay_moc->ten_loai_soi = $thongTin->ten_loai_soi;
            $cay_moc->ten_nhan_vien_det = $thongTin->ten_nhan_vien_det;
            $cay_moc->ten_kho = $thongTin->ten_kho;

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

    public function getIdCayMocCuoiCung()
    {
        $id_cay_moc_cuoi_cung = DB::table('cay_vai_moc')
                                  ->select('id')
                                  ->orderBy('id', 'desc')
                                  ->first();
        $id_cay_moc_cuoi_cung = $id_cay_moc_cuoi_cung->id;

        return $id_cay_moc_cuoi_cung;
    }

    public function nhapMoc(Request $request)
    {
        // Lấy các dữ liệu để nhập mộc
        $id_loai_vai = (int)($request->get('id_loai_vai'));
        $id_loai_soi = (int)($request->get('id_loai_soi'));
        $id_kho = (int)($request->get('id_kho'));
        $ngay_gio_nhap_kho = $request->get('ngay_gio_nhap_kho');
        $list_cay_moc = $request->get('data');
        $list_cay_moc = json_decode($list_cay_moc);
        //echo '<pre>',print_r($list_cay_moc),'</pre>';

        // Format lại cho "ngay_gio_nhap_kho"
        $ngay_gio_nhap_kho = date('Y-m-d H:i:s', strtotime($ngay_gio_nhap_kho));

        // Tạo câu lệnh INSERT
        $sql = 'INSERT INTO cay_vai_moc (id_loai_vai, id_loai_soi, so_met, id_nhan_vien_det, ma_may_det, ngay_gio_det, id_kho, ngay_gio_nhap_kho)
                VALUES ';
        foreach ($list_cay_moc as $cay_moc)
        {
            $so_met = $cay_moc->so_met;
            $id_nhan_vien_det = $cay_moc->id_nhan_vien_det;
            $id_may_det = $cay_moc->id_may_det;
            $ngay_gio_det = $cay_moc->ngay_gio_det;

            // Format lại cho "ngay_gio_det"
            $ngay_gio_det = date('Y-m-d H:i:s', strtotime($ngay_gio_det));

            $sql .= '('.$id_loai_vai.', '.$id_loai_soi.', '.$so_met.', '.$id_nhan_vien_det.', '.$id_may_det.', "'.$ngay_gio_det.'", '.$id_kho.', "'.$ngay_gio_nhap_kho.'"), ';
        }
        $sql = trim($sql, ', ');
        //echo $sql;

        return DB::transaction(function() use ($sql) {
            DB::insert($sql);
        });
    }

    public function xuatMoc(Request $request)
    {
        // Lấy các dữ liệu để xuất mộc
        $id_phieu_xuat_moc = (int)($request->get('id_phieu_xuat_moc'));
        $list_id_cay_moc_muon_xuat = $request->get('list_id_cay_moc_muon_xuat');

        // Xuất mộc
        $sql = 'UPDATE cay_vai_moc
                SET id_phieu_xuat_moc = '.$id_phieu_xuat_moc.',
                    tinh_trang = "Đã xuất"
                WHERE da_xoa = 0 AND id IN ('.$list_id_cay_moc_muon_xuat.')';

        return DB::transaction(function() use ($sql) {
            DB::update($sql);
        });
    }

    public function getDanhSachCayMocTrongPhieuXuatMoc($id_phieu_xuat_moc)
    {
        $list_cay_moc_trong_phieu_xuat_moc = DB::table('cay_vai_moc')
                                               ->join('loai_vai', 'cay_vai_moc.id_loai_vai', '=', 'loai_vai.id')
                                               ->join('loai_soi', 'cay_vai_moc.id_loai_soi', '=', 'loai_soi.id')
                                               ->join('nhan_vien', 'cay_vai_moc.id_nhan_vien_det', '=', 'nhan_vien.id')
                                               ->join('kho', 'cay_vai_moc.id_kho', '=', 'kho.id')
                                               ->select('cay_vai_moc.*', 'loai_vai.ten as ten_loai_vai', 'loai_soi.ten as ten_loai_soi', 'nhan_vien.ho_ten as ten_nhan_vien_det', 'kho.ten as ten_kho')
                                               ->where('cay_vai_moc.da_xoa', '=', 0)
                                               ->where('cay_vai_moc.id_phieu_xuat_moc', '=', $id_phieu_xuat_moc)
                                               ->get();
        return $list_cay_moc_trong_phieu_xuat_moc;
    }

    public function capNhatXuatMoc($id_phieu_xuat_moc, $list_id_cay_moc_muon_xuat)
    {
        $sql_1 = 'UPDATE cay_vai_moc
                  SET id_phieu_xuat_moc = NULL,
                      tinh_trang = "Chưa xuất",
                      id_lo_nhuom = NULL
                  WHERE da_xoa = 0 AND id_phieu_xuat_moc = '.$id_phieu_xuat_moc;

        $sql_2 = 'UPDATE cay_vai_moc
                  SET id_phieu_xuat_moc = '.$id_phieu_xuat_moc.',
                      tinh_trang = "Đã xuất"
                  WHERE da_xoa = 0 AND id IN ('.$list_id_cay_moc_muon_xuat.')';

        return DB::transaction(function() use ($sql_1, $sql_2) {
            DB::update($sql_1);
            DB::update($sql_2);
        });
    }

    public function getDanhSachIdCayMocChoViecNhap_CapNhatCayThanhPham()
    {
        $sql = 'SELECT id
                FROM cay_vai_moc
                WHERE da_xoa = 0 AND tinh_trang = "Đã xuất" AND
                      id NOT IN (SELECT id_cay_vai_moc
                                 FROM cay_vai_thanh_pham
                                 WHERE da_xoa = 0)';

        $list_id_cay_moc = DB::select($sql);

        return $list_id_cay_moc;
    }

    public function nhapThanhPham(Request $request)
    {
        // Lấy các dữ liệu để cập nhật cho cây mộc
        $id_lo_nhuom = (int)($request->get('id_lo_nhuom'));
        $list_cay_thanh_pham = $request->get('data');
        $list_cay_thanh_pham = json_decode($list_cay_thanh_pham);
        //echo '<pre>',print_r($list_cay_thanh_pham),'</pre>';

        // Tạo danh sách id cây mộc cần cập nhật
        $list_id_cay_moc_can_cap_nhat = '';
        foreach ($list_cay_thanh_pham as $cay_thanh_pham)
        {
            $list_id_cay_moc_can_cap_nhat .= $cay_thanh_pham->id_cay_moc.',';
        }
        $list_id_cay_moc_can_cap_nhat = trim($list_id_cay_moc_can_cap_nhat, ',');
        //echo $list_id_cay_moc_can_cap_nhat;

        // Tạo câu lệnh UPDATE
        $sql = 'UPDATE cay_vai_moc
                SET id_lo_nhuom = '.$id_lo_nhuom.'
                WHERE da_xoa = 0 AND id IN ('.$list_id_cay_moc_can_cap_nhat.')';
        //echo $sql;

        return DB::transaction(function() use ($sql) {
            DB::update($sql);
        });
    }
}