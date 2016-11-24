<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HelperController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\ThemDonHangKhachHangRequest;
use App\Http\Repositories\KhachHangRepository;
use App\Http\Repositories\DonHangKhachHangRepository;
use App\Http\Repositories\HoaDonXuatRepository;
use App\Http\Repositories\LoaiVaiRepository;
use App\Http\Repositories\MauRepository;

class DonHangKhachHangController extends HelperController
{
    public function getDonHangKhachHang(Request $request)
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
                    // Tạo đối tượng DonHangKhachHangRepository và HoaDonXuatRepository
                    $donHangKhachHangRepository = new DonHangKhachHangRepository();
                    $hoaDonXuatRepository = new HoaDonXuatRepository();

                    // Xử lý cho trường hợp phân trang
                    if ($request->has('page'))  // Có biến page trên URL
                    {
                        if (Session::has('truong_hop_truy_cap_bang_url_don_hang_khach_hang'))   // Trường hợp: đã click trên chuỗi button phân trang, của trường hợp "Truy cập bằng URL"
                        {
                            // Lấy danh sách đơn hàng khách hàng "Chưa hoàn thành" / "Mới"
                            $listDonHangKhachHang_ChuaHoanThanh_Moi = $donHangKhachHangRepository->getDanhSachDonHangKhachHangChuaHoanThanh_Moi();

                            // Tính "tổng số mét đã giao" của từng đơn hàng khách hàng ; Format cho "Hạn chót" và "Ngày giờ đặt hàng" ; Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
                            foreach ($listDonHangKhachHang_ChuaHoanThanh_Moi as $don_hang_khach_hang)
                            {
                                // Tính "tổng số mét đã giao" của từng đơn hàng khách hàng
                                $don_hang_khach_hang->tong_so_met_da_giao = $hoaDonXuatRepository->tinhTongSoMetDaGiaoCuaDonHangKhachHang($don_hang_khach_hang->id);

                                // Format cho "Hạn chót" và "Ngày giờ đặt hàng"
                                if ($don_hang_khach_hang->han_chot != null)
                                {
                                    $don_hang_khach_hang->han_chot = date('d/m/Y', strtotime($don_hang_khach_hang->han_chot));
                                }
                                $don_hang_khach_hang->ngay_gio_dat_hang = date('d/m/Y H:i:s', strtotime($don_hang_khach_hang->ngay_gio_dat_hang));

                                // Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
                                //$temp = explode(' ', $don_hang_khach_hang->ten_khach_hang);
                                //$don_hang_khach_hang->ten_khach_hang = $temp[count($temp) - 1];
                            }

                            return view('don_hang_khach_hang')->with('list_chuc_nang', Session::get('list_chuc_nang_ban_hang'))
                                                              ->with('list_khach_hang', Session::get('list_khach_hang'))
                                                              ->with('tong_so_don_hang_khach_hang_theo_tinh_trang', Session::get('tong_so_don_hang_khach_hang_theo_tinh_trang'))
                                                              ->with('listDonHangKhachHang', $listDonHangKhachHang_ChuaHoanThanh_Moi)
                                                              ->with('showButtonXoa', Session::get('showButtonXoa'));
                        }
                        else if (Session::has('truong_hop_button_xem_tat_ca_don_hang_khach_hang'))  // Trường hợp: đã click trên chuỗi button phân trang, của button "Xem tất cả đơn hàng"
                        {
                            // Lấy danh sách đơn hàng khách hàng
                            $listDonHangKhachHang = $donHangKhachHangRepository->getDanhSachDonHangKhachHang();

                            // Tính "tổng số mét đã giao" của từng đơn hàng khách hàng ; Format cho "Hạn chót" và "Ngày giờ đặt hàng" ; Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
                            foreach ($listDonHangKhachHang as $don_hang_khach_hang)
                            {
                                // Tính "tổng số mét đã giao" của từng đơn hàng khách hàng
                                $don_hang_khach_hang->tong_so_met_da_giao = $hoaDonXuatRepository->tinhTongSoMetDaGiaoCuaDonHangKhachHang($don_hang_khach_hang->id);

                                // Format cho "Hạn chót" và "Ngày giờ đặt hàng"
                                if ($don_hang_khach_hang->han_chot != null)
                                {
                                    $don_hang_khach_hang->han_chot = date('d/m/Y', strtotime($don_hang_khach_hang->han_chot));
                                }
                                $don_hang_khach_hang->ngay_gio_dat_hang = date('d/m/Y H:i:s', strtotime($don_hang_khach_hang->ngay_gio_dat_hang));

                                // Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
                                //$temp = explode(' ', $don_hang_khach_hang->ten_khach_hang);
                                //$don_hang_khach_hang->ten_khach_hang = $temp[count($temp) - 1];
                            }

                            return view('don_hang_khach_hang')->with('list_chuc_nang', Session::get('list_chuc_nang_ban_hang'))
                                                              ->with('list_khach_hang', Session::get('list_khach_hang'))
                                                              ->with('tong_so_don_hang_khach_hang_theo_tinh_trang', Session::get('tong_so_don_hang_khach_hang_theo_tinh_trang'))
                                                              ->with('listDonHangKhachHang', $listDonHangKhachHang)
                                                              ->with('showButtonXoa', Session::get('showButtonXoa'))
                                                              ->with('xem_tat_ca_don_hang', Session::get('xem_tat_ca_don_hang_khach_hang'));
                        }
                        else if (Session::has('truong_hop_button_loc_don_hang_khach_hang'))     // Trường hợp: đã click trên chuỗi button phân trang, của button "Lọc"
                        {
                            // Lấy danh sách đơn hàng khách hàng "Chưa hoàn thành" / "Mới" của khách hàng mà user đã chọn
                            $listDonHangKhachHang_ChuaHoanThanh_Moi = $donHangKhachHangRepository->getDanhSachDonHangKhachHangChuaHoanThanh_Moi(Session::get('khach_hang_duoc_chon')->id);

                            // Tính "tổng số mét đã giao" của từng đơn hàng khách hàng ; Format cho "Hạn chót" và "Ngày giờ đặt hàng" ; Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
                            foreach ($listDonHangKhachHang_ChuaHoanThanh_Moi as $don_hang_khach_hang)
                            {
                                // Tính "tổng số mét đã giao" của từng đơn hàng khách hàng
                                $don_hang_khach_hang->tong_so_met_da_giao = $hoaDonXuatRepository->tinhTongSoMetDaGiaoCuaDonHangKhachHang($don_hang_khach_hang->id);

                                // Format cho "Hạn chót" và "Ngày giờ đặt hàng"
                                if ($don_hang_khach_hang->han_chot != null)
                                {
                                    $don_hang_khach_hang->han_chot = date('d/m/Y', strtotime($don_hang_khach_hang->han_chot));
                                }
                                $don_hang_khach_hang->ngay_gio_dat_hang = date('d/m/Y H:i:s', strtotime($don_hang_khach_hang->ngay_gio_dat_hang));

                                // Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
                                //$temp = explode(' ', $don_hang_khach_hang->ten_khach_hang);
                                //$don_hang_khach_hang->ten_khach_hang = $temp[count($temp) - 1];
                            }

                            return view('don_hang_khach_hang')->with('list_chuc_nang', Session::get('list_chuc_nang_ban_hang'))
                                                              ->with('list_khach_hang', Session::get('list_khach_hang'))
                                                              ->with('khach_hang_duoc_chon', Session::get('khach_hang_duoc_chon'))
                                                              ->with('tong_so_don_hang_khach_hang_theo_tinh_trang', Session::get('tong_so_don_hang_khach_hang_theo_tinh_trang'))
                                                              ->with('listDonHangKhachHang', $listDonHangKhachHang_ChuaHoanThanh_Moi)
                                                              ->with('showButtonXoa', Session::get('showButtonXoa'));
                        }
                        else    // Trường hợp: biến page trên URL do user tự nhập tay vào
                        {
                            return redirect()->to(route('route_get_don_hang_khach_hang'));
                        }
                    }
                    else    // Không có biến page trên URL hoặc không click trên chuỗi button phân trang
                    {
                        // Lấy danh sách chức năng tương ứng với quyền của user
                        $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_BAN_HANG);

