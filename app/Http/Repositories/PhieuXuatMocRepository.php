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
                    WHERE da_xoa = 0 AND id IN ('.$list_id_phieu_xuat_moc_muon_xoa.')';

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
            $phieu_xuat_moc->ten_kho = $thongTin->ten_kho;
            $phieu_xuat_moc->ten_nhan_vien_xuat = $thongTin->ten_nhan_vien_xuat;

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

    public function capNhatXuatMoc($id_phieu_xuat_moc, $tong_so_cay_moc, $tong_so_met)
    {
        $sql = 'UPDATE phieu_xuat_moc
                SET tong_so_cay_moc = '.$tong_so_cay_moc.',
                    tong_so_met = '.$tong_so_met.'
                WHERE da_xoa = 0 AND id = '.$id_phieu_xuat_moc;

        return DB::transaction(function() use ($sql) {
            DB::update($sql);
        });
    }

    public function capNhatCayMoc(Request $request)
    {
        $cay_moc_cu = $request->get('cay_moc_cu');
        $cay_moc_cu = json_decode($cay_moc_cu);

        $id_phieu_xuat_moc_cu = $cay_moc_cu->id_phieu_xuat_moc;
        $id_phieu_xuat_moc_moi = (int)($request->get('id_phieu_xuat_moc'));
        $so_met_cu = $cay_moc_cu->so_met;
        $so_met_moi = (int)($request->get('so_met'));

        if ($id_phieu_xuat_moc_cu == null && $id_phieu_xuat_moc_moi != 0)   // Lúc đầu cây mộc không nằm trong phiếu xuất mộc nào, lúc sau cây mộc nằm trong 1 phiếu xuất mộc nào đó
        {
            $sql = 'UPDATE phieu_xuat_moc
                    SET tong_so_cay_moc = tong_so_cay_moc + 1,
                        tong_so_met = tong_so_met + '.$so_met_moi.'
                    WHERE da_xoa = 0 AND id = '.$id_phieu_xuat_moc_moi;

            return DB::transaction(function() use ($sql) {
                DB::update($sql);
            });
        }
        else if ($id_phieu_xuat_moc_cu != null && $id_phieu_xuat_moc_moi == 0)   // Lúc đầu cây mộc nằm trong 1 phiếu xuất mộc nào đó, lúc sau cây mộc không nằm trong phiếu xuất mộc nào
        {
            $sql = 'UPDATE phieu_xuat_moc
                    SET tong_so_cay_moc = tong_so_cay_moc - 1,
                        tong_so_met = tong_so_met - '.$so_met_cu.'
                    WHERE da_xoa = 0 AND id = '.$id_phieu_xuat_moc_cu;

            return DB::transaction(function() use ($sql) {
                DB::update($sql);
            });
        }
        else if ($id_phieu_xuat_moc_cu != null && $id_phieu_xuat_moc_moi != 0 && $id_phieu_xuat_moc_cu == $id_phieu_xuat_moc_moi)    // Lúc đầu cây mộc nằm trong phiếu xuất mộc này và lúc sau cây mộc vẫn nằm trong phiếu xuất mộc đó
        {
            $sql = 'UPDATE phieu_xuat_moc
                    SET tong_so_met = tong_so_met - '.$so_met_cu.' + '.$so_met_moi.'
                    WHERE da_xoa = 0 AND id = '.$id_phieu_xuat_moc_moi;

            return DB::transaction(function() use ($sql) {
                DB::update($sql);
            });
        }
        else if ($id_phieu_xuat_moc_cu != null && $id_phieu_xuat_moc_moi != 0 && $id_phieu_xuat_moc_cu != $id_phieu_xuat_moc_moi)    // Lúc đầu cây mộc nằm trong phiếu xuất mộc này nhưng lúc sau cây mộc lại nằm trong phiếu xuất mộc khác
        {
            $sql_1 = 'UPDATE phieu_xuat_moc
                      SET tong_so_cay_moc = tong_so_cay_moc - 1,
                          tong_so_met = tong_so_met - '.$so_met_cu.'
                      WHERE da_xoa = 0 AND id = '.$id_phieu_xuat_moc_cu;

            $sql_2 = 'UPDATE phieu_xuat_moc
                      SET tong_so_cay_moc = tong_so_cay_moc + 1,
                          tong_so_met = tong_so_met + '.$so_met_moi.'
                      WHERE da_xoa = 0 AND id = '.$id_phieu_xuat_moc_moi;

            return DB::transaction(function() use ($sql_1, $sql_2) {
                DB::update($sql_1);
                DB::update($sql_2);
            });
        }
    }
}