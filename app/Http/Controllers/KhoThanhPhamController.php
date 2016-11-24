<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HelperController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\ThemHoaDonXuatRequest;
use App\Http\Repositories\KhoRepository;
use App\Http\Repositories\MocRepository;
use App\Http\Repositories\ThanhPhamRepository;
use App\Http\Repositories\LoaiVaiRepository;
use App\Http\Repositories\NhanVienRepository;
use App\Http\Repositories\HoaDonXuatRepository;
use App\Http\Repositories\LoNhuomRepository;
use App\Http\Repositories\MauRepository;
use App\Http\Repositories\KhachHangRepository;
use App\Http\Repositories\DonHangKhachHangRepository;
use App\Http\Repositories\ThuChiRepository;

class KhoThanhPhamController extends HelperController
{
    public function getKhoThanhPham(Request $request)
    {
        // Check Login
        if (Session::has('username') && Session::has('quyen'))  // Đã Login
        {
            // Redirect tới view mà tương ứng với quyền của user
            switch (Session::get('quyen'))
            {
                case self::QUYEN_SAN_XUAT:
                    return redirect()->to(route('route_get_trang_chu_san_xuat'));
                case self::QUYEN_BAN_HANG:
                    return redirect()->to(route('route_get_trang_chu_ban_hang'));
                case self::QUYEN_ADMIN:
                case self::QUYEN_KHO:
                    // Xử lý cho trường hợp phân trang
                    if ($request->has('page'))  // Có biến page trên URL
                    {
                        // Tạo đối tượng ThanhPhamRepository
                        $thanhPhamRepository = new ThanhPhamRepository();

                        if (Session::has('truong_hop_button_xem_kho_thanh_pham'))   // Trường hợp: đã click trên chuỗi button phân trang, của button "Xem"
                        {
                            // Lấy danh sách cây thành phẩm tồn kho, trong kho thành phẩm mà user đã chọn
                            $list_cay_thanh_pham = $thanhPhamRepository->getDanhSachCayThanhPhamTonKho(Session::get('kho_thanh_pham_duoc_chon')->id);
                            // Format lại cho "ngay_gio_nhap_kho"
                            foreach ($list_cay_thanh_pham as $cay_thanh_pham)
                            {
                                $cay_thanh_pham->ngay_gio_nhap_kho = date('d/m/Y H:i:s', strtotime($cay_thanh_pham->ngay_gio_nhap_kho));
                            }

                            return view('kho_thanh_pham')->with('list_chuc_nang', Session::get('list_chuc_nang_kho'))
                                                         ->with('list_kho_thanh_pham', Session::get('list_kho_thanh_pham'))
                                                         ->with('list_loai_vai', Session::get('list_loai_vai'))
                                                         ->with('list_mau', Session::get('list_mau'))
                                                         ->with('list_kho', Session::get('list_kho'))
                                                         ->with('kho_thanh_pham_duoc_chon', Session::get('kho_thanh_pham_duoc_chon'))
                                                         ->with('showButtonXoa', Session::get('showButtonXoa'))
                                                         ->with('tong_so_cay_thanh_pham_ton_kho', Session::get('tong_so_cay_thanh_pham_ton_kho'))
                                                         ->with('soCayThanhPhamTheoLoaiVai', Session::get('soCayThanhPhamTheoLoaiVai'))
                                                         ->with('list_cay_thanh_pham', $list_cay_thanh_pham);
                        }
                        else if (Session::has('truong_hop_button_xem_tat_ca_cay_thanh_pham'))   // Trường hợp: đã click trên chuỗi button phân trang, của button "Xem tất cả cây thành phẩm"
                        {
                            // Lấy danh sách cây thành phẩm, trong kho thành phẩm mà user đã chọn
                            $list_cay_thanh_pham = $thanhPhamRepository->getDanhSachCayThanhPham(Session::get('kho_thanh_pham_duoc_chon')->id);
                            // Format lại cho "ngay_gio_nhap_kho"
                            foreach ($list_cay_thanh_pham as $cay_thanh_pham)
                            {
                                $cay_thanh_pham->ngay_gio_nhap_kho = date('d/m/Y H:i:s', strtotime($cay_thanh_pham->ngay_gio_nhap_kho));
                            }

                            return view('kho_thanh_pham')->with('list_chuc_nang', Session::get('list_chuc_nang_kho'))
                                                         ->with('list_kho_thanh_pham', Session::get('list_kho_thanh_pham'))
                                                         ->with('list_loai_vai', Session::get('list_loai_vai'))
                                                         ->with('list_mau', Session::get('list_mau'))
                                                         ->with('list_kho', Session::get('list_kho'))
                                                         ->with('kho_thanh_pham_duoc_chon', Session::get('kho_thanh_pham_duoc_chon'))
                                                         ->with('showButtonXoa', Session::get('showButtonXoa'))
                                                         ->with('tong_so_cay_thanh_pham', Session::get('tong_so_cay_thanh_pham'))
                                                         ->with('soCayThanhPhamTheoLoaiVai', Session::get('soCayThanhPhamTheoLoaiVai'))
                                                         ->with('list_cay_thanh_pham', $list_cay_thanh_pham);
                        }
                        else if (Session::has('truong_hop_button_loc_kho_thanh_pham'))  // Trường hợp: đã click trên chuỗi button phân trang, của button "Lọc"
                        {
                            // Lấy danh sách cây thành phẩm tồn kho, theo loại vải, màu, khổ và trong kho thành phẩm mà user đã chọn
                            $list_cay_thanh_pham = $thanhPhamRepository->getDanhSachCayThanhPhamTonKho(Session::get('kho_thanh_pham_duoc_chon')->id, Session::get('loai_vai_duoc_chon_kho_thanh_pham')->id, Session::get('mau_duoc_chon')->id, Session::get('kho_duoc_chon'));
                            // Format lại cho "ngay_gio_nhap_kho"
                            foreach ($list_cay_thanh_pham as $cay_thanh_pham)
                            {
                                $cay_thanh_pham->ngay_gio_nhap_kho = date('d/m/Y H:i:s', strtotime($cay_thanh_pham->ngay_gio_nhap_kho));
                            }

                            return view('kho_thanh_pham')->with('list_chuc_nang', Session::get('list_chuc_nang_kho'))
                                                         ->with('list_kho_thanh_pham', Session::get('list_kho_thanh_pham'))
                                                         ->with('list_loai_vai', Session::get('list_loai_vai'))
                                                         ->with('list_mau', Session::get('list_mau'))
                                                         ->with('list_kho', Session::get('list_kho'))
                                                         ->with('kho_thanh_pham_duoc_chon', Session::get('kho_thanh_pham_duoc_chon'))
                                                         ->with('showButtonXoa', Session::get('showButtonXoa'))
                                                         ->with('loai_vai_duoc_chon', Session::get('loai_vai_duoc_chon_kho_thanh_pham'))
                                                         ->with('mau_duoc_chon', Session::get('mau_duoc_chon'))
                                                         ->with('kho_duoc_chon', Session::get('kho_duoc_chon'))
                                                         ->with('tong_so_cay_thanh_pham_ton_kho', Session::get('tong_so_cay_thanh_pham_ton_kho'))
                                                         ->with('list_cay_thanh_pham', $list_cay_thanh_pham);
                        }
                        else    // Trường hợp: biến page trên URL do user tự nhập tay vào
                        {
                            return redirect()->to(route('route_get_kho_thanh_pham'));
                        }
                    }
                    else    // Không có biến page trên URL hoặc không click trên chuỗi button phân trang
                    {
                        // Lấy danh sách chức năng tương ứng với quyền của user
                        $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_KHO);

                        // Lấy danh sách kho thành phẩm
                        $khoRepository = new KhoRepository();
                        $list_kho_thanh_pham = $khoRepository->getDanhSachKhoThanhPham();

                        return view('kho_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                                     ->with('list_kho_thanh_pham', $list_kho_thanh_pham);
                    }
            }
        }

        // Chưa Login
        return redirect()->to(route('route_get_login_he_thong'));
    }

    public function postKhoThanhPham(Request $request)
    {
        // Lấy danh sách chức năng tương ứng với quyền của user
        $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_KHO);

        // Lấy danh sách kho thành phẩm
        $khoRepository = new KhoRepository();
        $list_kho_thanh_pham = $khoRepository->getDanhSachKhoThanhPham();

        // Lấy danh sách loại vải
        $loaiVaiRepository = new LoaiVaiRepository();
        $list_loai_vai = $loaiVaiRepository->getDanhSachLoaiVai();

        // Lấy danh sách màu
        $mauRepository = new MauRepository();
        $list_mau = $mauRepository->getDanhSachMau();

        // Lấy danh sách khổ
        $list_kho = $this->kho;

        // Id kho thành phẩm mà user đã chọn
        $id_kho_thanh_pham = (int)($request->get('id_kho_thanh_pham'));

        // Lấy kho thành phẩm mà user đã chọn
        $kho_thanh_pham_duoc_chon = $khoRepository->getKhoThanhPhamById($id_kho_thanh_pham);

        // Thiết lập việc có show button Xóa hay không
        $showButtonXoa = false;
        if (Session::get('quyen') == self::QUYEN_ADMIN)
        {
            $showButtonXoa = true;
        }

        // Tạo đối tượng ThanhPhamRepository
        $thanhPhamRepository = new ThanhPhamRepository();

        // Button "Xóa" được click
        if ($request->get('xoa') == 'true')
        {
            // Lấy danh sách id cây thành phẩm muốn xóa
            $list_id_cay_thanh_pham_muon_xoa = $request->get('list_id_cay_thanh_pham_muon_xoa');
            // Xóa các cây thành phẩm
            $thanhPhamRepository->deleteCacCayThanhPham($list_id_cay_thanh_pham_muon_xoa);
        }