                        // Lấy danh sách khách hàng
                        $khachHangRepository = new KhachHangRepository();
                        $list_khach_hang = $khachHangRepository->getDanhSachKhachHang();
                        // Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
                        /*foreach ($list_khach_hang as $khach_hang)
                        {
                            $temp = explode(' ', $khach_hang->ho_ten);
                            $khach_hang->ho_ten = $temp[count($temp) - 1];
                        }*/

                        // Lấy danh sách đơn hàng khách hàng "Chưa hoàn thành" / "Mới"
                        $listDonHangKhachHang_ChuaHoanThanh_Moi = $donHangKhachHangRepository->getDanhSachDonHangKhachHangChuaHoanThanh_Moi();

                        if (count($listDonHangKhachHang_ChuaHoanThanh_Moi) == 0)
                        {
                            // Xóa tất cả các Session do trường hợp button "Xem tất cả đơn hàng" hoặc button "Lọc" thiết lập ra
                            Session::forget('list_chuc_nang_ban_hang');
                            Session::forget('list_khach_hang');
                            Session::forget('tong_so_don_hang_khach_hang_theo_tinh_trang');
                            Session::forget('showButtonXoa');
                            Session::forget('xem_tat_ca_don_hang_khach_hang');
                            Session::forget('truong_hop_button_xem_tat_ca_don_hang_khach_hang');
                            Session::forget('khach_hang_duoc_chon');
                            Session::forget('truong_hop_button_loc_don_hang_khach_hang');
                            Session::forget('truong_hop_truy_cap_bang_url_don_hang_khach_hang');

                            $message = 'Không có đơn hàng khách hàng "mới" hoặc "chưa hoàn thành" nào để hiển thị !';

                            return view('don_hang_khach_hang')->with('list_chuc_nang', $list_chuc_nang)
                                                              ->with('list_khach_hang', $list_khach_hang)
                                                              ->with('message', $message);
                        }

