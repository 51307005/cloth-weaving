<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HelperController;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Repositories\KhoRepository;
use App\Http\Repositories\LoaiVaiRepository;
use App\Http\Repositories\MocRepository;

class KhoMocController extends HelperController
{
    public function getKhoMoc()
    {
        if (Session::has('username') && Session::has('quyen'))  // Đã Login
        {
            // Lấy danh sách chức năng tương ứng với quyền của user
            $list_chuc_nang = $this->taoLinkChoListChucNang(Session::get('quyen'));

            // Redirect tới view mà tương ứng với quyền của user
            switch (Session::get('quyen'))
            {
                case self::QUYEN_ADMIN:
                    //return view('manager')->with('list_chuc_nang', $list_chuc_nang);
                case self::QUYEN_SAN_XUAT:
                    //return view('san_xuat')->with('list_chuc_nang', $list_chuc_nang);
                case self::QUYEN_KHO:
                    // Lấy danh sách kho mộc
                    $khoRepository = new KhoRepository();
                    $list_kho_moc = $khoRepository->getDanhSachKhoMoc();

                    return view('kho_moc')->with('list_chuc_nang', $list_chuc_nang)
                                          ->with('list_kho_moc', $list_kho_moc);
                case self::QUYEN_BAN_HANG:
                    //return view('ban_hang')->with('list_chuc_nang', $list_chuc_nang);
            }
        }

        // Chưa Login
        return view('login_he_thong');
    }

