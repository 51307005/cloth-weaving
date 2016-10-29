<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HelperController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Repositories\KhoRepository;
use App\Http\Repositories\MocRepository;
use App\Http\Repositories\LoaiSoiRepository;
use App\Http\Repositories\LoaiVaiRepository;
use App\Http\Repositories\NhanVienRepository;
use App\Http\Repositories\PhieuXuatMocRepository;
use App\Http\Repositories\LoNhuomRepository;

class KhoMocController extends HelperController
{
    public function getKhoMoc(Request $request)
    {
        if (Session::has('username') && Session::has('quyen'))  // Đã Login
        {
            // Redirect tới view mà tương ứng với quyền của user
            switch (Session::get('quyen'))
            {
                case self::QUYEN_ADMIN:
                    //return redirect()->to(route('route_get_trang_chu_manager'));
                case self::QUYEN_SAN_XUAT:
                    //return redirect()->to(route('route_get_trang_chu_san_xuat'));
                case self::QUYEN_BAN_HANG:
                    //return redirect()->to(route('route_get_trang_chu_ban_hang'));
                case self::QUYEN_KHO:
                    // Xử lý cho trường hợp phân trang
                    if ($request->has('page'))  // Có biến page trên URL
                    {
                        // Tạo đối tượng MocRepository
                        $mocRepository = new MocRepository();

                        if (Session::has('truong_hop_button_xem_kho_moc'))   // Trường hợp: đã click trên chuỗi button phân trang, của button "Xem"
                        {
                            // Lấy danh sách cây mộc tồn kho, trong kho mộc mà user đã chọn
                            $list_cay_moc = $mocRepository->getDanhSachCayMocTonKho(Session::get('kho_moc_duoc_chon')->id);
                            // Format lại cho "ngay_gio_det" và "ngay_gio_nhap_kho"
                            foreach ($list_cay_moc as $cay_moc)
                            {
                                $cay_moc->ngay_gio_det = date('d/m/Y H:i:s', strtotime($cay_moc->ngay_gio_det));
                                $cay_moc->ngay_gio_nhap_kho = date('d/m/Y H:i:s', strtotime($cay_moc->ngay_gio_nhap_kho));
                            }
                            // Xử lý chỉ lấy tên nhân viên dệt chứ không lấy cả họ tên (nếu cần)
                            /*foreach ($list_cay_moc as $cay_moc)
                            {
                                $temp = explode(' ', $cay_moc->ten_nhan_vien_det);
                                $cay_moc->ten_nhan_vien_det = $temp[count($temp) - 1];
                            }*/

                            return view('kho_moc')->with('list_chuc_nang', Session::get('list_chuc_nang'))
                                                  ->with('list_kho_moc', Session::get('list_kho_moc'))
                                                  ->with('list_loai_vai', Session::get('list_loai_vai'))
                                                  ->with('kho_moc_duoc_chon', Session::get('kho_moc_duoc_chon'))
                                                  ->with('showButtonXoa', Session::get('showButtonXoa'))
                                                  ->with('tong_so_cay_moc_ton_kho', Session::get('tong_so_cay_moc_ton_kho'))
                                                  ->with('soCayMocTheoLoaiVai', Session::get('soCayMocTheoLoaiVai'))
                                                  ->with('list_cay_moc', $list_cay_moc);
                        }
                        else if (Session::has('truong_hop_button_xem_tat_ca_cay_moc'))  // Trường hợp: đã click trên chuỗi button phân trang, của button "Xem tất cả cây mộc"
                        {
                            // Lấy danh sách cây mộc, trong kho mộc mà user đã chọn
                            $list_cay_moc = $mocRepository->getDanhSachCayMoc(Session::get('kho_moc_duoc_chon')->id);
                            // Format lại cho "ngay_gio_det" và "ngay_gio_nhap_kho"
                            foreach ($list_cay_moc as $cay_moc)
                            {
                                $cay_moc->ngay_gio_det = date('d/m/Y H:i:s', strtotime($cay_moc->ngay_gio_det));
                                $cay_moc->ngay_gio_nhap_kho = date('d/m/Y H:i:s', strtotime($cay_moc->ngay_gio_nhap_kho));
                            }
                            // Xử lý chỉ lấy tên nhân viên dệt chứ không lấy cả họ tên (nếu cần)
                            /*foreach ($list_cay_moc as $cay_moc)
                            {
                                $temp = explode(' ', $cay_moc->ten_nhan_vien_det);
                                $cay_moc->ten_nhan_vien_det = $temp[count($temp) - 1];
                            }*/

                            return view('kho_moc')->with('list_chuc_nang', Session::get('list_chuc_nang'))
                                                  ->with('list_kho_moc', Session::get('list_kho_moc'))
                                                  ->with('list_loai_vai', Session::get('list_loai_vai'))
                                                  ->with('kho_moc_duoc_chon', Session::get('kho_moc_duoc_chon'))
                                                  ->with('showButtonXoa', Session::get('showButtonXoa'))
                                                  ->with('tong_so_cay_moc', Session::get('tong_so_cay_moc'))
                                                  ->with('soCayMocTheoLoaiVai', Session::get('soCayMocTheoLoaiVai'))
                                                  ->with('list_cay_moc', $list_cay_moc);
                        }
                        else if (Session::has('truong_hop_button_loc_kho_moc'))  // Trường hợp: đã click trên chuỗi button phân trang, của button "Lọc"
                        {
                            // Lấy danh sách cây mộc tồn kho, theo loại vải và trong kho mộc mà user đã chọn
                            $list_cay_moc = $mocRepository->getDanhSachCayMocTonKho(Session::get('kho_moc_duoc_chon')->id, Session::get('loai_vai_duoc_chon_kho_moc')->id);
                            // Format lại cho "ngay_gio_det" và "ngay_gio_nhap_kho"
                            foreach ($list_cay_moc as $cay_moc)
                            {
                                $cay_moc->ngay_gio_det = date('d/m/Y H:i:s', strtotime($cay_moc->ngay_gio_det));
                                $cay_moc->ngay_gio_nhap_kho = date('d/m/Y H:i:s', strtotime($cay_moc->ngay_gio_nhap_kho));
                            }
                            // Xử lý chỉ lấy tên nhân viên dệt chứ không lấy cả họ tên (nếu cần)
                            /*foreach ($list_cay_moc as $cay_moc)
                            {
                                $temp = explode(' ', $cay_moc->ten_nhan_vien_det);
                                $cay_moc->ten_nhan_vien_det = $temp[count($temp) - 1];
                            }*/

                            return view('kho_moc')->with('list_chuc_nang', Session::get('list_chuc_nang'))
                                                  ->with('list_kho_moc', Session::get('list_kho_moc'))
                                                  ->with('list_loai_vai', Session::get('list_loai_vai'))
                                                  ->with('kho_moc_duoc_chon', Session::get('kho_moc_duoc_chon'))
                                                  ->with('showButtonXoa', Session::get('showButtonXoa'))
                                                  ->with('tong_so_cay_moc_ton_kho', Session::get('tong_so_cay_moc_ton_kho'))
                                                  ->with('list_cay_moc', $list_cay_moc)
                                                  ->with('loai_vai_duoc_chon', Session::get('loai_vai_duoc_chon_kho_moc'));
                        }
                        else    // Trường hợp: biến page trên URL do user tự nhập tay vào
                        {
                            return redirect()->to(route('route_get_kho_moc'));
                        }
                    }
                    else    // Không có biến page trên URL hoặc không click trên chuỗi button phân trang
                    {
                        // Lấy danh sách chức năng tương ứng với quyền của user
                        $list_chuc_nang = $this->taoLinkChoListChucNang(Session::get('quyen'));

                        // Lấy danh sách kho mộc
                        $khoRepository = new KhoRepository();
                        $list_kho_moc = $khoRepository->getDanhSachKhoMoc();

                        return view('kho_moc')->with('list_chuc_nang', $list_chuc_nang)
                                              ->with('list_kho_moc', $list_kho_moc);
                    }
            }
        }

        // Chưa Login
        return redirect()->to(route('route_get_login_he_thong'));
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
            // Xử lý chỉ lấy tên nhân viên dệt chứ không lấy cả họ tên (nếu cần)
            /*foreach ($list_cay_moc as $cay_moc)
            {
                $temp = explode(' ', $cay_moc->ten_nhan_vien_det);
                $cay_moc->ten_nhan_vien_det = $temp[count($temp) - 1];
            }*/

            // Xóa tất cả các Session do trường hợp button "Xem tất cả cây mộc" hoặc button "Lọc" thiết lập ra
            Session::forget('list_chuc_nang');
            Session::forget('list_kho_moc');
            Session::forget('list_loai_vai');
            Session::forget('kho_moc_duoc_chon');
            Session::forget('showButtonXoa');
            Session::forget('tong_so_cay_moc');
            Session::forget('soCayMocTheoLoaiVai');
            Session::forget('truong_hop_button_xem_tat_ca_cay_moc');
            Session::forget('tong_so_cay_moc_ton_kho');
            Session::forget('loai_vai_duoc_chon_kho_moc');
            Session::forget('truong_hop_button_loc_kho_moc');

            // Thiết lập Session để hỗ trợ cho việc phân trang
            Session::put('list_chuc_nang', $list_chuc_nang);
            Session::put('list_kho_moc', $list_kho_moc);
            Session::put('list_loai_vai', $list_loai_vai);
            Session::put('kho_moc_duoc_chon', $kho_moc_duoc_chon);
            Session::put('showButtonXoa', $showButtonXoa);
            Session::put('tong_so_cay_moc_ton_kho', $tong_so_cay_moc_ton_kho);
            Session::put('soCayMocTheoLoaiVai', $soCayMocTheoLoaiVai);
            Session::put('truong_hop_button_xem_kho_moc', 'true');

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
            // Xử lý chỉ lấy tên nhân viên dệt chứ không lấy cả họ tên (nếu cần)
            /*foreach ($list_cay_moc as $cay_moc)
            {
                $temp = explode(' ', $cay_moc->ten_nhan_vien_det);
                $cay_moc->ten_nhan_vien_det = $temp[count($temp) - 1];
            }*/

            // Xóa tất cả các Session do trường hợp button "Xem" hoặc button "Lọc" thiết lập ra
            Session::forget('list_chuc_nang');
            Session::forget('list_kho_moc');
            Session::forget('list_loai_vai');
            Session::forget('kho_moc_duoc_chon');
            Session::forget('showButtonXoa');
            Session::forget('tong_so_cay_moc_ton_kho');
            Session::forget('soCayMocTheoLoaiVai');
            Session::forget('truong_hop_button_xem_kho_moc');
            Session::forget('loai_vai_duoc_chon_kho_moc');
            Session::forget('truong_hop_button_loc_kho_moc');

            // Thiết lập Session để hỗ trợ cho việc phân trang
            Session::put('list_chuc_nang', $list_chuc_nang);
            Session::put('list_kho_moc', $list_kho_moc);
            Session::put('list_loai_vai', $list_loai_vai);
            Session::put('kho_moc_duoc_chon', $kho_moc_duoc_chon);
            Session::put('showButtonXoa', $showButtonXoa);
            Session::put('tong_so_cay_moc', $tong_so_cay_moc);
            Session::put('soCayMocTheoLoaiVai', $soCayMocTheoLoaiVai);
            Session::put('truong_hop_button_xem_tat_ca_cay_moc', 'true');

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
                // Xử lý chỉ lấy tên nhân viên dệt chứ không lấy cả họ tên (nếu cần)
                /*foreach ($list_cay_moc as $cay_moc)
                {
                    $temp = explode(' ', $cay_moc->ten_nhan_vien_det);
                    $cay_moc->ten_nhan_vien_det = $temp[count($temp) - 1];
                }*/

                // Xóa tất cả các Session do trường hợp button "Xem" hoặc button "Xem tất cả cây mộc" thiết lập ra
                Session::forget('list_chuc_nang');
                Session::forget('list_kho_moc');
                Session::forget('list_loai_vai');
                Session::forget('kho_moc_duoc_chon');
                Session::forget('showButtonXoa');
                Session::forget('tong_so_cay_moc_ton_kho');
                Session::forget('soCayMocTheoLoaiVai');
                Session::forget('truong_hop_button_xem_kho_moc');
                Session::forget('tong_so_cay_moc');
                Session::forget('truong_hop_button_xem_tat_ca_cay_moc');

                // Thiết lập Session để hỗ trợ cho việc phân trang
                Session::put('list_chuc_nang', $list_chuc_nang);
                Session::put('list_kho_moc', $list_kho_moc);
                Session::put('list_loai_vai', $list_loai_vai);
                Session::put('kho_moc_duoc_chon', $kho_moc_duoc_chon);
                Session::put('showButtonXoa', $showButtonXoa);
                Session::put('tong_so_cay_moc_ton_kho', $tong_so_cay_moc_ton_kho);
                Session::put('loai_vai_duoc_chon_kho_moc', $loai_vai_duoc_chon);
                Session::put('truong_hop_button_loc_kho_moc', 'true');

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
                $message = 'Loại vải '.$loai_vai_duoc_chon->ten.' không có trong '.$kho_moc_duoc_chon->ten.' hoặc loại vải này không còn cây mộc tồn kho nào trong '.$kho_moc_duoc_chon->ten.' !';

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

    public function getCapNhatCayMoc($id_cay_moc = null)
    {
        if (Session::has('username') && Session::has('quyen'))  // Đã Login
        {
            // Redirect tới view mà tương ứng với quyền của user
            switch (Session::get('quyen'))
            {
                case self::QUYEN_ADMIN:
                    //return redirect()->to(route('route_get_trang_chu_manager'));
                case self::QUYEN_SAN_XUAT:
                    //return redirect()->to(route('route_get_trang_chu_san_xuat'));
                case self::QUYEN_BAN_HANG:
                    //return redirect()->to(route('route_get_trang_chu_ban_hang'));
                case self::QUYEN_KHO:
                    // Lấy danh sách chức năng tương ứng với quyền của user
                    $list_chuc_nang = $this->taoLinkChoListChucNang(Session::get('quyen'));

                    // Tạo đối tượng MocRepository
                    $mocRepository = new MocRepository();

                    // Lấy danh sách id cây mộc
                    $list_id_cay_moc = $mocRepository->getDanhSachIdCayMoc();

                    if ($id_cay_moc == null)    // $id_cay_moc không được truyền
                    {
                        return view('cap_nhat_cay_moc')->with('list_chuc_nang', $list_chuc_nang)
                                                       ->with('list_id_cay_moc', $list_id_cay_moc);
                    }
                    else    // $id_cay_moc được truyền
                    {
                        $errorMessage = '';

                        if (ctype_digit($id_cay_moc) == true && (int)($id_cay_moc) > 0)     // $id_cay_moc là số nguyên dương
                        {
                            $hopLe = false;

                            // Ép kiểu $id_cay_moc về kiểu int
                            $id_cay_moc = (int)$id_cay_moc;

                            // Kiểm tra xem $id_cay_moc có tồn tại trong database hay không
                            foreach ($list_id_cay_moc as $cay_moc)
                            {
                                if ($id_cay_moc == $cay_moc->id)
                                {
                                    $hopLe = true;
                                    break;
                                }
                            }

                            if ($hopLe == true)
                            {
                                // Lấy cây mộc mà user đã chọn
                                $cay_moc_duoc_chon = $mocRepository->getCayMocById($id_cay_moc);

                                // Lấy danh sách loại vải
                                $loaiVaiRepository = new LoaiVaiRepository();
                                $list_loai_vai = $loaiVaiRepository->getDanhSachLoaiVai();

                                // Lấy danh sách loại sợi
                                $loaiSoiRepository = new LoaiSoiRepository();
                                $list_loai_soi = $loaiSoiRepository->getDanhSachLoaiSoi();

                                // Lấy danh sách nhân viên dệt
                                $nhanVienRepository = new NhanVienRepository();
                                $list_nhan_vien_det = $nhanVienRepository->getDanhSachNhanVienDet();

                                // Lấy danh sách mã máy dệt
                                $list_ma_may_det = $this->ma_may_det;

                                // Lấy danh sách kho mộc
                                $khoRepository = new KhoRepository();
                                $list_kho_moc = $khoRepository->getDanhSachKhoMoc();

                                // Lấy danh sách id phiếu xuất mộc
                                $phieuXuatMocRepository = new PhieuXuatMocRepository();
                                $list_id_phieu_xuat_moc = $phieuXuatMocRepository->getDanhSachIdPhieuXuatMoc();

                                // Lấy danh sách tình trạng có thể có của cây mộc
                                $list_tinh_trang = $this->tinh_trang_cay_moc_vai_thanh_pham;

                                // Lấy danh sách id lô nhuộm
                                $loNhuomRepository = new LoNhuomRepository();
                                $list_id_lo_nhuom = $loNhuomRepository->getDanhSachIdLoNhuom();

                                return view('cap_nhat_cay_moc')->with('list_chuc_nang', $list_chuc_nang)
                                                               ->with('list_id_cay_moc', $list_id_cay_moc)
                                                               ->with('cay_moc_duoc_chon', $cay_moc_duoc_chon)
                                                               ->with('list_loai_vai', $list_loai_vai)
                                                               ->with('list_loai_soi', $list_loai_soi)
                                                               ->with('list_nhan_vien_det', $list_nhan_vien_det)
                                                               ->with('list_ma_may_det', $list_ma_may_det)
                                                               ->with('list_kho_moc', $list_kho_moc)
                                                               ->with('list_id_phieu_xuat_moc', $list_id_phieu_xuat_moc)
                                                               ->with('list_tinh_trang', $list_tinh_trang)
                                                               ->with('list_id_lo_nhuom', $list_id_lo_nhuom);
                            }
                            else
                            {
                                $errorMessage = 'Id cây mộc không tồn tại trong database !';

                                return view('cap_nhat_cay_moc')->with('list_chuc_nang', $list_chuc_nang)
                                                               ->with('list_id_cay_moc', $list_id_cay_moc)
                                                               ->with('errorMessage', $errorMessage);
                            }
                        }
                        else    // $id_cay_moc không phải là số nguyên dương
                        {
                            $errorMessage = 'Id cây mộc phải là số nguyên dương !';

                            return view('cap_nhat_cay_moc')->with('list_chuc_nang', $list_chuc_nang)
                                                           ->with('list_id_cay_moc', $list_id_cay_moc)
                                                           ->with('errorMessage', $errorMessage);
                        }
                    }
            }
        }

        // Chưa Login
        return redirect()->to(route('route_get_login_he_thong'));
    }

    public function postCapNhatCayMoc(Request $request, $id_cay_moc)
    {
        if ($request->has('frm_chon_ma_cay_moc'))   // Button "Chọn" được click
        {
            $id_cay_moc = (int)($request->get('IdCayMoc'));

            // Lấy danh sách chức năng tương ứng với quyền của user
            $list_chuc_nang = $this->taoLinkChoListChucNang(Session::get('quyen'));

            // Tạo đối tượng MocRepository
            $mocRepository = new MocRepository();

            // Lấy danh sách id cây mộc
            $list_id_cay_moc = $mocRepository->getDanhSachIdCayMoc();

            // Lấy cây mộc mà user đã chọn
            $cay_moc_duoc_chon = $mocRepository->getCayMocById($id_cay_moc);

            // Lấy danh sách loại vải
            $loaiVaiRepository = new LoaiVaiRepository();
            $list_loai_vai = $loaiVaiRepository->getDanhSachLoaiVai();

            // Lấy danh sách loại sợi
            $loaiSoiRepository = new LoaiSoiRepository();
            $list_loai_soi = $loaiSoiRepository->getDanhSachLoaiSoi();

            // Lấy danh sách nhân viên dệt
            $nhanVienRepository = new NhanVienRepository();
            $list_nhan_vien_det = $nhanVienRepository->getDanhSachNhanVienDet();

            // Lấy danh sách mã máy dệt
            $list_ma_may_det = $this->ma_may_det;

            // Lấy danh sách kho mộc
            $khoRepository = new KhoRepository();
            $list_kho_moc = $khoRepository->getDanhSachKhoMoc();

            // Lấy danh sách id phiếu xuất mộc
            $phieuXuatMocRepository = new PhieuXuatMocRepository();
            $list_id_phieu_xuat_moc = $phieuXuatMocRepository->getDanhSachIdPhieuXuatMoc();

            // Lấy danh sách tình trạng có thể có của cây mộc
            $list_tinh_trang = $this->tinh_trang_cay_moc_vai_thanh_pham;

            // Lấy danh sách id lô nhuộm
            $loNhuomRepository = new LoNhuomRepository();
            $list_id_lo_nhuom = $loNhuomRepository->getDanhSachIdLoNhuom();

            return view('cap_nhat_cay_moc')->with('list_chuc_nang', $list_chuc_nang)
                                           ->with('list_id_cay_moc', $list_id_cay_moc)
                                           ->with('cay_moc_duoc_chon', $cay_moc_duoc_chon)
                                           ->with('list_loai_vai', $list_loai_vai)
                                           ->with('list_loai_soi', $list_loai_soi)
                                           ->with('list_nhan_vien_det', $list_nhan_vien_det)
                                           ->with('list_ma_may_det', $list_ma_may_det)
                                           ->with('list_kho_moc', $list_kho_moc)
                                           ->with('list_id_phieu_xuat_moc', $list_id_phieu_xuat_moc)
                                           ->with('list_tinh_trang', $list_tinh_trang)
                                           ->with('list_id_lo_nhuom', $list_id_lo_nhuom);
        }
        else    // Button "Cập nhật" được click
        {
            // Validate fields
            $rules = [
                'so_met' => 'required|integer|min:1',
                'ngay_gio_det' => 'required|date',
                'ngay_gio_nhap_kho' => 'required|date'
            ];
            $messages = [
                'so_met.required' => 'Bạn chưa nhập số mét cây mộc !',
                'so_met.integer' => 'Số mét cây mộc phải là số nguyên dương !',
                'so_met.min' => 'Số mét cây mộc ít nhất phải là 1 !',
                'ngay_gio_det.required' => 'Bạn chưa nhập ngày giờ dệt !',
                'ngay_gio_det.date' => 'Ngày giờ dệt không hợp lệ !',
                'ngay_gio_nhap_kho.required' => 'Bạn chưa nhập ngày giờ nhập kho !',
                'ngay_gio_nhap_kho.date' => 'Ngày giờ nhập kho không hợp lệ !'
            ];
            $this->validate($request, $rules, $messages);

            // Validate trường hợp: Ngày giờ dệt >= Ngày giờ nhập kho
            $ngay_gio_det = $request->get('ngay_gio_det');
            $ngay_gio_det = strtotime($ngay_gio_det);
            $ngay_gio_nhap_kho = $request->get('ngay_gio_nhap_kho');
            $ngay_gio_nhap_kho = strtotime($ngay_gio_nhap_kho);
            if ($ngay_gio_det >= $ngay_gio_nhap_kho)
            {
                $errorMessage = 'Ngày giờ dệt phải trước ngày giờ nhập kho !';

                // Tạo Validation error messages
                $validator = Validator::make($request->all(), [], []);
                $errors = $validator->errors();
                $errors->add('NgayGioDet_NgayGioNhapKho', $errorMessage);

                return redirect(URL::previous())->withErrors($errors)
                                                ->withInput();
            }

            // Validate successful
            // Xử lý cập nhật cây mộc
            $mocRepository = new MocRepository();
            $mocRepository->capNhatCayMoc($request);
            echo "<script> alert('Cập nhật thành công !'); </script>";

            // Show lại trang Cập nhật cây mộc
            $id_cay_moc = (int)($request->get('idCayMoc'));

            // Lấy danh sách chức năng tương ứng với quyền của user
            $list_chuc_nang = $this->taoLinkChoListChucNang(Session::get('quyen'));

            // Lấy danh sách id cây mộc
            $list_id_cay_moc = $mocRepository->getDanhSachIdCayMoc();

            // Lấy cây mộc mà user đã chọn
            $cay_moc_duoc_chon = $mocRepository->getCayMocById($id_cay_moc);

            // Lấy danh sách loại vải
            $loaiVaiRepository = new LoaiVaiRepository();
            $list_loai_vai = $loaiVaiRepository->getDanhSachLoaiVai();

            // Lấy danh sách loại sợi
            $loaiSoiRepository = new LoaiSoiRepository();
            $list_loai_soi = $loaiSoiRepository->getDanhSachLoaiSoi();

            // Lấy danh sách nhân viên dệt
            $nhanVienRepository = new NhanVienRepository();
            $list_nhan_vien_det = $nhanVienRepository->getDanhSachNhanVienDet();

            // Lấy danh sách mã máy dệt
            $list_ma_may_det = $this->ma_may_det;

            // Lấy danh sách kho mộc
            $khoRepository = new KhoRepository();
            $list_kho_moc = $khoRepository->getDanhSachKhoMoc();

            // Lấy danh sách id phiếu xuất mộc
            $phieuXuatMocRepository = new PhieuXuatMocRepository();
            $list_id_phieu_xuat_moc = $phieuXuatMocRepository->getDanhSachIdPhieuXuatMoc();

            // Lấy danh sách tình trạng có thể có của cây mộc
            $list_tinh_trang = $this->tinh_trang_cay_moc_vai_thanh_pham;

            // Lấy danh sách id lô nhuộm
            $loNhuomRepository = new LoNhuomRepository();
            $list_id_lo_nhuom = $loNhuomRepository->getDanhSachIdLoNhuom();

            return view('cap_nhat_cay_moc')->with('list_chuc_nang', $list_chuc_nang)
                                           ->with('list_id_cay_moc', $list_id_cay_moc)
                                           ->with('cay_moc_duoc_chon', $cay_moc_duoc_chon)
                                           ->with('list_loai_vai', $list_loai_vai)
                                           ->with('list_loai_soi', $list_loai_soi)
                                           ->with('list_nhan_vien_det', $list_nhan_vien_det)
                                           ->with('list_ma_may_det', $list_ma_may_det)
                                           ->with('list_kho_moc', $list_kho_moc)
                                           ->with('list_id_phieu_xuat_moc', $list_id_phieu_xuat_moc)
                                           ->with('list_tinh_trang', $list_tinh_trang)
                                           ->with('list_id_lo_nhuom', $list_id_lo_nhuom);
        }
    }
}