                        // Tính "tổng số mét đã giao" của từng đơn hàng khách hàng ; Format cho "Hạn chót" và "Ngày giờ đặt hàng" ; Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
                        foreach ($listDonHangKhachHang_ChuaHoanThanh_Moi as $don_hang_khach_hang)
                        {
                            // Tính "tổng số mét đã giao" của từng đơn hàng khách hàng
                            $don_hang_khach_hang->tong_so_met_da_giao = $hoaDonXuatRepository->tinhTongSoMetDaGiaoCuaDonHangKhachHang($don_hang_khach_hang->id);

                            // Format cho "Hạn chót" và "Ngày giờ đặt hàng"
                            if ($don_hang_khach_hang->han_chot != null)
                            {
                                $don_hang_khach_hang->han_chot = date('d/m/Y', strtotime($don_hang_khach_hang->han_chot));
                            }
                            $don_hang_khach_hang->ngay_gio_dat_hang = date('d/m/Y H:i:s', strtotime($don_hang_khach_hang->ngay_gio_dat_hang));

                            // Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
                            //$temp = explode(' ', $don_hang_khach_hang->ten_khach_hang);
                            //$don_hang_khach_hang->ten_khach_hang = $temp[count($temp) - 1];
                        }

                        // Lấy tổng số đơn hàng khách hàng theo tình trạng: "Mới" / "Chưa hoàn thành" / "Hoàn thành"
                        $tong_so_don_hang_khach_hang_theo_tinh_trang = $donHangKhachHangRepository->demTongSoDonHangKhachHangTheoTinhTrang();

                        // Thiết lập việc có show button Xóa hay không
                        $showButtonXoa = false;
                        if (Session::get('quyen') == self::QUYEN_ADMIN)
                        {
                            $showButtonXoa = true;
                        }