    public function postKhoMoc(Request $request)
    {
        // Lấy danh sách chức năng tương ứng với quyền của user
        $list_chuc_nang = $this->taoLinkChoListChucNang(Session::get('quyen'));

        // Lấy danh sách kho mộc
        $khoRepository = new KhoRepository();
        $list_kho_moc = $khoRepository->getDanhSachKhoMoc();

        // Lấy danh sách loại vải
        $loaiVaiRepository = new LoaiVaiRepository();
        $list_loai_vai = $loaiVaiRepository->getDanhSachLoaiVai();

        // Id kho mộc mà user đã chọn
        $id_kho_moc = (int)($request->get('id_kho_moc'));

        // Lấy kho mộc mà user đã chọn
        $kho_moc_duoc_chon = $khoRepository->getKhoMocById($id_kho_moc);

        // Thiết lập việc có show button Xóa hay không
        $showButtonXoa = false;
        if (Session::get('quyen') == self::QUYEN_ADMIN)
        {
            $showButtonXoa = true;
        }

        // Tạo đối tượng MocRepository
        $mocRepository = new MocRepository();

        // Button "Xóa" được click
        if ($request->get('xoa') == 'true')
        {
            $list_id_cay_moc_muon_xoa = $request->get('list_id_cay_moc_muon_xoa');
            $mocRepository->deleteCacCayMoc($list_id_cay_moc_muon_xoa);
        }

        // Button "Xem" / "Xem tất cả cây mộc" / "Lọc" được click
        if ($request->get('loc_theo_loai_vai') == 'false' && $request->get('xem_tat_ca_cay_moc') == 'false')    // Button "Xem" được click
        {
            // Đếm tổng số cây mộc tồn kho, trong kho mộc mà user đã chọn
            $tong_so_cay_moc_ton_kho = $mocRepository->demTongSoCayMocTonKho($id_kho_moc);

            // Lấy số cây mộc tồn kho theo loại vải, trong kho mộc mà user đã chọn
            $soCayMocTheoLoaiVai = $mocRepository->getSoCayMocTonKhoTheoLoaiVai($id_kho_moc);
            // Lấy các loại vải có trong kho mộc mà user đã chọn, nhưng không còn cây mộc tồn kho nào
            $cacLoaiVaiKhongConCayMocTonKhoTrongKhoMoc = $mocRepository->getCacLoaiVaiKhongConCayMocTonKhoTrongKhoMoc($id_kho_moc);
            if (count($cacLoaiVaiKhongConCayMocTonKhoTrongKhoMoc) != 0)     // Lấy được các loại vải có trong kho mộc mà user đã chọn, nhưng không còn cây mộc tồn kho nào
            {
                // Thiết lập số cây mộc cho mỗi loại vải trong $cacLoaiVaiKhongConCayMocTonKhoTrongKhoMoc và nhập $cacLoaiVaiKhongConCayMocTonKhoTrongKhoMoc vào $soCayMocTheoLoaiVai
                foreach ($cacLoaiVaiKhongConCayMocTonKhoTrongKhoMoc as $loai_vai)
                {
                    $loai_vai->so_cay_moc = 0;
                    $soCayMocTheoLoaiVai[] = $loai_vai;
                }
            }

            // Lấy danh sách cây mộc tồn kho, trong kho mộc mà user đã chọn
            $list_cay_moc = $mocRepository->getDanhSachCayMocTonKho($id_kho_moc);
            // Format lại cho "ngay_gio_det" và "ngay_gio_nhap_kho"
            foreach ($list_cay_moc as $cay_moc)
            {
                $cay_moc->ngay_gio_det = date('d/m/Y H:i:s', strtotime($cay_moc->ngay_gio_det));
                $cay_moc->ngay_gio_nhap_kho = date('d/m/Y H:i:s', strtotime($cay_moc->ngay_gio_nhap_kho));
            }

            return view('kho_moc')->with('list_chuc_nang', $list_chuc_nang)
                                  ->with('list_kho_moc', $list_kho_moc)
                                  ->with('list_loai_vai', $list_loai_vai)
                                  ->with('kho_moc_duoc_chon', $kho_moc_duoc_chon)
                                  ->with('showButtonXoa', $showButtonXoa)
                                  ->with('tong_so_cay_moc_ton_kho', $tong_so_cay_moc_ton_kho)
                                  ->with('soCayMocTheoLoaiVai', $soCayMocTheoLoaiVai)
                                  ->with('list_cay_moc', $list_cay_moc);
        }
        else if ($request->get('loc_theo_loai_vai') == 'false' && $request->get('xem_tat_ca_cay_moc') == 'true')    // Button "Xem tất cả cây mộc" được click
        {
            // Đếm tổng số cây mộc, trong kho mộc mà user đã chọn
            $tong_so_cay_moc = $mocRepository->demTongSoCayMoc($id_kho_moc);

            // Lấy số cây mộc theo loại vải, trong kho mộc mà user đã chọn
            $soCayMocTheoLoaiVai = $mocRepository->getSoCayMocTheoLoaiVai($id_kho_moc);

            // Lấy danh sách cây mộc, trong kho mộc mà user đã chọn
            $list_cay_moc = $mocRepository->getDanhSachCayMoc($id_kho_moc);
            // Format lại cho "ngay_gio_det" và "ngay_gio_nhap_kho"
            foreach ($list_cay_moc as $cay_moc)
            {
                $cay_moc->ngay_gio_det = date('d/m/Y H:i:s', strtotime($cay_moc->ngay_gio_det));
                $cay_moc->ngay_gio_nhap_kho = date('d/m/Y H:i:s', strtotime($cay_moc->ngay_gio_nhap_kho));
            }

            return view('kho_moc')->with('list_chuc_nang', $list_chuc_nang)
                                  ->with('list_kho_moc', $list_kho_moc)
                                  ->with('list_loai_vai', $list_loai_vai)
                                  ->with('kho_moc_duoc_chon', $kho_moc_duoc_chon)
                                  ->with('showButtonXoa', $showButtonXoa)
                                  ->with('tong_so_cay_moc', $tong_so_cay_moc)
                                  ->with('soCayMocTheoLoaiVai', $soCayMocTheoLoaiVai)
                                  ->with('list_cay_moc', $list_cay_moc);
        }
        else if ($request->get('loc_theo_loai_vai') == 'true' && $request->get('xem_tat_ca_cay_moc') == 'false')    // Button "Lọc" được click
        {
            // Id loại vải mà user đã chọn
            $id_loai_vai = (int)($request->get('id_loai_vai'));

            // Lấy loại vải mà user đã chọn
            $loai_vai_duoc_chon = $loaiVaiRepository->getLoaiVaiById($id_loai_vai);

            // Đếm tổng số cây mộc tồn kho, theo loại vải và trong kho mộc mà user đã chọn
            $tong_so_cay_moc_ton_kho = $mocRepository->demTongSoCayMocTonKho($id_kho_moc, $id_loai_vai);

            if ($tong_so_cay_moc_ton_kho != 0)  // Loại vải mà user đã chọn có trong kho mà user đã chọn, và còn cây mộc tồn kho
            {
                // Lấy danh sách cây mộc tồn kho, theo loại vải và trong kho mộc mà user đã chọn
                $list_cay_moc = $mocRepository->getDanhSachCayMocTonKho($id_kho_moc, $id_loai_vai);
                // Format lại cho "ngay_gio_det" và "ngay_gio_nhap_kho"
                foreach ($list_cay_moc as $cay_moc)
                {
                    $cay_moc->ngay_gio_det = date('d/m/Y H:i:s', strtotime($cay_moc->ngay_gio_det));
                    $cay_moc->ngay_gio_nhap_kho = date('d/m/Y H:i:s', strtotime($cay_moc->ngay_gio_nhap_kho));
                }

                return view('kho_moc')->with('list_chuc_nang', $list_chuc_nang)
                                      ->with('list_kho_moc', $list_kho_moc)
                                      ->with('list_loai_vai', $list_loai_vai)
                                      ->with('kho_moc_duoc_chon', $kho_moc_duoc_chon)
                                      ->with('showButtonXoa', $showButtonXoa)
                                      ->with('tong_so_cay_moc_ton_kho', $tong_so_cay_moc_ton_kho)
                                      ->with('list_cay_moc', $list_cay_moc)
                                      ->with('loai_vai_duoc_chon', $loai_vai_duoc_chon);
            }
            else    // Loại vải mà user đã chọn không có trong kho mà user đã chọn, hoặc có trong kho mà user đã chọn nhưng không còn cây mộc tồn kho nào
            {
                $message = 'Loại vải '.$loai_vai_duoc_chon->ten.' không có trong '.$kho_moc_duoc_chon->ten.' hoặc loại vải này không còn cây mộc tồn kho nào !';

                return view('kho_moc')->with('list_chuc_nang', $list_chuc_nang)
                                      ->with('list_kho_moc', $list_kho_moc)
                                      ->with('list_loai_vai', $list_loai_vai)
                                      ->with('kho_moc_duoc_chon', $kho_moc_duoc_chon)
                                      ->with('message', $message)
                                      ->with('list_cay_moc', '')
                                      ->with('loai_vai_duoc_chon', $loai_vai_duoc_chon);
            }
        }
    }

    public function getNhapMoc()
    {
        
    }

    public function postNhapMoc(Request $request)   // Xài Request chung
    {
        
    }

    public function getCapNhatCayMocKhongId()
    {
        
    }

    public function getCapNhatCayMocCoId($id_cay_moc)
    {
        
    }

    public function postCapNhatCayMoc(Request $request) // Có thể xài Request riêng do ta tự tạo ra cho phù hợp với Form Cập nhật cây mộc
    {
        
    }
}
