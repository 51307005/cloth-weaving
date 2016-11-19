<?php

namespace App\Http\Repositories;

use DB;
use Illuminate\Http\Request;
use App\Http\Entities\ThanhPham;

class ThanhPhamRepository
{
    public function deleteCacCayThanhPham($list_id_cay_thanh_pham_muon_xoa)
    {
        return DB::transaction(function() use ($list_id_cay_thanh_pham_muon_xoa) {
            $sql = 'UPDATE cay_vai_thanh_pham
                    SET da_xoa = 1
                    WHERE id IN ('.$list_id_cay_thanh_pham_muon_xoa.')';

            DB::update($sql);
        });
    }

    public function demTongSoCayThanhPhamTonKho($id_kho, $id_loai_vai = null, $id_mau = null, $kho = null)
    {
        if ($id_loai_vai == null)
        {
            $count = DB::table('cay_vai_thanh_pham')
                       ->where('da_xoa', '=', 0)
                       ->where('tinh_trang', '=', 'Chưa xuất')
                       ->where('id_kho', '=', $id_kho)
                       ->count();
        }
        else
        {
            $count = DB::table('cay_vai_thanh_pham')
                       ->where('da_xoa', '=', 0)
                       ->where('tinh_trang', '=', 'Chưa xuất')
                       ->where('id_kho', '=', $id_kho)
                       ->where('id_loai_vai', '=', $id_loai_vai)
                       ->where('id_mau', '=', $id_mau)
                       ->where('kho', '=', $kho)
                       ->count();
        }

        return $count;
    }

    public function getSoCayThanhPhamTonKhoTheoLoaiVai($id_kho)
    {
        $soCayThanhPhamTonKhoTheoLoaiVai = DB::table('cay_vai_thanh_pham')
                                             ->join('loai_vai', 'cay_vai_thanh_pham.id_loai_vai', '=', 'loai_vai.id')
                                             ->select(DB::raw('loai_vai.ten as ten_loai_vai, count(cay_vai_thanh_pham.id) as so_cay_thanh_pham'))
                                             ->where('cay_vai_thanh_pham.da_xoa', '=', 0)
                                             ->where('cay_vai_thanh_pham.tinh_trang', '=', 'Chưa xuất')
                                             ->where('cay_vai_thanh_pham.id_kho', '=', $id_kho)
                                             ->groupBy('cay_vai_thanh_pham.id_loai_vai')
                                             ->get();
        return $soCayThanhPhamTonKhoTheoLoaiVai;
    }

    public function getCacLoaiVaiKhongConCayThanhPhamTonKhoTrongKhoThanhPham($id_kho)
    {
        $sql = "SELECT lv.ten AS ten_loai_vai
                FROM cay_vai_thanh_pham cvtp, loai_vai lv
                WHERE cvtp.id_loai_vai = lv.id AND cvtp.da_xoa = 0 AND cvtp.id_kho = ".$id_kho.
                " AND cvtp.id_loai_vai NOT IN (SELECT DISTINCT id_loai_vai
                                               FROM cay_vai_thanh_pham cvtp
                                               WHERE cvtp.da_xoa = 0 AND cvtp.tinh_trang = 'Chưa xuất' AND cvtp.id_kho = ".$id_kho.")
                GROUP BY cvtp.id_loai_vai";
        $cacLoaiVaiKhongConCayThanhPhamTonKhoTrongKhoThanhPham = DB::select($sql);