                        // Xóa tất cả các Session do trường hợp button "Xem tất cả đơn hàng" hoặc button "Lọc" thiết lập ra
                        Session::forget('list_chuc_nang_ban_hang');
                        Session::forget('list_khach_hang');
                        Session::forget('tong_so_don_hang_khach_hang_theo_tinh_trang');
                        Session::forget('showButtonXoa');
                        Session::forget('xem_tat_ca_don_hang_khach_hang');
                        Session::forget('truong_hop_button_xem_tat_ca_don_hang_khach_hang');
                        Session::forget('khach_hang_duoc_chon');
                        Session::forget('truong_hop_button_loc_don_hang_khach_hang');

                        // Thiết lập Session để hỗ trợ cho việc phân trang
                        Session::put('list_chuc_nang_ban_hang', $list_chuc_nang);
                        Session::put('list_khach_hang', $list_khach_hang);
                        Session::put('tong_so_don_hang_khach_hang_theo_tinh_trang', $tong_so_don_hang_khach_hang_theo_tinh_trang);
                        Session::put('showButtonXoa', $showButtonXoa);
                        Session::put('truong_hop_truy_cap_bang_url_don_hang_khach_hang', 'true');

                        return view('don_hang_khach_hang')->with('list_chuc_nang', $list_chuc_nang)
                                                          ->with('list_khach_hang', $list_khach_hang)
                                                          ->with('tong_so_don_hang_khach_hang_theo_tinh_trang', $tong_so_don_hang_khach_hang_theo_tinh_trang)
                                                          ->with('listDonHangKhachHang', $listDonHangKhachHang_ChuaHoanThanh_Moi)
                                                          ->with('showButtonXoa', $showButtonXoa);
                    }
            }
        }

        // Chưa Login
        return redirect()->to(route('route_get_login_he_thong'));
    }

    public function postDonHangKhachHang(Request $request)
    {
        // Lấy danh sách chức năng tương ứng với quyền của user
        $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_BAN_HANG);

        // Lấy danh sách khách hàng
        $khachHangRepository = new KhachHangRepository();
        $list_khach_hang = $khachHangRepository->getDanhSachKhachHang();
        // Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
        /*foreach ($list_khach_hang as $khach_hang)
        {
            $temp = explode(' ', $khach_hang->ho_ten);
            $khach_hang->ho_ten = $temp[count($temp) - 1];
        }*/

        // Thiết lập việc có show button Xóa hay không
        $showButtonXoa = false;
        if (Session::get('quyen') == self::QUYEN_ADMIN)
        {
            $showButtonXoa = true;
        }

        // Tạo đối tượng DonHangKhachHangRepository và HoaDonXuatRepository
        $donHangKhachHangRepository = new DonHangKhachHangRepository();
        $hoaDonXuatRepository = new HoaDonXuatRepository();

        // Button "Xóa" được click
        if ($request->get('xoa') == 'true')
        {
            // Lấy danh sách id đơn hàng khách hàng muốn xóa
            $list_id_don_hang_khach_hang_muon_xoa = $request->get('list_id_don_hang_khach_hang_muon_xoa');
            // Xóa các đơn hàng khách hàng
            $donHangKhachHangRepository->deleteCacDonHangKhachHang($list_id_don_hang_khach_hang_muon_xoa);
        }

        // Truy cập bằng URL / Button "Xem tất cả đơn hàng" được click / Button "Lọc" được click
        if ($request->get('loc_theo_khach_hang') == 'false' && $request->get('xem_tat_ca_don_hang') == 'false')    // Truy cập bằng URL
        {
            // Lấy danh sách đơn hàng khách hàng "Chưa hoàn thành" / "Mới"
            $listDonHangKhachHang_ChuaHoanThanh_Moi = $donHangKhachHangRepository->getDanhSachDonHangKhachHangChuaHoanThanh_Moi();

            if (count($listDonHangKhachHang_ChuaHoanThanh_Moi) == 0)
            {
                // Xóa tất cả các Session do trường hợp button "Xem tất cả đơn hàng" hoặc button "Lọc" thiết lập ra
                Session::forget('list_chuc_nang_ban_hang');
                Session::forget('list_khach_hang');
                Session::forget('tong_so_don_hang_khach_hang_theo_tinh_trang');
                Session::forget('showButtonXoa');
                Session::forget('xem_tat_ca_don_hang_khach_hang');
                Session::forget('truong_hop_button_xem_tat_ca_don_hang_khach_hang');
                Session::forget('khach_hang_duoc_chon');
                Session::forget('truong_hop_button_loc_don_hang_khach_hang');
                Session::forget('truong_hop_truy_cap_bang_url_don_hang_khach_hang');

                $message = 'Không có đơn hàng khách hàng "mới" hoặc "chưa hoàn thành" nào để hiển thị !';

                return view('don_hang_khach_hang')->with('list_chuc_nang', $list_chuc_nang)
                                                  ->with('list_khach_hang', $list_khach_hang)
                                                  ->with('message', $message);
            }

            // Tính "tổng số mét đã giao" của từng đơn hàng khách hàng ; Format cho "Hạn chót" và "Ngày giờ đặt hàng" ; Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
            foreach ($listDonHangKhachHang_ChuaHoanThanh_Moi as $don_hang_khach_hang)
            {
                // Tính "tổng số mét đã giao" của từng đơn hàng khách hàng
                $don_hang_khach_hang->tong_so_met_da_giao = $hoaDonXuatRepository->tinhTongSoMetDaGiaoCuaDonHangKhachHang($don_hang_khach_hang->id);

                // Format cho "Hạn chót" và "Ngày giờ đặt hàng"
                if ($don_hang_khach_hang->han_chot != null)
                {
                    $don_hang_khach_hang->han_chot = date('d/m/Y', strtotime($don_hang_khach_hang->han_chot));
                }
                $don_hang_khach_hang->ngay_gio_dat_hang = date('d/m/Y H:i:s', strtotime($don_hang_khach_hang->ngay_gio_dat_hang));

                // Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
                //$temp = explode(' ', $don_hang_khach_hang->ten_khach_hang);
                //$don_hang_khach_hang->ten_khach_hang = $temp[count($temp) - 1];
            }

            // Lấy tổng số đơn hàng khách hàng theo tình trạng: "Mới" / "Chưa hoàn thành" / "Hoàn thành"
            $tong_so_don_hang_khach_hang_theo_tinh_trang = $donHangKhachHangRepository->demTongSoDonHangKhachHangTheoTinhTrang();

            // Xóa tất cả các Session do trường hợp button "Xem tất cả đơn hàng" hoặc button "Lọc" thiết lập ra
            Session::forget('list_chuc_nang_ban_hang');
            Session::forget('list_khach_hang');
            Session::forget('tong_so_don_hang_khach_hang_theo_tinh_trang');
            Session::forget('showButtonXoa');
            Session::forget('xem_tat_ca_don_hang_khach_hang');
            Session::forget('truong_hop_button_xem_tat_ca_don_hang_khach_hang');
            Session::forget('khach_hang_duoc_chon');
            Session::forget('truong_hop_button_loc_don_hang_khach_hang');

            // Thiết lập Session để hỗ trợ cho việc phân trang
            Session::put('list_chuc_nang_ban_hang', $list_chuc_nang);
            Session::put('list_khach_hang', $list_khach_hang);
            Session::put('tong_so_don_hang_khach_hang_theo_tinh_trang', $tong_so_don_hang_khach_hang_theo_tinh_trang);
            Session::put('showButtonXoa', $showButtonXoa);
            Session::put('truong_hop_truy_cap_bang_url_don_hang_khach_hang', 'true');

            return view('don_hang_khach_hang')->with('list_chuc_nang', $list_chuc_nang)
                                              ->with('list_khach_hang', $list_khach_hang)
                                              ->with('tong_so_don_hang_khach_hang_theo_tinh_trang', $tong_so_don_hang_khach_hang_theo_tinh_trang)
                                              ->with('listDonHangKhachHang', $listDonHangKhachHang_ChuaHoanThanh_Moi)
                                              ->with('showButtonXoa', $showButtonXoa);
        }
        else if ($request->get('loc_theo_khach_hang') == 'false' && $request->get('xem_tat_ca_don_hang') == 'true')    // Button "Xem tất cả đơn hàng" được click
        {
            // Lấy danh sách đơn hàng khách hàng
            $listDonHangKhachHang = $donHangKhachHangRepository->getDanhSachDonHangKhachHang();

            // Tính "tổng số mét đã giao" của từng đơn hàng khách hàng ; Format cho "Hạn chót" và "Ngày giờ đặt hàng" ; Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
            foreach ($listDonHangKhachHang as $don_hang_khach_hang)
            {
                // Tính "tổng số mét đã giao" của từng đơn hàng khách hàng
                $don_hang_khach_hang->tong_so_met_da_giao = $hoaDonXuatRepository->tinhTongSoMetDaGiaoCuaDonHangKhachHang($don_hang_khach_hang->id);

                // Format cho "Hạn chót" và "Ngày giờ đặt hàng"
                if ($don_hang_khach_hang->han_chot != null)
                {
                    $don_hang_khach_hang->han_chot = date('d/m/Y', strtotime($don_hang_khach_hang->han_chot));
                }
                $don_hang_khach_hang->ngay_gio_dat_hang = date('d/m/Y H:i:s', strtotime($don_hang_khach_hang->ngay_gio_dat_hang));

                // Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
                //$temp = explode(' ', $don_hang_khach_hang->ten_khach_hang);
                //$don_hang_khach_hang->ten_khach_hang = $temp[count($temp) - 1];
            }

            // Lấy tổng số đơn hàng khách hàng theo tình trạng: "Mới" / "Chưa hoàn thành" / "Hoàn thành"
            $tong_so_don_hang_khach_hang_theo_tinh_trang = $donHangKhachHangRepository->demTongSoDonHangKhachHangTheoTinhTrang();

            // Xóa tất cả các Session do trường hợp "Truy cập bằng URL" hoặc button "Lọc" thiết lập ra
            Session::forget('list_chuc_nang_ban_hang');
            Session::forget('list_khach_hang');
            Session::forget('tong_so_don_hang_khach_hang_theo_tinh_trang');
            Session::forget('showButtonXoa');
            Session::forget('truong_hop_truy_cap_bang_url_don_hang_khach_hang');
            Session::forget('khach_hang_duoc_chon');
            Session::forget('truong_hop_button_loc_don_hang_khach_hang');

            // Thiết lập Session để hỗ trợ cho việc phân trang
            Session::put('list_chuc_nang_ban_hang', $list_chuc_nang);
            Session::put('list_khach_hang', $list_khach_hang);
            Session::put('tong_so_don_hang_khach_hang_theo_tinh_trang', $tong_so_don_hang_khach_hang_theo_tinh_trang);
            Session::put('showButtonXoa', $showButtonXoa);
            Session::put('xem_tat_ca_don_hang_khach_hang', 'true');
            Session::put('truong_hop_button_xem_tat_ca_don_hang_khach_hang', 'true');

            return view('don_hang_khach_hang')->with('list_chuc_nang', $list_chuc_nang)
                                              ->with('list_khach_hang', $list_khach_hang)
                                              ->with('tong_so_don_hang_khach_hang_theo_tinh_trang', $tong_so_don_hang_khach_hang_theo_tinh_trang)
                                              ->with('listDonHangKhachHang', $listDonHangKhachHang)
                                              ->with('showButtonXoa', $showButtonXoa)
                                              ->with('xem_tat_ca_don_hang', 'true');
        }
        else if ($request->get('loc_theo_khach_hang') == 'true' && $request->get('xem_tat_ca_don_hang') == 'false')    // Button "Lọc" được click
        {
            // Id khách hàng mà user đã chọn
            $id_khach_hang = (int)($request->get('idKhachHang'));

            // Lấy khách hàng mà user đã chọn
            $khach_hang_duoc_chon = $khachHangRepository->getKhachHangById($id_khach_hang);
            // Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
            /*$temp = explode(' ', $khach_hang_duoc_chon->ho_ten);
            $khach_hang_duoc_chon->ho_ten = $temp[count($temp) - 1];*/

            // Lấy danh sách đơn hàng khách hàng "Chưa hoàn thành" / "Mới" của khách hàng mà user đã chọn
            $listDonHangKhachHang_ChuaHoanThanh_Moi = $donHangKhachHangRepository->getDanhSachDonHangKhachHangChuaHoanThanh_Moi($id_khach_hang);

            if (count($listDonHangKhachHang_ChuaHoanThanh_Moi) == 0)
            {
                // Xóa tất cả các Session do trường hợp "Truy cập bằng URL" hoặc button "Xem tất cả đơn hàng" thiết lập ra
                Session::forget('list_chuc_nang_ban_hang');
                Session::forget('list_khach_hang');
                Session::forget('tong_so_don_hang_khach_hang_theo_tinh_trang');
                Session::forget('showButtonXoa');
                Session::forget('truong_hop_truy_cap_bang_url_don_hang_khach_hang');
                Session::forget('xem_tat_ca_don_hang_khach_hang');
                Session::forget('truong_hop_button_xem_tat_ca_don_hang_khach_hang');
                Session::forget('khach_hang_duoc_chon');
                Session::forget('truong_hop_button_loc_don_hang_khach_hang');

                $message = 'Khách hàng '.$khach_hang_duoc_chon->ho_ten.' không có đơn hàng nào hoặc tất cả đơn hàng của khách hàng này đều đã được hoàn thành !';

                return view('don_hang_khach_hang')->with('list_chuc_nang', $list_chuc_nang)
                                                  ->with('list_khach_hang', $list_khach_hang)
                                                  ->with('khach_hang_duoc_chon', $khach_hang_duoc_chon)
                                                  ->with('message', $message);
            }

            // Tính "tổng số mét đã giao" của từng đơn hàng khách hàng ; Format cho "Hạn chót" và "Ngày giờ đặt hàng" ; Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
            foreach ($listDonHangKhachHang_ChuaHoanThanh_Moi as $don_hang_khach_hang)
            {
                // Tính "tổng số mét đã giao" của từng đơn hàng khách hàng
                $don_hang_khach_hang->tong_so_met_da_giao = $hoaDonXuatRepository->tinhTongSoMetDaGiaoCuaDonHangKhachHang($don_hang_khach_hang->id);

                // Format cho "Hạn chót" và "Ngày giờ đặt hàng"
                if ($don_hang_khach_hang->han_chot != null)
                {
                    $don_hang_khach_hang->han_chot = date('d/m/Y', strtotime($don_hang_khach_hang->han_chot));
                }
                $don_hang_khach_hang->ngay_gio_dat_hang = date('d/m/Y H:i:s', strtotime($don_hang_khach_hang->ngay_gio_dat_hang));

                // Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
                //$temp = explode(' ', $don_hang_khach_hang->ten_khach_hang);
                //$don_hang_khach_hang->ten_khach_hang = $temp[count($temp) - 1];
            }

            // Lấy tổng số đơn hàng khách hàng theo tình trạng: "Mới" / "Chưa hoàn thành" / "Hoàn thành" mà tương ứng với khách hàng mà user đã chọn
            $tong_so_don_hang_khach_hang_theo_tinh_trang = $donHangKhachHangRepository->demTongSoDonHangKhachHangTheoTinhTrang($id_khach_hang);

            // Xóa tất cả các Session do trường hợp "Truy cập bằng URL" hoặc button "Xem tất cả đơn hàng" thiết lập ra
            Session::forget('list_chuc_nang_ban_hang');
            Session::forget('list_khach_hang');
            Session::forget('tong_so_don_hang_khach_hang_theo_tinh_trang');
            Session::forget('showButtonXoa');
            Session::forget('truong_hop_truy_cap_bang_url_don_hang_khach_hang');
            Session::forget('xem_tat_ca_don_hang_khach_hang');
            Session::forget('truong_hop_button_xem_tat_ca_don_hang_khach_hang');

            // Thiết lập Session để hỗ trợ cho việc phân trang
            Session::put('list_chuc_nang_ban_hang', $list_chuc_nang);
            Session::put('list_khach_hang', $list_khach_hang);
            Session::put('khach_hang_duoc_chon', $khach_hang_duoc_chon);
            Session::put('tong_so_don_hang_khach_hang_theo_tinh_trang', $tong_so_don_hang_khach_hang_theo_tinh_trang);
            Session::put('showButtonXoa', $showButtonXoa);
            Session::put('truong_hop_button_loc_don_hang_khach_hang', 'true');

            return view('don_hang_khach_hang')->with('list_chuc_nang', $list_chuc_nang)
                                              ->with('list_khach_hang', $list_khach_hang)
                                              ->with('khach_hang_duoc_chon', $khach_hang_duoc_chon)
                                              ->with('tong_so_don_hang_khach_hang_theo_tinh_trang', $tong_so_don_hang_khach_hang_theo_tinh_trang)
                                              ->with('listDonHangKhachHang', $listDonHangKhachHang_ChuaHoanThanh_Moi)
                                              ->with('showButtonXoa', $showButtonXoa);
        }
    }

    public function getThemDonHangKhachHang()
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

                    // Lấy "id đơn hàng khách hàng cuối cùng" trong database
                    $donHangKhachHangRepository = new DonHangKhachHangRepository();
                    $id_don_hang_khach_hang_cuoi_cung = $donHangKhachHangRepository->getIdDonHangKhachHangCuoiCung();

                    // Lấy danh sách khách hàng
                    $khachHangRepository = new KhachHangRepository();
                    $list_khach_hang = $khachHangRepository->getDanhSachKhachHang();
                    // Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
                    /*foreach ($list_khach_hang as $khach_hang)
                    {
                        $temp = explode(' ', $khach_hang->ho_ten);
                        $khach_hang->ho_ten = $temp[count($temp) - 1];
                    }*/

                    // Lấy danh sách loại vải
                    $loaiVaiRepository = new LoaiVaiRepository();
                    $list_loai_vai = $loaiVaiRepository->getDanhSachLoaiVai();

                    // Lấy danh sách màu
                    $mauRepository = new MauRepository();
                    $list_mau = $mauRepository->getDanhSachMau();

                    // Lấy danh sách khổ
                    $list_kho = $this->kho;

                    return view('them_don_hang_khach_hang')->with('list_chuc_nang', $list_chuc_nang)
                                                           ->with('id_don_hang_khach_hang_cuoi_cung', $id_don_hang_khach_hang_cuoi_cung)
                                                           ->with('list_khach_hang', $list_khach_hang)
                                                           ->with('list_loai_vai', $list_loai_vai)
                                                           ->with('list_mau', $list_mau)
                                                           ->with('list_kho', $list_kho);
            }
        }

        // Chưa Login
        return redirect()->to(route('route_get_login_he_thong'));
    }

    public function postThemDonHangKhachHang(ThemDonHangKhachHangRequest $request)
    {
        // Validate trường hợp: Hạn chót <= Ngày giờ đặt hàng
        $han_chot = $request->get('han_chot');
        if ($han_chot != '')
        {
            $han_chot = strtotime($han_chot);
            $ngay_gio_dat_hang = $request->get('ngay_gio_dat_hang');
            $ngay_gio_dat_hang = strtotime($ngay_gio_dat_hang);

            if ($han_chot <= $ngay_gio_dat_hang)
            {
                $errorMessage = 'Hạn chót phải sau ngày giờ đặt hàng !';

                // Tạo thủ công Validation error messages
                $validator = Validator::make($request->all(), array(), array());
                $errors = $validator->errors();
                $errors->add('HanChot_NgayGioDatHang', $errorMessage);

                return redirect(URL::previous())->withErrors($errors)
                                                ->withInput();
            }
        }

        // Validate successful
        // Thêm đơn hàng khách hàng
        $donHangKhachHangRepository = new DonHangKhachHangRepository();
        $donHangKhachHangRepository->themDonHangKhachHang($request);

        // Redirect về trang Thêm đơn hàng khách hàng
        return redirect()->to(route('route_get_them_don_hang_khach_hang'));
    }

    public function getCapNhatDonHangKhachHang($id_don_hang_khach_hang = null)
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

    public function postCapNhatDonHangKhachHang(Request $request, $id_don_hang_khach_hang)
    {
        
    }
}