        // Button "Xem" / "Xem tất cả cây thành phẩm" / "Lọc" được click
        if ($request->get('loc') == 'false' && $request->get('xem_tat_ca_cay_thanh_pham') == 'false')   // Button "Xem" được click
        {
            // Đếm tổng số cây thành phẩm tồn kho, trong kho thành phẩm mà user đã chọn
            $tong_so_cay_thanh_pham_ton_kho = $thanhPhamRepository->demTongSoCayThanhPhamTonKho($id_kho_thanh_pham);

            if ($tong_so_cay_thanh_pham_ton_kho == 0)
            {
                // Xóa tất cả các Session do trường hợp button "Xem tất cả cây thành phẩm" hoặc button "Lọc" thiết lập ra
                Session::forget('list_chuc_nang_kho');
                Session::forget('list_kho_thanh_pham');
                Session::forget('list_loai_vai');
                Session::forget('list_mau');
                Session::forget('list_kho');
                Session::forget('kho_thanh_pham_duoc_chon');
                Session::forget('showButtonXoa');
                Session::forget('tong_so_cay_thanh_pham');
                Session::forget('soCayThanhPhamTheoLoaiVai');
                Session::forget('truong_hop_button_xem_tat_ca_cay_thanh_pham');
                Session::forget('loai_vai_duoc_chon_kho_thanh_pham');
                Session::forget('mau_duoc_chon');
                Session::forget('kho_duoc_chon');
                Session::forget('tong_so_cay_thanh_pham_ton_kho');
                Session::forget('truong_hop_button_loc_kho_thanh_pham');
                Session::forget('truong_hop_button_xem_kho_thanh_pham');

                $message = $kho_thanh_pham_duoc_chon->ten.' không có cây vải thành phẩm tồn kho nào !';

                return view('kho_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                             ->with('list_kho_thanh_pham', $list_kho_thanh_pham)
                                             ->with('list_loai_vai', $list_loai_vai)
                                             ->with('list_mau', $list_mau)
                                             ->with('list_kho', $list_kho)
                                             ->with('kho_thanh_pham_duoc_chon', $kho_thanh_pham_duoc_chon)
                                             ->with('message', $message)
                                             ->with('list_cay_thanh_pham', '');
            }

            // Lấy số cây thành phẩm tồn kho theo loại vải, trong kho thành phẩm mà user đã chọn
            $soCayThanhPhamTheoLoaiVai = $thanhPhamRepository->getSoCayThanhPhamTonKhoTheoLoaiVai($id_kho_thanh_pham);
            // Lấy các loại vải có trong kho thành phẩm mà user đã chọn, nhưng không còn cây thành phẩm tồn kho nào
            $cacLoaiVaiKhongConCayThanhPhamTonKhoTrongKhoThanhPham = $thanhPhamRepository->getCacLoaiVaiKhongConCayThanhPhamTonKhoTrongKhoThanhPham($id_kho_thanh_pham);
            if (count($cacLoaiVaiKhongConCayThanhPhamTonKhoTrongKhoThanhPham) != 0)     // Lấy được các loại vải có trong kho thành phẩm mà user đã chọn, nhưng không còn cây thành phẩm tồn kho nào
            {
                // Thiết lập số cây thành phẩm cho mỗi loại vải trong $cacLoaiVaiKhongConCayThanhPhamTonKhoTrongKhoThanhPham và nhập $cacLoaiVaiKhongConCayThanhPhamTonKhoTrongKhoThanhPham vào $soCayThanhPhamTheoLoaiVai
                foreach ($cacLoaiVaiKhongConCayThanhPhamTonKhoTrongKhoThanhPham as $loai_vai)
                {
                    $loai_vai->so_cay_thanh_pham = 0;
                    $soCayThanhPhamTheoLoaiVai[] = $loai_vai;
                }
            }

            // Lấy danh sách cây thành phẩm tồn kho, trong kho thành phẩm mà user đã chọn
            $list_cay_thanh_pham = $thanhPhamRepository->getDanhSachCayThanhPhamTonKho($id_kho_thanh_pham);
            // Format lại cho "ngay_gio_nhap_kho"
            foreach ($list_cay_thanh_pham as $cay_thanh_pham)
            {
                $cay_thanh_pham->ngay_gio_nhap_kho = date('d/m/Y H:i:s', strtotime($cay_thanh_pham->ngay_gio_nhap_kho));
            }

            // Xóa tất cả các Session do trường hợp button "Xem tất cả cây thành phẩm" hoặc button "Lọc" thiết lập ra
            Session::forget('list_chuc_nang_kho');
            Session::forget('list_kho_thanh_pham');
            Session::forget('list_loai_vai');
            Session::forget('list_mau');
            Session::forget('list_kho');
            Session::forget('kho_thanh_pham_duoc_chon');
            Session::forget('showButtonXoa');
            Session::forget('tong_so_cay_thanh_pham');
            Session::forget('soCayThanhPhamTheoLoaiVai');
            Session::forget('truong_hop_button_xem_tat_ca_cay_thanh_pham');
            Session::forget('loai_vai_duoc_chon_kho_thanh_pham');
            Session::forget('mau_duoc_chon');
            Session::forget('kho_duoc_chon');
            Session::forget('tong_so_cay_thanh_pham_ton_kho');
            Session::forget('truong_hop_button_loc_kho_thanh_pham');

            // Thiết lập Session để hỗ trợ cho việc phân trang
            Session::put('list_chuc_nang_kho', $list_chuc_nang);
            Session::put('list_kho_thanh_pham', $list_kho_thanh_pham);
            Session::put('list_loai_vai', $list_loai_vai);
            Session::put('list_mau', $list_mau);
            Session::put('list_kho', $list_kho);
            Session::put('kho_thanh_pham_duoc_chon', $kho_thanh_pham_duoc_chon);
            Session::put('showButtonXoa', $showButtonXoa);
            Session::put('tong_so_cay_thanh_pham_ton_kho', $tong_so_cay_thanh_pham_ton_kho);
            Session::put('soCayThanhPhamTheoLoaiVai', $soCayThanhPhamTheoLoaiVai);
            Session::put('truong_hop_button_xem_kho_thanh_pham', 'true');

            return view('kho_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                         ->with('list_kho_thanh_pham', $list_kho_thanh_pham)
                                         ->with('list_loai_vai', $list_loai_vai)
                                         ->with('list_mau', $list_mau)
                                         ->with('list_kho', $list_kho)
                                         ->with('kho_thanh_pham_duoc_chon', $kho_thanh_pham_duoc_chon)
                                         ->with('showButtonXoa', $showButtonXoa)
                                         ->with('tong_so_cay_thanh_pham_ton_kho', $tong_so_cay_thanh_pham_ton_kho)
                                         ->with('soCayThanhPhamTheoLoaiVai', $soCayThanhPhamTheoLoaiVai)
                                         ->with('list_cay_thanh_pham', $list_cay_thanh_pham);
        }
        else if ($request->get('loc') == 'false' && $request->get('xem_tat_ca_cay_thanh_pham') == 'true')   // Button "Xem tất cả cây thành phẩm" được click
        {
            // Đếm tổng số cây thành phẩm, trong kho thành phẩm mà user đã chọn
            $tong_so_cay_thanh_pham = $thanhPhamRepository->demTongSoCayThanhPham($id_kho_thanh_pham);

            // Lấy số cây thành phẩm theo loại vải, trong kho thành phẩm mà user đã chọn
            $soCayThanhPhamTheoLoaiVai = $thanhPhamRepository->getSoCayThanhPhamTheoLoaiVai($id_kho_thanh_pham);

            // Lấy danh sách cây thành phẩm, trong kho thành phẩm mà user đã chọn
            $list_cay_thanh_pham = $thanhPhamRepository->getDanhSachCayThanhPham($id_kho_thanh_pham);
            // Format lại cho "ngay_gio_nhap_kho"
            foreach ($list_cay_thanh_pham as $cay_thanh_pham)
            {
                $cay_thanh_pham->ngay_gio_nhap_kho = date('d/m/Y H:i:s', strtotime($cay_thanh_pham->ngay_gio_nhap_kho));
            }

            // Xóa tất cả các Session do trường hợp button "Xem" hoặc button "Lọc" thiết lập ra
            Session::forget('list_chuc_nang_kho');
            Session::forget('list_kho_thanh_pham');
            Session::forget('list_loai_vai');
            Session::forget('list_mau');
            Session::forget('list_kho');
            Session::forget('kho_thanh_pham_duoc_chon');
            Session::forget('showButtonXoa');
            Session::forget('tong_so_cay_thanh_pham_ton_kho');
            Session::forget('soCayThanhPhamTheoLoaiVai');
            Session::forget('truong_hop_button_xem_kho_thanh_pham');
            Session::forget('loai_vai_duoc_chon_kho_thanh_pham');
            Session::forget('mau_duoc_chon');
            Session::forget('kho_duoc_chon');
            Session::forget('truong_hop_button_loc_kho_thanh_pham');

            // Thiết lập Session để hỗ trợ cho việc phân trang
            Session::put('list_chuc_nang_kho', $list_chuc_nang);
            Session::put('list_kho_thanh_pham', $list_kho_thanh_pham);
            Session::put('list_loai_vai', $list_loai_vai);
            Session::put('list_mau', $list_mau);
            Session::put('list_kho', $list_kho);
            Session::put('kho_thanh_pham_duoc_chon', $kho_thanh_pham_duoc_chon);
            Session::put('showButtonXoa', $showButtonXoa);
            Session::put('tong_so_cay_thanh_pham', $tong_so_cay_thanh_pham);
            Session::put('soCayThanhPhamTheoLoaiVai', $soCayThanhPhamTheoLoaiVai);
            Session::put('truong_hop_button_xem_tat_ca_cay_thanh_pham', 'true');

            return view('kho_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                         ->with('list_kho_thanh_pham', $list_kho_thanh_pham)
                                         ->with('list_loai_vai', $list_loai_vai)
                                         ->with('list_mau', $list_mau)
                                         ->with('list_kho', $list_kho)
                                         ->with('kho_thanh_pham_duoc_chon', $kho_thanh_pham_duoc_chon)
                                         ->with('showButtonXoa', $showButtonXoa)
                                         ->with('tong_so_cay_thanh_pham', $tong_so_cay_thanh_pham)
                                         ->with('soCayThanhPhamTheoLoaiVai', $soCayThanhPhamTheoLoaiVai)
                                         ->with('list_cay_thanh_pham', $list_cay_thanh_pham);
        }
        else if ($request->get('loc') == 'true' && $request->get('xem_tat_ca_cay_thanh_pham') == 'false')   // Button "Lọc" được click
        {
            // Id loại vải, Id màu, Khổ mà user đã chọn
            $id_loai_vai = (int)($request->get('id_loai_vai'));
            $id_mau = (int)($request->get('id_mau'));
            $kho_duoc_chon = (float)($request->get('kho'));

            // Lấy loại vải mà user đã chọn
            $loai_vai_duoc_chon = $loaiVaiRepository->getLoaiVaiById($id_loai_vai);

            // Lấy màu mà user đã chọn
            $mau_duoc_chon = $mauRepository->getMauById($id_mau);

            // Đếm tổng số cây thành phẩm tồn kho, theo loại vải, màu, khổ và trong kho thành phẩm mà user đã chọn
            $tong_so_cay_thanh_pham_ton_kho = $thanhPhamRepository->demTongSoCayThanhPhamTonKho($id_kho_thanh_pham, $id_loai_vai, $id_mau, $kho_duoc_chon);

            if ($tong_so_cay_thanh_pham_ton_kho != 0)   // Loại vải, Màu, Khổ mà user đã chọn có trong kho mà user đã chọn, và còn cây thành phẩm tồn kho
            {
                // Lấy danh sách cây thành phẩm tồn kho, theo loại vải, màu, khổ và trong kho thành phẩm mà user đã chọn
                $list_cay_thanh_pham = $thanhPhamRepository->getDanhSachCayThanhPhamTonKho($id_kho_thanh_pham, $id_loai_vai, $id_mau, $kho_duoc_chon);
                // Format lại cho "ngay_gio_nhap_kho"
                foreach ($list_cay_thanh_pham as $cay_thanh_pham)
                {
                    $cay_thanh_pham->ngay_gio_nhap_kho = date('d/m/Y H:i:s', strtotime($cay_thanh_pham->ngay_gio_nhap_kho));
                }

                // Xóa tất cả các Session do trường hợp button "Xem" hoặc button "Xem tất cả cây thành phẩm" thiết lập ra
                Session::forget('list_chuc_nang_kho');
                Session::forget('list_kho_thanh_pham');
                Session::forget('list_loai_vai');
                Session::forget('list_mau');
                Session::forget('list_kho');
                Session::forget('kho_thanh_pham_duoc_chon');
                Session::forget('showButtonXoa');
                Session::forget('tong_so_cay_thanh_pham_ton_kho');
                Session::forget('soCayThanhPhamTheoLoaiVai');
                Session::forget('truong_hop_button_xem_kho_thanh_pham');
                Session::forget('tong_so_cay_thanh_pham');
                Session::forget('truong_hop_button_xem_tat_ca_cay_thanh_pham');

                // Thiết lập Session để hỗ trợ cho việc phân trang
                Session::put('list_chuc_nang_kho', $list_chuc_nang);
                Session::put('list_kho_thanh_pham', $list_kho_thanh_pham);
                Session::put('list_loai_vai', $list_loai_vai);
                Session::put('list_mau', $list_mau);
                Session::put('list_kho', $list_kho);
                Session::put('kho_thanh_pham_duoc_chon', $kho_thanh_pham_duoc_chon);
                Session::put('showButtonXoa', $showButtonXoa);
                Session::put('loai_vai_duoc_chon_kho_thanh_pham', $loai_vai_duoc_chon);
                Session::put('mau_duoc_chon', $mau_duoc_chon);
                Session::put('kho_duoc_chon', $kho_duoc_chon);
                Session::put('tong_so_cay_thanh_pham_ton_kho', $tong_so_cay_thanh_pham_ton_kho);
                Session::put('truong_hop_button_loc_kho_thanh_pham', 'true');

                return view('kho_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                             ->with('list_kho_thanh_pham', $list_kho_thanh_pham)
                                             ->with('list_loai_vai', $list_loai_vai)
                                             ->with('list_mau', $list_mau)
                                             ->with('list_kho', $list_kho)
                                             ->with('kho_thanh_pham_duoc_chon', $kho_thanh_pham_duoc_chon)
                                             ->with('showButtonXoa', $showButtonXoa)
                                             ->with('loai_vai_duoc_chon', $loai_vai_duoc_chon)
                                             ->with('mau_duoc_chon', $mau_duoc_chon)
                                             ->with('kho_duoc_chon', $kho_duoc_chon)
                                             ->with('tong_so_cay_thanh_pham_ton_kho', $tong_so_cay_thanh_pham_ton_kho)
                                             ->with('list_cay_thanh_pham', $list_cay_thanh_pham);
            }
            else    // Loại vải, Màu, Khổ mà user đã chọn không có trong kho mà user đã chọn, hoặc có trong kho mà user đã chọn nhưng không còn cây thành phẩm tồn kho nào
            {
                // Xóa tất cả các Session do trường hợp button "Xem" hoặc button "Xem tất cả cây thành phẩm" thiết lập ra
                Session::forget('list_chuc_nang_kho');
                Session::forget('list_kho_thanh_pham');
                Session::forget('list_loai_vai');
                Session::forget('list_mau');
                Session::forget('list_kho');
                Session::forget('kho_thanh_pham_duoc_chon');
                Session::forget('showButtonXoa');
                Session::forget('tong_so_cay_thanh_pham_ton_kho');
                Session::forget('soCayThanhPhamTheoLoaiVai');
                Session::forget('truong_hop_button_xem_kho_thanh_pham');
                Session::forget('tong_so_cay_thanh_pham');
                Session::forget('truong_hop_button_xem_tat_ca_cay_thanh_pham');
                Session::forget('loai_vai_duoc_chon_kho_thanh_pham');
                Session::forget('mau_duoc_chon');
                Session::forget('kho_duoc_chon');
                Session::forget('truong_hop_button_loc_kho_thanh_pham');

                $message = 'Loại vải '.$loai_vai_duoc_chon->ten.' màu '.$mau_duoc_chon->ten.' khổ '.number_format($kho_duoc_chon, 1, ',', '.').' m không có trong '.$kho_thanh_pham_duoc_chon->ten.' hoặc có nhưng không còn cây thành phẩm tồn kho nào !';

                return view('kho_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                             ->with('list_kho_thanh_pham', $list_kho_thanh_pham)
                                             ->with('list_loai_vai', $list_loai_vai)
                                             ->with('list_mau', $list_mau)
                                             ->with('list_kho', $list_kho)
                                             ->with('kho_thanh_pham_duoc_chon', $kho_thanh_pham_duoc_chon)
                                             ->with('loai_vai_duoc_chon', $loai_vai_duoc_chon)
                                             ->with('mau_duoc_chon', $mau_duoc_chon)
                                             ->with('kho_duoc_chon', $kho_duoc_chon)
                                             ->with('message', $message)
                                             ->with('list_cay_thanh_pham', '');
            }
        }
    }

    public function getNhapVaiThanhPham()
    {
        // Check Login
        if (Session::has('username') && Session::has('quyen'))  // Đã Login
        {
            // Redirect tới view mà tương ứng với quyền của user
            switch (Session::get('quyen'))
            {
                case self::QUYEN_SAN_XUAT:
                    return redirect()->to(route('route_get_trang_chu_san_xuat'));
                case self::QUYEN_BAN_HANG:
                    return redirect()->to(route('route_get_trang_chu_ban_hang'));
                case self::QUYEN_ADMIN:
                case self::QUYEN_KHO:
                    // Lấy danh sách chức năng tương ứng với quyền của user
                    $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_KHO);

                    // Lấy danh sách id lô nhuộm
                    $loNhuomRepository = new LoNhuomRepository();
                    $list_id_lo_nhuom = $loNhuomRepository->getDanhSachIdLoNhuom();

                    // Lấy lô nhuộm đầu tiên trong database
                    $lo_nhuom_dau_tien = $loNhuomRepository->getLoNhuomById($list_id_lo_nhuom[0]->id);

                    // Lấy danh sách kho thành phẩm
                    $khoRepository = new KhoRepository();
                    $list_kho_thanh_pham = $khoRepository->getDanhSachKhoThanhPham();

                    // Lấy "id cây thành phẩm cuối cùng" trong database
                    $thanhPhamRepository = new ThanhPhamRepository();
                    $id_cay_thanh_pham_cuoi_cung = $thanhPhamRepository->getIdCayThanhPhamCuoiCung();

                    // Lấy danh sách id cây mộc mà dành cho việc Nhập/Cập nhật cây thành phẩm
                    $mocRepository = new MocRepository();
                    $list_id_cay_moc = $mocRepository->getDanhSachIdCayMocChoViecNhap_CapNhatCayThanhPham();

                    // Lấy danh sách khổ
                    $list_kho = $this->kho;

                    return view('nhap_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                                  ->with('list_id_lo_nhuom', $list_id_lo_nhuom)
                                                  ->with('lo_nhuom_dau_tien', $lo_nhuom_dau_tien)
                                                  ->with('list_kho_thanh_pham', $list_kho_thanh_pham)
                                                  ->with('id_cay_thanh_pham_cuoi_cung', $id_cay_thanh_pham_cuoi_cung)
                                                  ->with('list_id_cay_moc', $list_id_cay_moc)
                                                  ->with('list_kho', $list_kho);
            }
        }

        // Chưa Login
        return redirect()->to(route('route_get_login_he_thong'));
    }

    public function postNhapVaiThanhPham(Request $request)
    {
        // Nhập vải thành phẩm
        $thanhPhamRepository = new ThanhPhamRepository();
        $thanhPhamRepository->nhapThanhPham($request);
        $mocRepository = new MocRepository();
        $mocRepository->nhapThanhPham($request);
        //echo "<script> alert('Nhập vải thành phẩm thành công !'); </script>";

        // Redirect về trang Nhập vải thành phẩm
        return redirect()->to(route('route_get_nhap_vai_thanh_pham'));
    }

    public function getCapNhatCayVaiThanhPham($id_cay_thanh_pham = null)
    {
        // Check Login
        if (Session::has('username') && Session::has('quyen'))  // Đã Login
        {
            // Redirect tới view mà tương ứng với quyền của user
            switch (Session::get('quyen'))
            {
                case self::QUYEN_SAN_XUAT:
                    return redirect()->to(route('route_get_trang_chu_san_xuat'));
                case self::QUYEN_BAN_HANG:
                    return redirect()->to(route('route_get_trang_chu_ban_hang'));
                case self::QUYEN_ADMIN:
                case self::QUYEN_KHO:
                    // Lấy danh sách chức năng tương ứng với quyền của user
                    $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_KHO);

                    // Tạo đối tượng ThanhPhamRepository
                    $thanhPhamRepository = new ThanhPhamRepository();

                    // Lấy danh sách id cây thành phẩm
                    $list_id_cay_thanh_pham = $thanhPhamRepository->getDanhSachIdCayThanhPham();

                    if ($id_cay_thanh_pham == null)     // $id_cay_thanh_pham không được truyền
                    {
                        return view('cap_nhat_cay_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                                              ->with('list_id_cay_thanh_pham', $list_id_cay_thanh_pham);
                    }
                    else    // $id_cay_thanh_pham được truyền
                    {
                        $errorMessage = '';

                        if (ctype_digit($id_cay_thanh_pham) == true && (int)($id_cay_thanh_pham) > 0)   // $id_cay_thanh_pham là số nguyên dương
                        {
                            $hopLe = false;

                            // Ép kiểu $id_cay_thanh_pham về kiểu int
                            $id_cay_thanh_pham = (int)$id_cay_thanh_pham;

                            // Kiểm tra xem $id_cay_thanh_pham có tồn tại trong database hay không
                            foreach ($list_id_cay_thanh_pham as $cay_thanh_pham)
                            {
                                if ($id_cay_thanh_pham == $cay_thanh_pham->id)
                                {
                                    $hopLe = true;
                                    break;
                                }
                            }

                            if ($hopLe == true)
                            {
                                // Lấy cây thành phẩm mà user đã chọn
                                $cay_thanh_pham_duoc_chon = $thanhPhamRepository->getCayThanhPhamById($id_cay_thanh_pham);
                                $cay_thanh_pham_duoc_chon_json = json_encode($cay_thanh_pham_duoc_chon);

                                // Lấy danh sách id cây mộc mà dành cho việc Nhập/Cập nhật cây thành phẩm
                                $list_id_cay_moc = array();
                                $mocRepository = new MocRepository();
                                $temp = $mocRepository->getDanhSachIdCayMocChoViecNhap_CapNhatCayThanhPham();
                                foreach ($temp as $cay_moc)
                                {
                                    $list_id_cay_moc[] = $cay_moc->id;
                                }
                                $list_id_cay_moc[] = $cay_thanh_pham_duoc_chon->id_cay_vai_moc;
                                $list_id_cay_moc = array_unique($list_id_cay_moc);
                                sort($list_id_cay_moc);

                                // Lấy danh sách khổ
                                $list_kho = $this->kho;

                                // Lấy danh sách id lô nhuộm
                                $loNhuomRepository = new LoNhuomRepository();
                                $list_id_lo_nhuom = $loNhuomRepository->getDanhSachIdLoNhuom();

                                // Lấy danh sách kho thành phẩm
                                $khoRepository = new KhoRepository();
                                $list_kho_thanh_pham = $khoRepository->getDanhSachKhoThanhPham();

                                // Lấy danh sách id hóa đơn xuất
                                $hoaDonXuatRepository = new HoaDonXuatRepository();
                                $list_id_hoa_don_xuat = $hoaDonXuatRepository->getDanhSachIdHoaDonXuat();

                                // Lấy danh sách tình trạng có thể có của cây thành phẩm
                                $list_tinh_trang = $this->tinh_trang_cay_moc_vai_thanh_pham;

                                return view('cap_nhat_cay_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                                                      ->with('list_id_cay_thanh_pham', $list_id_cay_thanh_pham)
                                                                      ->with('cay_thanh_pham_duoc_chon', $cay_thanh_pham_duoc_chon)
                                                                      ->with('cay_thanh_pham_cu', $cay_thanh_pham_duoc_chon_json)
                                                                      ->with('list_id_cay_moc', $list_id_cay_moc)
                                                                      ->with('list_kho', $list_kho)
                                                                      ->with('list_id_lo_nhuom', $list_id_lo_nhuom)
                                                                      ->with('list_kho_thanh_pham', $list_kho_thanh_pham)
                                                                      ->with('list_id_hoa_don_xuat', $list_id_hoa_don_xuat)
                                                                      ->with('list_tinh_trang', $list_tinh_trang);
                            }
                            else
                            {
                                $errorMessage = 'Id cây thành phẩm không tồn tại trong database !';

                                return view('cap_nhat_cay_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                                                      ->with('list_id_cay_thanh_pham', $list_id_cay_thanh_pham)
                                                                      ->with('errorMessage', $errorMessage);
                            }
                        }
                        else    // $id_cay_thanh_pham không phải là số nguyên dương
                        {
                            $errorMessage = 'Id cây thành phẩm phải là số nguyên dương !';

                            return view('cap_nhat_cay_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                                                  ->with('list_id_cay_thanh_pham', $list_id_cay_thanh_pham)
                                                                  ->with('errorMessage', $errorMessage);
                        }
                    }
            }
        }

        // Chưa Login
        return redirect()->to(route('route_get_login_he_thong'));
    }

    public function postCapNhatCayVaiThanhPham(Request $request, $id_cay_thanh_pham)
    {
        // Tạo đối tượng ThanhPhamRepository và HoaDonXuatRepository
        $thanhPhamRepository = new ThanhPhamRepository();
        $hoaDonXuatRepository = new HoaDonXuatRepository();

        if ($request->has('frm_chon_ma_cay_thanh_pham'))    // Button "Chọn" được click
        {
            $id_cay_thanh_pham = (int)($request->get('IdCayThanhPham'));

            // Lấy danh sách chức năng tương ứng với quyền của user
            $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_KHO);

            // Lấy danh sách id cây thành phẩm
            $list_id_cay_thanh_pham = $thanhPhamRepository->getDanhSachIdCayThanhPham();

            // Lấy cây thành phẩm mà user đã chọn
            $cay_thanh_pham_duoc_chon = $thanhPhamRepository->getCayThanhPhamById($id_cay_thanh_pham);
            $cay_thanh_pham_duoc_chon_json = json_encode($cay_thanh_pham_duoc_chon);

            // Lấy danh sách id cây mộc mà dành cho việc Nhập/Cập nhật cây thành phẩm
            $list_id_cay_moc = array();
            $mocRepository = new MocRepository();
            $temp = $mocRepository->getDanhSachIdCayMocChoViecNhap_CapNhatCayThanhPham();
            foreach ($temp as $cay_moc)
            {
                $list_id_cay_moc[] = $cay_moc->id;
            }
            $list_id_cay_moc[] = $cay_thanh_pham_duoc_chon->id_cay_vai_moc;
            $list_id_cay_moc = array_unique($list_id_cay_moc);
            sort($list_id_cay_moc);

            // Lấy danh sách khổ
            $list_kho = $this->kho;

            // Lấy danh sách id lô nhuộm
            $loNhuomRepository = new LoNhuomRepository();
            $list_id_lo_nhuom = $loNhuomRepository->getDanhSachIdLoNhuom();

            // Lấy danh sách kho thành phẩm
            $khoRepository = new KhoRepository();
            $list_kho_thanh_pham = $khoRepository->getDanhSachKhoThanhPham();

            // Lấy danh sách id hóa đơn xuất
            $list_id_hoa_don_xuat = $hoaDonXuatRepository->getDanhSachIdHoaDonXuat();

            // Lấy danh sách tình trạng có thể có của cây thành phẩm
            $list_tinh_trang = $this->tinh_trang_cay_moc_vai_thanh_pham;

            return view('cap_nhat_cay_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                                  ->with('list_id_cay_thanh_pham', $list_id_cay_thanh_pham)
                                                  ->with('cay_thanh_pham_duoc_chon', $cay_thanh_pham_duoc_chon)
                                                  ->with('cay_thanh_pham_cu', $cay_thanh_pham_duoc_chon_json)
                                                  ->with('list_id_cay_moc', $list_id_cay_moc)
                                                  ->with('list_kho', $list_kho)
                                                  ->with('list_id_lo_nhuom', $list_id_lo_nhuom)
                                                  ->with('list_kho_thanh_pham', $list_kho_thanh_pham)
                                                  ->with('list_id_hoa_don_xuat', $list_id_hoa_don_xuat)
                                                  ->with('list_tinh_trang', $list_tinh_trang);
        }
        else    // Button "Cập nhật" được click
        {
            // Validate fields
            $rules = [
                'so_met' => 'required|integer|min:1',
                'don_gia' => 'integer|min:1',
                'ngay_gio_nhap_kho' => 'required|date'
            ];
            $messages = [
                'so_met.required' => 'Bạn chưa nhập số mét cây thành phẩm !',
                'so_met.integer' => 'Số mét cây thành phẩm phải là số nguyên dương !',
                'so_met.min' => 'Số mét cây thành phẩm ít nhất phải là 1 !',
                'don_gia.integer' => 'Đơn giá cây thành phẩm phải là số nguyên dương !',
                'don_gia.min' => 'Đơn giá cây thành phẩm ít nhất phải là 1 !',
                'ngay_gio_nhap_kho.required' => 'Bạn chưa nhập ngày giờ nhập kho !',
                'ngay_gio_nhap_kho.date' => 'Ngày giờ nhập kho không hợp lệ !'
            ];
            $this->validate($request, $rules, $messages);

            // Validate Đơn giá
            $don_gia = $request->get('don_gia');
            if ($don_gia != '' && (int)$don_gia == 0)   // Đơn giá là 1 chuỗi gồm 1 hoặc nhiều số 0
            {
                $errorMessage = 'Đơn giá ít nhất phải là 1 hoặc có thể để trống không nhập !';

                // Tạo thủ công Validation error messages
                $validator = Validator::make($request->all(), array(), array());
                $errors = $validator->errors();
                $errors->add('DonGia', $errorMessage);

                return redirect(URL::previous())->withErrors($errors)
                                                ->withInput();
            }

            // Validate mối liên hệ logic giữa: Mã hóa đơn xuất và Tình trạng
            $id_hoa_don_xuat = $request->get('id_hoa_don_xuat');
            $tinh_trang = $request->get('tinh_trang');
            if ($id_hoa_don_xuat == 'null' && $tinh_trang == 'Đã xuất')
            {
                $errorMessage = 'Mã hóa đơn xuất là null thì tình trạng phải là chưa xuất !';

                // Tạo thủ công Validation error messages
                $validator = Validator::make($request->all(), array(), array());
                $errors = $validator->errors();
                $errors->add('MaHoaDonXuat_TinhTrang', $errorMessage);

                return redirect(URL::previous())->withErrors($errors)
                                                ->withInput();
            }
            else if ($id_hoa_don_xuat != 'null' && $tinh_trang == 'Chưa xuất')
            {
                $errorMessage = 'Mã hóa đơn xuất có tồn tại thì tình trạng phải là đã xuất !';

                // Tạo thủ công Validation error messages
                $validator = Validator::make($request->all(), array(), array());
                $errors = $validator->errors();
                $errors->add('MaHoaDonXuat_TinhTrang', $errorMessage);

                return redirect(URL::previous())->withErrors($errors)
                                                ->withInput();
            }

            // Validate successful
            // Xử lý cập nhật cây thành phẩm
            $thanhPhamRepository->capNhatCayThanhPham($request);
            $hoaDonXuatRepository->capNhatCayThanhPham($request);
            //echo "<script> alert('Cập nhật thành công !'); </script>";

            // Show lại trang Cập nhật cây thành phẩm
            $id_cay_thanh_pham = (int)($request->get('idCayThanhPham'));

            // Lấy danh sách chức năng tương ứng với quyền của user
            $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_KHO);

            // Lấy danh sách id cây thành phẩm
            $list_id_cay_thanh_pham = $thanhPhamRepository->getDanhSachIdCayThanhPham();

            // Lấy cây thành phẩm mà user đã chọn
            $cay_thanh_pham_duoc_chon = $thanhPhamRepository->getCayThanhPhamById($id_cay_thanh_pham);
            $cay_thanh_pham_duoc_chon_json = json_encode($cay_thanh_pham_duoc_chon);

            // Lấy danh sách id cây mộc mà dành cho việc Nhập/Cập nhật cây thành phẩm
            $list_id_cay_moc = array();
            $mocRepository = new MocRepository();
            $temp = $mocRepository->getDanhSachIdCayMocChoViecNhap_CapNhatCayThanhPham();
            foreach ($temp as $cay_moc)
            {
                $list_id_cay_moc[] = $cay_moc->id;
            }
            $list_id_cay_moc[] = $cay_thanh_pham_duoc_chon->id_cay_vai_moc;
            $list_id_cay_moc = array_unique($list_id_cay_moc);
            sort($list_id_cay_moc);

            // Lấy danh sách khổ
            $list_kho = $this->kho;

            // Lấy danh sách id lô nhuộm
            $loNhuomRepository = new LoNhuomRepository();
            $list_id_lo_nhuom = $loNhuomRepository->getDanhSachIdLoNhuom();

            // Lấy danh sách kho thành phẩm
            $khoRepository = new KhoRepository();
            $list_kho_thanh_pham = $khoRepository->getDanhSachKhoThanhPham();

            // Lấy danh sách id hóa đơn xuất
            $list_id_hoa_don_xuat = $hoaDonXuatRepository->getDanhSachIdHoaDonXuat();

            // Lấy danh sách tình trạng có thể có của cây thành phẩm
            $list_tinh_trang = $this->tinh_trang_cay_moc_vai_thanh_pham;

            return view('cap_nhat_cay_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                                  ->with('list_id_cay_thanh_pham', $list_id_cay_thanh_pham)
                                                  ->with('cay_thanh_pham_duoc_chon', $cay_thanh_pham_duoc_chon)
                                                  ->with('cay_thanh_pham_cu', $cay_thanh_pham_duoc_chon_json)
                                                  ->with('list_id_cay_moc', $list_id_cay_moc)
                                                  ->with('list_kho', $list_kho)
                                                  ->with('list_id_lo_nhuom', $list_id_lo_nhuom)
                                                  ->with('list_kho_thanh_pham', $list_kho_thanh_pham)
                                                  ->with('list_id_hoa_don_xuat', $list_id_hoa_don_xuat)
                                                  ->with('list_tinh_trang', $list_tinh_trang);
        }
    }

    public function getXuatVaiThanhPham()
    {
        // Check Login
        if (Session::has('username') && Session::has('quyen'))  // Đã Login
        {
            // Redirect tới view mà tương ứng với quyền của user
            switch (Session::get('quyen'))
            {
                case self::QUYEN_SAN_XUAT:
                    return redirect()->to(route('route_get_trang_chu_san_xuat'));
                case self::QUYEN_BAN_HANG:
                    return redirect()->to(route('route_get_trang_chu_ban_hang'));
                case self::QUYEN_ADMIN:
                case self::QUYEN_KHO:
                    // Lấy danh sách chức năng tương ứng với quyền của user
                    $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_KHO);

                    // Lấy danh sách id hóa đơn xuất
                    $hoaDonXuatRepository = new HoaDonXuatRepository();
                    $list_id_hoa_don_xuat = $hoaDonXuatRepository->getDanhSachIdHoaDonXuat();

                    // Lấy hóa đơn xuất đầu tiên trong database
                    $hoa_don_xuat_dau_tien = $hoaDonXuatRepository->getHoaDonXuatById($list_id_hoa_don_xuat[0]->id);

                    // Lấy danh sách id cây thành phẩm tồn kho (chưa xuất)
                    $thanhPhamRepository = new ThanhPhamRepository();
                    $list_id_cay_thanh_pham_ton_kho = $thanhPhamRepository->getDanhSachIdCayThanhPhamTonKho($hoa_don_xuat_dau_tien->id_kho);

                    return view('xuat_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                                  ->with('list_id_hoa_don_xuat', $list_id_hoa_don_xuat)
                                                  ->with('list_id_cay_thanh_pham_ton_kho', $list_id_cay_thanh_pham_ton_kho);
            }
        }

        // Chưa Login
        return redirect()->to(route('route_get_login_he_thong'));
    }

    public function postXuatVaiThanhPham(Request $request)
    {
        // Xuất thành phẩm
        $thanhPhamRepository = new ThanhPhamRepository();
        $thanhPhamRepository->xuatThanhPham($request);

        // Redirect về trang Xuất vải thành phẩm
        return redirect()->to(route('route_get_xuat_vai_thanh_pham'));
    }

    public function getCapNhatXuatVaiThanhPham($id_hoa_don_xuat = null)
    {
        // Check Login
        if (Session::has('username') && Session::has('quyen'))  // Đã Login
        {
            // Redirect tới view mà tương ứng với quyền của user
            switch (Session::get('quyen'))
            {
                case self::QUYEN_SAN_XUAT:
                    return redirect()->to(route('route_get_trang_chu_san_xuat'));
                case self::QUYEN_BAN_HANG:
                    return redirect()->to(route('route_get_trang_chu_ban_hang'));
                case self::QUYEN_ADMIN:
                case self::QUYEN_KHO:
                    // Lấy danh sách chức năng tương ứng với quyền của user
                    $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_KHO);

                    // Lấy danh sách id hóa đơn xuất
                    $hoaDonXuatRepository = new HoaDonXuatRepository();
                    $list_id_hoa_don_xuat = $hoaDonXuatRepository->getDanhSachIdHoaDonXuat();

                    if ($id_hoa_don_xuat == null)   // $id_hoa_don_xuat không được truyền
                    {
                        return view('cap_nhat_xuat_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                                               ->with('list_id_hoa_don_xuat', $list_id_hoa_don_xuat);
                    }
                    else    // $id_hoa_don_xuat được truyền
                    {
                        $errorMessage = '';

                        if (ctype_digit($id_hoa_don_xuat) == true && (int)($id_hoa_don_xuat) > 0)   // $id_hoa_don_xuat là số nguyên dương
                        {
                            $hopLe = false;

                            // Ép kiểu $id_hoa_don_xuat về kiểu int
                            $id_hoa_don_xuat = (int)$id_hoa_don_xuat;

                            // Kiểm tra xem $id_hoa_don_xuat có tồn tại trong database hay không
                            foreach ($list_id_hoa_don_xuat as $hoa_don_xuat)
                            {
                                if ($id_hoa_don_xuat == $hoa_don_xuat->id)
                                {
                                    $hopLe = true;
                                    break;
                                }
                            }

                            if ($hopLe == true)
                            {
                                // Lấy hóa đơn xuất mà user đã chọn
                                $hoa_don_xuat_duoc_chon = $hoaDonXuatRepository->getHoaDonXuatById($id_hoa_don_xuat);

                                // Tạo đối tượng ThanhPhamRepository
                                $thanhPhamRepository = new ThanhPhamRepository();

                                // Lấy danh sách cây vải thành phẩm nằm trong hóa đơn xuất mà user đã chọn
                                $list_cay_thanh_pham_trong_hoa_don_xuat = $thanhPhamRepository->getDanhSachCayThanhPhamTrongHoaDonXuat($id_hoa_don_xuat);

                                // Lấy danh sách id cây vải thành phẩm tồn kho và danh sách id cây vải thành phẩm nằm trong hóa đơn xuất mà user đã chọn
                                $list_id_cay_thanh_pham_ton_kho_hoac_trong_hoa_don_xuat_duoc_chon = $thanhPhamRepository->getDanhSachIdCayThanhPhamTonKhoVaTrongHoaDonXuat($id_hoa_don_xuat, $hoa_don_xuat_duoc_chon->id_kho);

                                return view('cap_nhat_xuat_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                                                       ->with('list_id_hoa_don_xuat', $list_id_hoa_don_xuat)
                                                                       ->with('hoa_don_xuat_duoc_chon', $hoa_don_xuat_duoc_chon)
                                                                       ->with('list_cay_thanh_pham_trong_hoa_don_xuat', $list_cay_thanh_pham_trong_hoa_don_xuat)
                                                                       ->with('list_id_cay_thanh_pham_ton_kho_hoac_trong_hoa_don_xuat_duoc_chon', $list_id_cay_thanh_pham_ton_kho_hoac_trong_hoa_don_xuat_duoc_chon);
                            }
                            else
                            {
                                $errorMessage = 'Id hóa đơn xuất không tồn tại trong database !';

                                return view('cap_nhat_xuat_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                                                       ->with('list_id_hoa_don_xuat', $list_id_hoa_don_xuat)
                                                                       ->with('errorMessage', $errorMessage);
                            }
                        }
                        else    // $id_hoa_don_xuat không phải là số nguyên dương
                        {
                            $errorMessage = 'Id hóa đơn xuất phải là số nguyên dương !';

                            return view('cap_nhat_xuat_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                                                   ->with('list_id_hoa_don_xuat', $list_id_hoa_don_xuat)
                                                                   ->with('errorMessage', $errorMessage);
                        }
                    }
            }
        }

        // Chưa Login
        return redirect()->to(route('route_get_login_he_thong'));
    }

    public function postCapNhatXuatVaiThanhPham(Request $request, $id_hoa_don_xuat)
    {
        $id_hoa_don_xuat = (int)($request->get('id_hoa_don_xuat'));

        // Tạo đối tượng ThanhPhamRepository và HoaDonXuatRepository
        $thanhPhamRepository = new ThanhPhamRepository();
        $hoaDonXuatRepository = new HoaDonXuatRepository();

        if ($request->get('chon_ma_hoa_don_xuat') == 'false')     // Button "Cập nhật xuất vải thành phẩm" được click
        {
            // Tạo đối tượng ThuChiRepository, KhachHangRepository và DonHangKhachHangRepository
            $thuChiRepository = new ThuChiRepository();
            $khachHangRepository = new KhachHangRepository();
            $donHangKhachHangRepository = new DonHangKhachHangRepository();

            // Lấy dữ liệu để cập nhật xuất vải thành phẩm
            $tong_so_cay_thanh_pham = (int)($request->get('tongSoCayThanhPham'));
            $tong_so_met = (int)($request->get('tongSoMet'));
            $tong_tien = (int)($request->get('tongTien'));
            $list_id_cay_thanh_pham_muon_xuat = $request->get('list_id_cay_thanh_pham_muon_xuat');

            // Xử lý cập nhật xuất vải thành phẩm
            $thanhPhamRepository->capNhatXuatThanhPham($id_hoa_don_xuat, $list_id_cay_thanh_pham_muon_xuat);
            $hoaDonXuatRepository->capNhatXuatThanhPham($id_hoa_don_xuat, $tong_so_cay_thanh_pham, $tong_so_met, $tong_tien);

            // Lấy hóa đơn xuất mà user đã chọn
            $hoa_don_xuat_duoc_chon = $hoaDonXuatRepository->getHoaDonXuatById($id_hoa_don_xuat);

            // Update lại Công nợ của Khách hàng mà tương ứng với Hóa đơn xuất mà user đã chọn
            $id_khach_hang = $hoa_don_xuat_duoc_chon->id_khach_hang;
            $tong_so_tien_no_cua_khach_hang = $hoaDonXuatRepository->getTongSoTienNoCuaKhachHang($id_khach_hang);
            $tong_so_tien_tra_cua_khach_hang = $thuChiRepository->getTongSoTienTraCuaKhachHang($id_khach_hang);
            $cong_no_moi_cua_khach_hang = $tong_so_tien_no_cua_khach_hang - $tong_so_tien_tra_cua_khach_hang;
            $khachHangRepository->updateCongNoKhachHang($id_khach_hang, $cong_no_moi_cua_khach_hang);

            // Update lại Tình trạng của Đơn hàng khách hàng mà tương ứng với Hóa đơn xuất mà user đã chọn
            $id_don_hang_khach_hang = $hoa_don_xuat_duoc_chon->id_don_hang_khach_hang;
            $tong_so_met_da_giao = $hoaDonXuatRepository->tinhTongSoMetDaGiaoCuaDonHangKhachHang($id_don_hang_khach_hang);
            $donHangKhachHangRepository->updateTinhTrangDonHangKhachHang($id_don_hang_khach_hang, $tong_so_met_da_giao);
        }

        // Lấy danh sách chức năng tương ứng với quyền của user
        $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_KHO);

        // Lấy danh sách id hóa đơn xuất
        $list_id_hoa_don_xuat = $hoaDonXuatRepository->getDanhSachIdHoaDonXuat();

        // Lấy hóa đơn xuất mà user đã chọn
        $hoa_don_xuat_duoc_chon = $hoaDonXuatRepository->getHoaDonXuatById($id_hoa_don_xuat);

        // Lấy danh sách cây vải thành phẩm nằm trong hóa đơn xuất mà user đã chọn
        $list_cay_thanh_pham_trong_hoa_don_xuat = $thanhPhamRepository->getDanhSachCayThanhPhamTrongHoaDonXuat($id_hoa_don_xuat);

        // Lấy danh sách id cây vải thành phẩm tồn kho và danh sách id cây vải thành phẩm nằm trong hóa đơn xuất mà user đã chọn
        $list_id_cay_thanh_pham_ton_kho_hoac_trong_hoa_don_xuat_duoc_chon = $thanhPhamRepository->getDanhSachIdCayThanhPhamTonKhoVaTrongHoaDonXuat($id_hoa_don_xuat, $hoa_don_xuat_duoc_chon->id_kho);

        return view('cap_nhat_xuat_thanh_pham')->with('list_chuc_nang', $list_chuc_nang)
                                               ->with('list_id_hoa_don_xuat', $list_id_hoa_don_xuat)
                                               ->with('hoa_don_xuat_duoc_chon', $hoa_don_xuat_duoc_chon)
                                               ->with('list_cay_thanh_pham_trong_hoa_don_xuat', $list_cay_thanh_pham_trong_hoa_don_xuat)
                                               ->with('list_id_cay_thanh_pham_ton_kho_hoac_trong_hoa_don_xuat_duoc_chon', $list_id_cay_thanh_pham_ton_kho_hoac_trong_hoa_don_xuat_duoc_chon);
    }

    public function getHoaDonXuat()
    {
        // Check Login
        if (Session::has('username') && Session::has('quyen'))  // Đã Login
        {
            // Redirect tới view mà tương ứng với quyền của user
            switch (Session::get('quyen'))
            {
                case self::QUYEN_SAN_XUAT:
                    return redirect()->to(route('route_get_trang_chu_san_xuat'));
                case self::QUYEN_KHO:
                    return redirect()->to(route('route_get_trang_chu_kho'));
                case self::QUYEN_ADMIN:
                case self::QUYEN_BAN_HANG:
                    // Lấy danh sách chức năng tương ứng với quyền của user
                    $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_BAN_HANG);

                    // Lấy danh sách hóa đơn xuất
                    $hoaDonXuatRepository = new HoaDonXuatRepository();
                    $list_hoa_don_xuat = $hoaDonXuatRepository->getDanhSachHoaDonXuat();

                    if (count($list_hoa_don_xuat) == 0)
                    {
                        $message = 'Không có hóa đơn xuất nào để hiển thị !';

                        return view('hoa_don_xuat')->with('list_chuc_nang', $list_chuc_nang)
                                                   ->with('message', $message);
                    }

                    // Format lại cho "ngay_gio_xuat_hoa_don"
                    foreach ($list_hoa_don_xuat as $hoa_don_xuat)
                    {
                        $hoa_don_xuat->ngay_gio_xuat_hoa_don = date('d/m/Y H:i:s', strtotime($hoa_don_xuat->ngay_gio_xuat_hoa_don));
                    }
                    // Xử lý chỉ lấy tên khách hàng, tên nhân viên xuất chứ không lấy cả họ tên (nếu cần)
                    /*foreach ($list_hoa_don_xuat as $hoa_don_xuat)
                    {
                        // Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
                        $temp = explode(' ', $hoa_don_xuat->ten_khach_hang);
                        $hoa_don_xuat->ten_khach_hang = $temp[count($temp) - 1];

                        // Xử lý chỉ lấy tên nhân viên xuất chứ không lấy cả họ tên (nếu cần)
                        $temp = explode(' ', $hoa_don_xuat->ten_nhan_vien_xuat);
                        $hoa_don_xuat->ten_nhan_vien_xuat = $temp[count($temp) - 1];
                    }*/

                    // Thiết lập việc có show button Xóa hay không
                    $showButtonXoa = false;
                    if (Session::get('quyen') == self::QUYEN_ADMIN)
                    {
                        $showButtonXoa = true;
                    }

                    return view('hoa_don_xuat')->with('list_chuc_nang', $list_chuc_nang)
                                               ->with('list_hoa_don_xuat', $list_hoa_don_xuat)
                                               ->with('showButtonXoa', $showButtonXoa);
            }
        }

        // Chưa Login
        return redirect()->to(route('route_get_login_he_thong'));
    }

    public function postHoaDonXuat(Request $request)
    {
        // Lấy danh sách id hóa đơn xuất muốn xóa
        $list_id_hoa_don_xuat_muon_xoa = $request->get('list_id_hoa_don_xuat_muon_xoa');

        // Xóa các hóa đơn xuất
        $hoaDonXuatRepository = new HoaDonXuatRepository();
        $hoaDonXuatRepository->deleteCacHoaDonXuat($list_id_hoa_don_xuat_muon_xoa);

        // Lấy danh sách chức năng tương ứng với quyền của user
        $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_BAN_HANG);

        // Lấy danh sách hóa đơn xuất
        $list_hoa_don_xuat = $hoaDonXuatRepository->getDanhSachHoaDonXuat();

        if (count($list_hoa_don_xuat) == 0)
        {
            $message = 'Không có hóa đơn xuất nào để hiển thị !';

            return view('hoa_don_xuat')->with('list_chuc_nang', $list_chuc_nang)
                                       ->with('message', $message);
        }

        // Format lại cho "ngay_gio_xuat_hoa_don"
        foreach ($list_hoa_don_xuat as $hoa_don_xuat)
        {
            $hoa_don_xuat->ngay_gio_xuat_hoa_don = date('d/m/Y H:i:s', strtotime($hoa_don_xuat->ngay_gio_xuat_hoa_don));
        }
        // Xử lý chỉ lấy tên khách hàng, tên nhân viên xuất chứ không lấy cả họ tên (nếu cần)
        /*foreach ($list_hoa_don_xuat as $hoa_don_xuat)
        {
            // Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
            $temp = explode(' ', $hoa_don_xuat->ten_khach_hang);
            $hoa_don_xuat->ten_khach_hang = $temp[count($temp) - 1];

            // Xử lý chỉ lấy tên nhân viên xuất chứ không lấy cả họ tên (nếu cần)
            $temp = explode(' ', $hoa_don_xuat->ten_nhan_vien_xuat);
            $hoa_don_xuat->ten_nhan_vien_xuat = $temp[count($temp) - 1];
        }*/

        // Thiết lập việc có show button Xóa hay không
        $showButtonXoa = false;
        if (Session::get('quyen') == self::QUYEN_ADMIN)
        {
            $showButtonXoa = true;
        }

        return view('hoa_don_xuat')->with('list_chuc_nang', $list_chuc_nang)
                                   ->with('list_hoa_don_xuat', $list_hoa_don_xuat)
                                   ->with('showButtonXoa', $showButtonXoa);
    }

    public function getThemHoaDonXuat()
    {
        // Check Login
        if (Session::has('username') && Session::has('quyen'))  // Đã Login
        {
            // Redirect tới view mà tương ứng với quyền của user
            switch (Session::get('quyen'))
            {
                case self::QUYEN_SAN_XUAT:
                    return redirect()->to(route('route_get_trang_chu_san_xuat'));
                case self::QUYEN_KHO:
                    return redirect()->to(route('route_get_trang_chu_kho'));
                case self::QUYEN_ADMIN:
                case self::QUYEN_BAN_HANG:
                    // Lấy danh sách chức năng tương ứng với quyền của user
                    $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_BAN_HANG);

                    // Lấy "id hóa đơn xuất cuối cùng" trong database
                    $hoaDonXuatRepository = new HoaDonXuatRepository();
                    $id_hoa_don_xuat_cuoi_cung = $hoaDonXuatRepository->getIdHoaDonXuatCuoiCung();

                    // Lấy danh sách id đơn hàng khách hàng
                    $donHangKhachHangRepository = new DonHangKhachHangRepository();
                    $listIdDonHangKhachHangChuaHoanThanh_Moi = $donHangKhachHangRepository->getDanhSachIdDonHangKhachHangChuaHoanThanh_Moi();

                    // Lấy danh sách kho thành phẩm
                    $khoRepository = new KhoRepository();
                    $list_kho_thanh_pham = $khoRepository->getDanhSachKhoThanhPham();

                    // Lấy danh sách nhân viên xuất hóa đơn
                    $nhanVienRepository = new NhanVienRepository();
                    $list_nhan_vien_xuat_hoa_don = $nhanVienRepository->getDanhSachNhanVienXuatHoaDon();
                    // Xử lý chỉ lấy tên nhân viên xuất hóa đơn chứ không lấy cả họ tên (nếu cần)
                    /*foreach ($list_nhan_vien_xuat_hoa_don as $nhan_vien_xuat_hoa_don)
                    {
                        $temp = explode(' ', $nhan_vien_xuat_hoa_don->ho_ten);
                        $nhan_vien_xuat_hoa_don->ho_ten = $temp[count($temp) - 1];
                    }*/

                    // Lấy danh sách tính chất có thể có của hóa đơn xuất
                    $list_tinh_chat = $this->tinh_chat;

                    return view('them_hoa_don_xuat')->with('list_chuc_nang', $list_chuc_nang)
                                                    ->with('id_hoa_don_xuat_cuoi_cung', $id_hoa_don_xuat_cuoi_cung)
                                                    ->with('listIdDonHangKhachHangChuaHoanThanh_Moi', $listIdDonHangKhachHangChuaHoanThanh_Moi)
                                                    ->with('list_kho_thanh_pham', $list_kho_thanh_pham)
                                                    ->with('list_nhan_vien_xuat_hoa_don', $list_nhan_vien_xuat_hoa_don)
                                                    ->with('list_tinh_chat', $list_tinh_chat);
            }
        }

        // Chưa Login
        return redirect()->to(route('route_get_login_he_thong'));
    }

    public function postThemHoaDonXuat(ThemHoaDonXuatRequest $request)
    {
        // Tạo đối tượng HoaDonXuatRepository, DonHangKhachHangRepository, ThuChiRepository và KhachHangRepository
        $hoaDonXuatRepository = new HoaDonXuatRepository();
        $donHangKhachHangRepository = new DonHangKhachHangRepository();
        $thuChiRepository = new ThuChiRepository();
        $khachHangRepository = new KhachHangRepository();

        // Thêm hóa đơn xuất
        $hoaDonXuatRepository->themHoaDonXuat($request);

        // Update lại Công nợ của Khách hàng mà tương ứng với Hóa đơn xuất vừa được tạo
        $id_khach_hang = (int)($request->get('id_khach_hang'));
        $tong_so_tien_no_cua_khach_hang = $hoaDonXuatRepository->getTongSoTienNoCuaKhachHang($id_khach_hang);
	$tong_so_tien_tra_cua_khach_hang = $thuChiRepository->getTongSoTienTraCuaKhachHang($id_khach_hang);
	$cong_no_moi_cua_khach_hang = $tong_so_tien_no_cua_khach_hang - $tong_so_tien_tra_cua_khach_hang;
	$khachHangRepository->updateCongNoKhachHang($id_khach_hang, $cong_no_moi_cua_khach_hang);

        // Update lại Tình trạng của Đơn hàng khách hàng mà tương ứng với Hóa đơn xuất vừa mới Thêm
        $id_don_hang_khach_hang = (int)($request->get('id_don_hang_khach_hang'));
        $tong_so_met_da_giao = $hoaDonXuatRepository->tinhTongSoMetDaGiaoCuaDonHangKhachHang($id_don_hang_khach_hang);
        $donHangKhachHangRepository->updateTinhTrangDonHangKhachHang($id_don_hang_khach_hang, $tong_so_met_da_giao);

        // Redirect về trang Thêm hóa đơn xuất
        return redirect()->to(route('route_get_them_hoa_don_xuat'));
    }

    public function getCapNhatHoaDonXuat($id_hoa_don_xuat = null)
    {
        // Check Login
        if (Session::has('username') && Session::has('quyen'))  // Đã Login
        {
            // Redirect tới view mà tương ứng với quyền của user
            switch (Session::get('quyen'))
            {
                case self::QUYEN_SAN_XUAT:
                    return redirect()->to(route('route_get_trang_chu_san_xuat'));
                case self::QUYEN_KHO:
                    return redirect()->to(route('route_get_trang_chu_kho'));
                case self::QUYEN_ADMIN:
                case self::QUYEN_BAN_HANG:
                    // Lấy danh sách chức năng tương ứng với quyền của user
                    $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_BAN_HANG);

                    // Tạo đối tượng HoaDonXuatRepository
                    $hoaDonXuatRepository = new HoaDonXuatRepository();

                    // Lấy danh sách id hóa đơn xuất
                    $list_id_hoa_don_xuat = $hoaDonXuatRepository->getDanhSachIdHoaDonXuat();

                    if ($id_hoa_don_xuat == null)   // $id_hoa_don_xuat không được truyền
                    {
                        return view('cap_nhat_hoa_don_xuat')->with('list_chuc_nang', $list_chuc_nang)
                                                            ->with('list_id_hoa_don_xuat', $list_id_hoa_don_xuat);
                    }
                    else    // $id_hoa_don_xuat được truyền
                    {
                        $errorMessage = '';

                        if (ctype_digit($id_hoa_don_xuat) == true && (int)($id_hoa_don_xuat) > 0)   // $id_hoa_don_xuat là số nguyên dương
                        {
                            $hopLe = false;

                            // Ép kiểu $id_hoa_don_xuat về kiểu int
                            $id_hoa_don_xuat = (int)$id_hoa_don_xuat;

                            // Kiểm tra xem $id_hoa_don_xuat có tồn tại trong database hay không
                            foreach ($list_id_hoa_don_xuat as $hoa_don_xuat)
                            {
                                if ($id_hoa_don_xuat == $hoa_don_xuat->id)
                                {
                                    $hopLe = true;
                                    break;
                                }
                            }

                            if ($hopLe == true)
                            {
                                // Lấy hóa đơn xuất mà user đã chọn
                                $hoa_don_xuat_duoc_chon = $hoaDonXuatRepository->getHoaDonXuatById($id_hoa_don_xuat);
                                // Xử lý chỉ lấy tên khách hàng, tên nhân viên xuất hóa đơn chứ không lấy cả họ tên (nếu cần)
                                /*$temp = explode(' ', $hoa_don_xuat_duoc_chon->ten_khach_hang);
                                $hoa_don_xuat_duoc_chon->ten_khach_hang = $temp[count($temp) - 1];
                                $temp = explode(' ', $hoa_don_xuat_duoc_chon->ten_nhan_vien_xuat);
                                $hoa_don_xuat_duoc_chon->ten_nhan_vien_xuat = $temp[count($temp) - 1];*/
                                $hoa_don_xuat_duoc_chon_json = json_encode($hoa_don_xuat_duoc_chon);

                                // Lấy danh sách id đơn hàng khách hàng
                                $listIdDonHangKhachHangChuaHoanThanh_Moi = array();
				$donHangKhachHangRepository = new DonHangKhachHangRepository();
				$temp = $donHangKhachHangRepository->getDanhSachIdDonHangKhachHangChuaHoanThanh_Moi();
                                foreach ($temp as $don_hang_khach_hang)
                                {
                                    $listIdDonHangKhachHangChuaHoanThanh_Moi[] = $don_hang_khach_hang->id;
                                }
                                $listIdDonHangKhachHangChuaHoanThanh_Moi[] = $hoa_don_xuat_duoc_chon->id_don_hang_khach_hang;
                                $listIdDonHangKhachHangChuaHoanThanh_Moi = array_unique($listIdDonHangKhachHangChuaHoanThanh_Moi);
                                sort($listIdDonHangKhachHangChuaHoanThanh_Moi);

                                // Lấy danh sách kho thành phẩm
				$khoRepository = new KhoRepository();
				$list_kho_thanh_pham = $khoRepository->getDanhSachKhoThanhPham();

                                // Lấy danh sách nhân viên xuất hóa đơn
				$nhanVienRepository = new NhanVienRepository();
				$list_nhan_vien_xuat_hoa_don = $nhanVienRepository->getDanhSachNhanVienXuatHoaDon();
				// Xử lý chỉ lấy tên nhân viên xuất hóa đơn chứ không lấy cả họ tên (nếu cần)
				/*foreach ($list_nhan_vien_xuat_hoa_don as $nhan_vien_xuat_hoa_don)
				{
					$temp = explode(' ', $nhan_vien_xuat_hoa_don->ho_ten);
					$nhan_vien_xuat_hoa_don->ho_ten = $temp[count($temp) - 1];
				}*/

                                // Lấy danh sách tính chất có thể có của hóa đơn xuất
				$list_tinh_chat = $this->tinh_chat;

                                return view('cap_nhat_hoa_don_xuat')->with('list_chuc_nang', $list_chuc_nang)
                                                                    ->with('list_id_hoa_don_xuat', $list_id_hoa_don_xuat)
                                                                    ->with('hoa_don_xuat_duoc_chon', $hoa_don_xuat_duoc_chon)
                                                                    ->with('hoa_don_xuat_cu', $hoa_don_xuat_duoc_chon_json)
                                                                    ->with('listIdDonHangKhachHangChuaHoanThanh_Moi', $listIdDonHangKhachHangChuaHoanThanh_Moi)
                                                                    ->with('list_kho_thanh_pham', $list_kho_thanh_pham)
                                                                    ->with('list_nhan_vien_xuat_hoa_don', $list_nhan_vien_xuat_hoa_don)
                                                                    ->with('list_tinh_chat', $list_tinh_chat);
                            }
                            else
                            {
                                $errorMessage = 'Id hóa đơn xuất không tồn tại trong database !';

                                return view('cap_nhat_hoa_don_xuat')->with('list_chuc_nang', $list_chuc_nang)
                                                                    ->with('list_id_hoa_don_xuat', $list_id_hoa_don_xuat)
                                                                    ->with('errorMessage', $errorMessage);
                            }
                        }
                        else    // $id_hoa_don_xuat không phải là số nguyên dương
                        {
                            $errorMessage = 'Id hóa đơn xuất phải là số nguyên dương !';

                            return view('cap_nhat_hoa_don_xuat')->with('list_chuc_nang', $list_chuc_nang)
                                                                ->with('list_id_hoa_don_xuat', $list_id_hoa_don_xuat)
                                                                ->with('errorMessage', $errorMessage);
                        }
                    }
            }
        }

        // Chưa Login
        return redirect()->to(route('route_get_login_he_thong'));
    }

    public function postCapNhatHoaDonXuat(Request $request, $id_hoa_don_xuat)
    {
        // Tạo đối tượng HoaDonXuatRepository và DonHangKhachHangRepository
        $hoaDonXuatRepository = new HoaDonXuatRepository();
        $donHangKhachHangRepository = new DonHangKhachHangRepository();

        $id_hoa_don_xuat = (int)($request->get('IdHoaDonXuat'));

        if (!$request->has('frm_chon_ma_hoa_don_xuat'))     // Button "Cập nhật" được click
        {
            // Validate fields
            $rules = [
                'ngay_gio_xuat_hoa_don' => 'required|date'
            ];
            $messages = [
                'ngay_gio_xuat_hoa_don.required' => 'Bạn chưa nhập ngày giờ xuất hóa đơn !',
                'ngay_gio_xuat_hoa_don.date' => 'Ngày giờ xuất hóa đơn không hợp lệ !'
            ];
            $this->validate($request, $rules, $messages);

            // Validate successful
            // Xử lý cập nhật hóa đơn xuất
            $hoaDonXuatRepository->capNhatHoaDonXuat($request);

            // Lấy hóa đơn xuất cũ (trước khi cập nhật)
            $hoa_don_xuat_cu = $request->get('hoa_don_xuat_cu');
            $hoa_don_xuat_cu = json_decode($hoa_don_xuat_cu);
            $id_khach_hang_cu = $hoa_don_xuat_cu->id_khach_hang;
            $id_don_hang_khach_hang_cu = $hoa_don_xuat_cu->id_don_hang_khach_hang;
            $id_khach_hang_moi = (int)($request->get('id_khach_hang'));
            $id_don_hang_khach_hang_moi = (int)($request->get('id_don_hang_khach_hang'));

            // Tạo đối tượng ThuChiRepository, KhachHangRepository
            $thuChiRepository = new ThuChiRepository();
            $khachHangRepository = new KhachHangRepository();

            // Update lại Công nợ của Khách hàng
            if ($id_khach_hang_cu != $id_khach_hang_moi)
            {
                // Update lại Công nợ của Khách hàng cũ
                $tong_so_tien_no_cua_khach_hang = $hoaDonXuatRepository->getTongSoTienNoCuaKhachHang($id_khach_hang_cu);
                $tong_so_tien_tra_cua_khach_hang = $thuChiRepository->getTongSoTienTraCuaKhachHang($id_khach_hang_cu);
                $cong_no_moi_cua_khach_hang = $tong_so_tien_no_cua_khach_hang - $tong_so_tien_tra_cua_khach_hang;
                $khachHangRepository->updateCongNoKhachHang($id_khach_hang_cu, $cong_no_moi_cua_khach_hang);

                // Update lại Công nợ của Khách hàng mới
                $tong_so_tien_no_cua_khach_hang = $hoaDonXuatRepository->getTongSoTienNoCuaKhachHang($id_khach_hang_moi);
                $tong_so_tien_tra_cua_khach_hang = $thuChiRepository->getTongSoTienTraCuaKhachHang($id_khach_hang_moi);
                $cong_no_moi_cua_khach_hang = $tong_so_tien_no_cua_khach_hang - $tong_so_tien_tra_cua_khach_hang;
                $khachHangRepository->updateCongNoKhachHang($id_khach_hang_moi, $cong_no_moi_cua_khach_hang);
            }

            // Update lại Tình trạng của Đơn hàng khách hàng
            if ($id_don_hang_khach_hang_cu != $id_don_hang_khach_hang_moi)
            {
                // Update lại Tình trạng của Đơn hàng khách hàng cũ
                $tong_so_met_da_giao = $hoaDonXuatRepository->tinhTongSoMetDaGiaoCuaDonHangKhachHang($id_don_hang_khach_hang_cu);
                $donHangKhachHangRepository->updateTinhTrangDonHangKhachHang($id_don_hang_khach_hang_cu, $tong_so_met_da_giao);

                // Update lại Tình trạng của Đơn hàng khách hàng mới
                $tong_so_met_da_giao = $hoaDonXuatRepository->tinhTongSoMetDaGiaoCuaDonHangKhachHang($id_don_hang_khach_hang_moi);
                $donHangKhachHangRepository->updateTinhTrangDonHangKhachHang($id_don_hang_khach_hang_moi, $tong_so_met_da_giao);
            }

            //echo "<script> alert('Cập nhật thành công !'); </script>";

            $id_hoa_don_xuat = (int)($request->get('idHoaDonXuat'));
        }

        // Lấy danh sách chức năng tương ứng với quyền của user
        $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_BAN_HANG);

        // Lấy danh sách id hóa đơn xuất
        $list_id_hoa_don_xuat = $hoaDonXuatRepository->getDanhSachIdHoaDonXuat();

        // Lấy hóa đơn xuất mà user đã chọn
        $hoa_don_xuat_duoc_chon = $hoaDonXuatRepository->getHoaDonXuatById($id_hoa_don_xuat);
        // Xử lý chỉ lấy tên khách hàng, tên nhân viên xuất hóa đơn chứ không lấy cả họ tên (nếu cần)
        /*$temp = explode(' ', $hoa_don_xuat_duoc_chon->ten_khach_hang);
        $hoa_don_xuat_duoc_chon->ten_khach_hang = $temp[count($temp) - 1];
        $temp = explode(' ', $hoa_don_xuat_duoc_chon->ten_nhan_vien_xuat);
        $hoa_don_xuat_duoc_chon->ten_nhan_vien_xuat = $temp[count($temp) - 1];*/
        $hoa_don_xuat_duoc_chon_json = json_encode($hoa_don_xuat_duoc_chon);

        // Lấy danh sách id đơn hàng khách hàng
        $listIdDonHangKhachHangChuaHoanThanh_Moi = array();
        $temp = $donHangKhachHangRepository->getDanhSachIdDonHangKhachHangChuaHoanThanh_Moi();
        foreach ($temp as $don_hang_khach_hang)
        {
            $listIdDonHangKhachHangChuaHoanThanh_Moi[] = $don_hang_khach_hang->id;
        }
        $listIdDonHangKhachHangChuaHoanThanh_Moi[] = $hoa_don_xuat_duoc_chon->id_don_hang_khach_hang;
        $listIdDonHangKhachHangChuaHoanThanh_Moi = array_unique($listIdDonHangKhachHangChuaHoanThanh_Moi);
        sort($listIdDonHangKhachHangChuaHoanThanh_Moi);

        // Lấy danh sách kho thành phẩm
        $khoRepository = new KhoRepository();
        $list_kho_thanh_pham = $khoRepository->getDanhSachKhoThanhPham();

        // Lấy danh sách nhân viên xuất hóa đơn
        $nhanVienRepository = new NhanVienRepository();
        $list_nhan_vien_xuat_hoa_don = $nhanVienRepository->getDanhSachNhanVienXuatHoaDon();
        // Xử lý chỉ lấy tên nhân viên xuất hóa đơn chứ không lấy cả họ tên (nếu cần)
        /*foreach ($list_nhan_vien_xuat_hoa_don as $nhan_vien_xuat_hoa_don)
        {
                $temp = explode(' ', $nhan_vien_xuat_hoa_don->ho_ten);
                $nhan_vien_xuat_hoa_don->ho_ten = $temp[count($temp) - 1];
        }*/

        // Lấy danh sách tính chất có thể có của hóa đơn xuất
        $list_tinh_chat = $this->tinh_chat;

        return view('cap_nhat_hoa_don_xuat')->with('list_chuc_nang', $list_chuc_nang)
                                            ->with('list_id_hoa_don_xuat', $list_id_hoa_don_xuat)
                                            ->with('hoa_don_xuat_duoc_chon', $hoa_don_xuat_duoc_chon)
                                            ->with('hoa_don_xuat_cu', $hoa_don_xuat_duoc_chon_json)
                                            ->with('listIdDonHangKhachHangChuaHoanThanh_Moi', $listIdDonHangKhachHangChuaHoanThanh_Moi)
                                            ->with('list_kho_thanh_pham', $list_kho_thanh_pham)
                                            ->with('list_nhan_vien_xuat_hoa_don', $list_nhan_vien_xuat_hoa_don)
                                            ->with('list_tinh_chat', $list_tinh_chat);
    }

    public function postShowLoaiVai(Request $request)
    {
        $id_cay_moc = (int)($request->get('id_cay_moc'));

        // Lấy cây mộc mà user đã chọn
        $mocRepository = new MocRepository();
        $cay_moc_duoc_chon = $mocRepository->getCayMocById($id_cay_moc);
        //echo '<pre>',print_r($cay_moc_duoc_chon),'</pre>';

        // Chuyển $cay_moc_duoc_chon về dạng chuỗi JSON
        //$cay_moc_duoc_chon = json_encode($cay_moc_duoc_chon);
        //echo $cay_moc_duoc_chon;

        //return $cay_moc_duoc_chon;
        return response()->json($cay_moc_duoc_chon);
    }

    public function postShowMau(Request $request)
    {
        $id_lo_nhuom = (int)($request->get('id_lo_nhuom'));

        // Lấy lô nhuộm mà user đã chọn
        $loNhuomRepository = new LoNhuomRepository();
        $lo_nhuom_duoc_chon = $loNhuomRepository->getLoNhuomById($id_lo_nhuom);
        //echo '<pre>',print_r($lo_nhuom_duoc_chon),'</pre>';

        // Chuyển $lo_nhuom_duoc_chon về dạng chuỗi JSON
        //$lo_nhuom_duoc_chon = json_encode($lo_nhuom_duoc_chon);
        //echo $lo_nhuom_duoc_chon;

        //return $lo_nhuom_duoc_chon;
        return response()->json($lo_nhuom_duoc_chon);
    }

    public function postShowThongTinCayThanhPham(Request $request)
    {
        $id_cay_thanh_pham_muon_xuat = (int)($request->get('id_cay_thanh_pham_muon_xuat'));

        // Lấy thông tin cây thành phẩm mà user muốn xuất
        $thanhPhamRepository = new ThanhPhamRepository();
        $cay_thanh_pham_muon_xuat = $thanhPhamRepository->getCayThanhPhamById($id_cay_thanh_pham_muon_xuat);
        //echo '<pre>',print_r($cay_thanh_pham_muon_xuat),'</pre>';

        // Chuyển $cay_thanh_pham_muon_xuat về dạng chuỗi JSON
        //$cay_thanh_pham_muon_xuat = json_encode($cay_thanh_pham_muon_xuat);
        //echo $cay_thanh_pham_muon_xuat;

        //return $cay_thanh_pham_muon_xuat;
        return response()->json($cay_thanh_pham_muon_xuat);
    }

    public function postShowLaiDanhSachMaCayThanhPham(Request $request)
    {
        $id_hoa_don_xuat = (int)($request->get('id_hoa_don_xuat'));

        // Lấy hóa đơn xuất tương ứng với $id_hoa_don_xuat
        $hoaDonXuatRepository = new HoaDonXuatRepository();
        $hoa_don_xuat = $hoaDonXuatRepository->getHoaDonXuatById($id_hoa_don_xuat);

        // Lấy danh sách id cây thành phẩm tồn kho (chưa xuất)
        $thanhPhamRepository = new ThanhPhamRepository();
        $list_id_cay_thanh_pham_ton_kho = $thanhPhamRepository->getDanhSachIdCayThanhPhamTonKho($hoa_don_xuat->id_kho);
        //echo '<pre>',print_r($list_id_cay_thanh_pham_ton_kho),'</pre>';

        // Chuyển $list_id_cay_thanh_pham_ton_kho về dạng chuỗi JSON
        //$list_id_cay_thanh_pham_ton_kho = json_encode($list_id_cay_thanh_pham_ton_kho);
        //echo $list_id_cay_thanh_pham_ton_kho;

        //return $list_id_cay_thanh_pham_ton_kho;
        return response()->json($list_id_cay_thanh_pham_ton_kho);
    }

    public function postShowThongTinDonHangKhachHang(Request $request)
    {
        $id_don_hang_khach_hang = (int)($request->get('id_don_hang_khach_hang'));

        // Lấy thông tin đơn hàng khách hàng mà user đã chọn
        $donHangKhachHangRepository = new DonHangKhachHangRepository();
        $don_hang_khach_hang_duoc_chon = $donHangKhachHangRepository->getDonHangKhachHangById($id_don_hang_khach_hang);
        // Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
        /*$temp = explode(' ', $don_hang_khach_hang_duoc_chon->ten_khach_hang);
        $don_hang_khach_hang_duoc_chon->ten_khach_hang = $temp[count($temp) - 1];*/
        //echo '<pre>',print_r($don_hang_khach_hang_duoc_chon),'</pre>';

        // Chuyển $don_hang_khach_hang_duoc_chon về dạng chuỗi JSON
        //$don_hang_khach_hang_duoc_chon = json_encode($don_hang_khach_hang_duoc_chon);
        //echo $don_hang_khach_hang_duoc_chon;

        //return $don_hang_khach_hang_duoc_chon;
        return response()->json($don_hang_khach_hang_duoc_chon);
    }
}