        return $cacLoaiVaiKhongConCayThanhPhamTonKhoTrongKhoThanhPham;
    }

    public function getDanhSachCayThanhPhamTonKho($id_kho, $id_loai_vai = null, $id_mau = null, $kho = null)
    {
        if ($id_loai_vai == null)
        {
            $list_cay_thanh_pham_ton_kho = DB::table('cay_vai_thanh_pham')
                                             ->join('loai_vai', 'cay_vai_thanh_pham.id_loai_vai', '=', 'loai_vai.id')
                                             ->join('mau', 'cay_vai_thanh_pham.id_mau', '=', 'mau.id')
                                             ->select('cay_vai_thanh_pham.*', 'loai_vai.ten as ten_loai_vai', 'mau.ten as ten_mau')
                                             ->where('cay_vai_thanh_pham.da_xoa', '=', 0)
                                             ->where('cay_vai_thanh_pham.tinh_trang', '=', 'Chưa xuất')
                                             ->where('cay_vai_thanh_pham.id_kho', '=', $id_kho)
                                             ->paginate(10);
        }
        else
        {
            $list_cay_thanh_pham_ton_kho = DB::table('cay_vai_thanh_pham')
                                             ->join('loai_vai', 'cay_vai_thanh_pham.id_loai_vai', '=', 'loai_vai.id')
                                             ->join('mau', 'cay_vai_thanh_pham.id_mau', '=', 'mau.id')
                                             ->select('cay_vai_thanh_pham.*', 'loai_vai.ten as ten_loai_vai', 'mau.ten as ten_mau')
                                             ->where('cay_vai_thanh_pham.da_xoa', '=', 0)
                                             ->where('cay_vai_thanh_pham.tinh_trang', '=', 'Chưa xuất')
                                             ->where('cay_vai_thanh_pham.id_kho', '=', $id_kho)
                                             ->where('cay_vai_thanh_pham.id_loai_vai', '=', $id_loai_vai)
                                             ->where('cay_vai_thanh_pham.id_mau', '=', $id_mau)
                                             ->where('cay_vai_thanh_pham.kho', '=', $kho)
                                             ->paginate(10);
        }

        return $list_cay_thanh_pham_ton_kho;
    }

    public function demTongSoCayThanhPham($id_kho)
    {
        $count = DB::table('cay_vai_thanh_pham')
                   ->where('da_xoa', '=', 0)
                   ->where('id_kho', '=', $id_kho)
                   ->count();
        return $count;
    }

    public function getSoCayThanhPhamTheoLoaiVai($id_kho)
    {
        $soCayThanhPhamTheoLoaiVai = DB::table('cay_vai_thanh_pham')
                                       ->join('loai_vai', 'cay_vai_thanh_pham.id_loai_vai', '=', 'loai_vai.id')
                                       ->select(DB::raw('loai_vai.ten as ten_loai_vai, count(cay_vai_thanh_pham.id) as so_cay_thanh_pham'))
                                       ->where('cay_vai_thanh_pham.da_xoa', '=', 0)
                                       ->where('cay_vai_thanh_pham.id_kho', '=', $id_kho)
                                       ->groupBy('cay_vai_thanh_pham.id_loai_vai')
                                       ->get();
        return $soCayThanhPhamTheoLoaiVai;
    }

    public function getDanhSachCayThanhPham($id_kho)
    {
        $list_cay_thanh_pham = DB::table('cay_vai_thanh_pham')
                                 ->join('loai_vai', 'cay_vai_thanh_pham.id_loai_vai', '=', 'loai_vai.id')
                                 ->join('mau', 'cay_vai_thanh_pham.id_mau', '=', 'mau.id')
                                 ->select('cay_vai_thanh_pham.*', 'loai_vai.ten as ten_loai_vai', 'mau.ten as ten_mau')
                                 ->where('cay_vai_thanh_pham.da_xoa', '=', 0)
                                 ->where('cay_vai_thanh_pham.id_kho', '=', $id_kho)
                                 ->paginate(10);
        return $list_cay_thanh_pham;
    }

    public function getDanhSachIdCayThanhPham()
    {
        $list_id_cay_thanh_pham = DB::table('cay_vai_thanh_pham')
                                    ->select('id')
                                    ->where('da_xoa', '=', 0)
                                    ->get();
        return $list_id_cay_thanh_pham;
    }

    public function getCayThanhPhamById($id_cay_thanh_pham)
    {
        $cay_thanh_pham = new ThanhPham();
        $cay_thanh_pham->id = $id_cay_thanh_pham;
        $thongTin = $cay_thanh_pham->getThongTinById();

        if (count($thongTin) == 1)  // Lấy được thông tin của cây thành phẩm bằng id
        {
            $cay_thanh_pham->id_cay_vai_moc = $thongTin->id_cay_vai_moc;
            $cay_thanh_pham->id_loai_vai = $thongTin->id_loai_vai;
            $cay_thanh_pham->id_mau = $thongTin->id_mau;
            $cay_thanh_pham->kho = $thongTin->kho;
            $cay_thanh_pham->so_met = $thongTin->so_met;
            $cay_thanh_pham->don_gia = $thongTin->don_gia;
            $cay_thanh_pham->thanh_tien = $thongTin->thanh_tien;
            $cay_thanh_pham->id_lo_nhuom = $thongTin->id_lo_nhuom;
            $cay_thanh_pham->id_kho = $thongTin->id_kho;
            $cay_thanh_pham->ngay_gio_nhap_kho = $thongTin->ngay_gio_nhap_kho;
            $cay_thanh_pham->id_hoa_don_xuat = $thongTin->id_hoa_don_xuat;
            $cay_thanh_pham->tinh_trang = $thongTin->tinh_trang;
            $cay_thanh_pham->da_xoa = $thongTin->da_xoa;
            $cay_thanh_pham->ten_loai_vai = $thongTin->ten_loai_vai;
            $cay_thanh_pham->ten_mau = $thongTin->ten_mau;
            $cay_thanh_pham->ten_kho = $thongTin->ten_kho;

            return $cay_thanh_pham;
        }

        // Id cây thành phẩm không tồn tại trong database
        return false;
    }

    public function capNhatCayThanhPham(Request $request)
    {
        // Format lại cho "ngay_gio_nhap_kho"
        $ngay_gio_nhap_kho = $request->get('ngay_gio_nhap_kho');
        $ngay_gio_nhap_kho = date('Y-m-d H:i:s', strtotime($ngay_gio_nhap_kho));

        // Xử lý trường hợp "don_gia" để trống (không nhập) hoặc "thanh_tien" để trống (không nhập) hoặc "id_hoa_don_xuat" null
        $don_gia = $request->get('don_gia');
        $thanh_tien = $request->get('thanh_tien');
        $id_hoa_don_xuat = $request->get('id_hoa_don_xuat');
        if ($don_gia == '')
        {
            $don_gia = null;
        }
        else
        {
            $don_gia = (int)$don_gia;
        }
        if ($thanh_tien == '')
        {
            $thanh_tien = null;
        }
        else
        {
            $thanh_tien = (int)$thanh_tien;
        }
        if ($id_hoa_don_xuat == 'null')
        {
            $id_hoa_don_xuat = null;
        }
        else
        {
            $id_hoa_don_xuat = (int)$id_hoa_don_xuat;
        }

        // Cập nhật cây thành phẩm
        $cay_thanh_pham = new ThanhPham();
        $cay_thanh_pham->id = (int)($request->get('idCayThanhPham'));
        $cay_thanh_pham->id_cay_vai_moc = (int)($request->get('id_cay_moc'));
        $cay_thanh_pham->id_loai_vai = (int)($request->get('id_loai_vai'));
        $cay_thanh_pham->id_mau = (int)($request->get('id_mau'));
        $cay_thanh_pham->kho = (float)($request->get('kho'));
        $cay_thanh_pham->so_met = (int)($request->get('so_met'));
        $cay_thanh_pham->don_gia = $don_gia;
        $cay_thanh_pham->thanh_tien = $thanh_tien;
        $cay_thanh_pham->id_lo_nhuom = (int)($request->get('id_lo_nhuom'));
        $cay_thanh_pham->id_kho = (int)($request->get('id_kho'));
        $cay_thanh_pham->ngay_gio_nhap_kho = $ngay_gio_nhap_kho;
        $cay_thanh_pham->id_hoa_don_xuat = $id_hoa_don_xuat;
        $cay_thanh_pham->tinh_trang = $request->get('tinh_trang');

        $cay_thanh_pham->update();
    }

    public function getIdCayThanhPhamCuoiCung()
    {
        $id_cay_thanh_pham_cuoi_cung = DB::table('cay_vai_thanh_pham')
                                         ->select('id')
                                         ->orderBy('id', 'desc')
                                         ->first();
        $id_cay_thanh_pham_cuoi_cung = $id_cay_thanh_pham_cuoi_cung->id;

        return $id_cay_thanh_pham_cuoi_cung;
    }

    public function nhapThanhPham(Request $request)
    {
        // Lấy các dữ liệu để nhập thành phẩm
        $id_lo_nhuom = (int)($request->get('id_lo_nhuom'));
        $id_mau = (int)($request->get('id_mau'));
        $id_kho = (int)($request->get('id_kho'));
        $ngay_gio_nhap_kho = $request->get('ngay_gio_nhap_kho');
        $list_cay_thanh_pham = $request->get('data');
        $list_cay_thanh_pham = json_decode($list_cay_thanh_pham);
        //echo '<pre>',print_r($list_cay_thanh_pham),'</pre>';

        // Format lại cho "ngay_gio_nhap_kho"
        $ngay_gio_nhap_kho = date('Y-m-d H:i:s', strtotime($ngay_gio_nhap_kho));

        // Tạo câu lệnh INSERT
        $sql = 'INSERT INTO cay_vai_thanh_pham (id_cay_vai_moc, id_loai_vai, id_mau, kho, so_met, don_gia, thanh_tien, id_lo_nhuom, id_kho, ngay_gio_nhap_kho)
                VALUES ';
        foreach ($list_cay_thanh_pham as $cay_thanh_pham)
        {
            $id_cay_moc = $cay_thanh_pham->id_cay_moc;
            $id_loai_vai = $cay_thanh_pham->id_loai_vai;
            $kho = $cay_thanh_pham->kho;
            $so_met = $cay_thanh_pham->so_met;
            $don_gia = $cay_thanh_pham->don_gia;
            $thanh_tien = $cay_thanh_pham->thanh_tien;

            if ($don_gia == '')
            {
                $don_gia = 'NULL';
            }
            if ($thanh_tien == '')
            {
                $thanh_tien = 'NULL';
            }

            $sql .= '('.$id_cay_moc.', '.$id_loai_vai.', '.$id_mau.', '.$kho.', '.$so_met.', '.$don_gia.', '.$thanh_tien.', '.$id_lo_nhuom.', '.$id_kho.', "'.$ngay_gio_nhap_kho.'"), ';
        }
        $sql = trim($sql, ', ');
        //echo $sql;

        return DB::transaction(function() use ($sql) {
            DB::insert($sql);
        });
    }

    public function getDanhSachIdCayThanhPhamTonKho($id_kho = null)
    {
        if ($id_kho == null)
        {
            $list_id_cay_thanh_pham_ton_kho = DB::table('cay_vai_thanh_pham')
                                                ->select('id')
                                                ->where('da_xoa', '=', 0)
                                                ->where('tinh_trang', '=', 'Chưa xuất')
                                                ->get();
        }
        else
        {
            $list_id_cay_thanh_pham_ton_kho = DB::table('cay_vai_thanh_pham')
                                                ->select('id')
                                                ->where('da_xoa', '=', 0)
                                                ->where('tinh_trang', '=', 'Chưa xuất')
                                                ->where('id_kho', '=', $id_kho)
                                                ->get();
        }

        return $list_id_cay_thanh_pham_ton_kho;
    }

    public function xuatThanhPham(Request $request)
    {
        // Lấy các dữ liệu để xuất thành phẩm
        $id_hoa_don_xuat = (int)($request->get('id_hoa_don_xuat'));
        $list_id_cay_thanh_pham_muon_xuat = $request->get('list_id_cay_thanh_pham_muon_xuat');

        // Xuất thành phẩm
        $sql = 'UPDATE cay_vai_thanh_pham
                SET id_hoa_don_xuat = '.$id_hoa_don_xuat.',
                    tinh_trang = "Đã xuất"
                WHERE da_xoa = 0 AND id IN ('.$list_id_cay_thanh_pham_muon_xuat.')';

        return DB::transaction(function() use ($sql) {
            DB::update($sql);
        });
    }

    public function getDanhSachCayThanhPhamTrongHoaDonXuat($id_hoa_don_xuat)
    {
        $list_cay_thanh_pham_trong_hoa_don_xuat = DB::table('cay_vai_thanh_pham')
                                                    ->join('loai_vai', 'cay_vai_thanh_pham.id_loai_vai', '=', 'loai_vai.id')
                                                    ->join('mau', 'cay_vai_thanh_pham.id_mau', '=', 'mau.id')
                                                    ->join('kho', 'cay_vai_thanh_pham.id_kho', '=', 'kho.id')
                                                    ->select('cay_vai_thanh_pham.*', 'loai_vai.ten as ten_loai_vai', 'mau.ten as ten_mau', 'kho.ten as ten_kho')
                                                    ->where('cay_vai_thanh_pham.da_xoa', '=', 0)
                                                    ->where('cay_vai_thanh_pham.id_hoa_don_xuat', '=', $id_hoa_don_xuat)
                                                    ->get();
        return $list_cay_thanh_pham_trong_hoa_don_xuat;
    }

    public function getDanhSachIdCayThanhPhamTonKhoVaTrongHoaDonXuat($id_hoa_don_xuat, $id_kho = null)
    {
        if ($id_kho == null)
        {
            $sql = 'SELECT id
                    FROM cay_vai_thanh_pham
                    WHERE da_xoa = 0 AND (tinh_trang = "Chưa xuất" OR id_hoa_don_xuat = '.$id_hoa_don_xuat.')';
        }
        else
        {
            $sql = 'SELECT id
                    FROM cay_vai_thanh_pham
                    WHERE da_xoa = 0 AND ((tinh_trang = "Chưa xuất" AND id_kho = '.$id_kho.') OR (id_hoa_don_xuat = '.$id_hoa_don_xuat.'))';
        }

        $list_id_cay_thanh_pham_ton_kho_hoac_trong_hoa_don_xuat_duoc_chon = DB::select($sql);

        return $list_id_cay_thanh_pham_ton_kho_hoac_trong_hoa_don_xuat_duoc_chon;
    }

    public function capNhatXuatThanhPham($id_hoa_don_xuat, $list_id_cay_thanh_pham_muon_xuat)
    {
        $sql_1 = 'UPDATE cay_vai_thanh_pham
                  SET id_hoa_don_xuat = NULL,
                      tinh_trang = "Chưa xuất"
                  WHERE da_xoa = 0 AND id_hoa_don_xuat = '.$id_hoa_don_xuat;

        $sql_2 = 'UPDATE cay_vai_thanh_pham
                  SET id_hoa_don_xuat = '.$id_hoa_don_xuat.',
                      tinh_trang = "Đã xuất"
                  WHERE da_xoa = 0 AND id IN ('.$list_id_cay_thanh_pham_muon_xuat.')';

        return DB::transaction(function() use ($sql_1, $sql_2) {
            DB::update($sql_1);
            DB::update($sql_2);
        });
    }
}