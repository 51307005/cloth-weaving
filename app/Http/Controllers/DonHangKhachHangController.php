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
use App\Http\Repositories\ThuChiRepository;

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

                    // Tạo đối tượng DonHangKhachHangRepository
                    $donHangKhachHangRepository = new DonHangKhachHangRepository();

                    // Lấy danh sách id đơn hàng khách hàng
                    $list_id_don_hang_khach_hang = $donHangKhachHangRepository->getDanhSachIdDonHangKhachHang();

                    if ($id_don_hang_khach_hang == null)   // $id_don_hang_khach_hang không được truyền
                    {
                        return view('cap_nhat_don_hang_khach_hang')->with('list_chuc_nang', $list_chuc_nang)
                                                                   ->with('list_id_don_hang_khach_hang', $list_id_don_hang_khach_hang);
                    }
                    else    // $id_don_hang_khach_hang được truyền
                    {
                        $errorMessage = '';

                        if (ctype_digit($id_don_hang_khach_hang) == true && (int)($id_don_hang_khach_hang) > 0)   // $id_don_hang_khach_hang là số nguyên dương
                        {
                            $hopLe = false;

                            // Ép kiểu $id_don_hang_khach_hang về kiểu int
                            $id_don_hang_khach_hang = (int)$id_don_hang_khach_hang;

                            // Kiểm tra xem $id_don_hang_khach_hang có tồn tại trong database hay không
                            foreach ($list_id_don_hang_khach_hang as $don_hang_khach_hang)
                            {
                                if ($id_don_hang_khach_hang == $don_hang_khach_hang->id)
                                {
                                    $hopLe = true;
                                    break;
                                }
                            }

                            if ($hopLe == true)
                            {
                                // Lấy đơn hàng khách hàng mà user đã chọn
                                $don_hang_khach_hang_duoc_chon = $donHangKhachHangRepository->getDonHangKhachHangById($id_don_hang_khach_hang);
                                // Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
                                /*$temp = explode(' ', $don_hang_khach_hang_duoc_chon->ten_khach_hang);
                                $don_hang_khach_hang_duoc_chon->ten_khach_hang = $temp[count($temp) - 1];*/
                                $don_hang_khach_hang_duoc_chon_json = json_encode($don_hang_khach_hang_duoc_chon);

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

                                return view('cap_nhat_don_hang_khach_hang')->with('list_chuc_nang', $list_chuc_nang)
                                                                           ->with('list_id_don_hang_khach_hang', $list_id_don_hang_khach_hang)
                                                                           ->with('don_hang_khach_hang_duoc_chon', $don_hang_khach_hang_duoc_chon)
                                                                           ->with('don_hang_khach_hang_cu', $don_hang_khach_hang_duoc_chon_json)
                                                                           ->with('list_khach_hang', $list_khach_hang)
                                                                           ->with('list_loai_vai', $list_loai_vai)
                                                                           ->with('list_mau', $list_mau)
                                                                           ->with('list_kho', $list_kho);
                            }
                            else
                            {
                                $errorMessage = 'Id đơn hàng khách hàng không tồn tại trong database !';

                                return view('cap_nhat_don_hang_khach_hang')->with('list_chuc_nang', $list_chuc_nang)
                                                                           ->with('list_id_don_hang_khach_hang', $list_id_don_hang_khach_hang)
                                                                           ->with('errorMessage', $errorMessage);
                            }
                        }
                        else    // $id_don_hang_khach_hang không phải là số nguyên dương
                        {
                            $errorMessage = 'Id đơn hàng khách hàng phải là số nguyên dương !';

                            return view('cap_nhat_don_hang_khach_hang')->with('list_chuc_nang', $list_chuc_nang)
                                                                       ->with('list_id_don_hang_khach_hang', $list_id_don_hang_khach_hang)
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
        // Tạo đối tượng DonHangKhachHangRepository, KhachHangRepository, LoaiVaiRepository và MauRepository
        $donHangKhachHangRepository = new DonHangKhachHangRepository();
        $khachHangRepository = new KhachHangRepository();
        $loaiVaiRepository = new LoaiVaiRepository();
        $mauRepository = new MauRepository();

        $id_don_hang_khach_hang = (int)($request->get('IdDonHangKhachHang'));

        if (!$request->has('frm_chon_ma_don_hang_khach_hang'))  // Button "Cập nhật" được click
        {
            // Validate fields
            $rules = [
                'tong_so_met' => 'required|integer|min:1',
                'han_chot' => 'date',
                'ngay_gio_dat_hang' => 'required|date'
            ];
            $messages = [
                'tong_so_met.required' => 'Bạn chưa nhập tổng số mét !',
                'tong_so_met.integer' => 'Tổng số mét phải là số nguyên dương !',
                'tong_so_met.min' => 'Tổng số mét ít nhất phải là 1 !',
                'han_chot.date' => 'Hạn chót không hợp lệ !',
                'ngay_gio_dat_hang.required' => 'Bạn chưa nhập ngày giờ đặt hàng !',
                'ngay_gio_dat_hang.date' => 'Ngày giờ đặt hàng không hợp lệ !'
            ];
            $this->validate($request, $rules, $messages);

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
            // Xử lý cập nhật đơn hàng khách hàng
            $donHangKhachHangRepository->capNhatDonHangKhachHang($request);

            // Tạo đối tượng HoaDonXuatRepository và ThuChiRepository
            $hoaDonXuatRepository = new HoaDonXuatRepository();
            $thuChiRepository = new ThuChiRepository();

            $id_don_hang_khach_hang = (int)($request->get('idDonHangKhachHang'));
            $id_khach_hang_moi = (int)($request->get('id_khach_hang'));
            $id_loai_vai = (int)($request->get('id_loai_vai'));
            $id_mau = (int)($request->get('id_mau'));
            $kho = (float)($request->get('kho'));

            // Update lại Tình trạng của Đơn hàng khách hàng
            $tong_so_met_da_giao = $hoaDonXuatRepository->tinhTongSoMetDaGiaoCuaDonHangKhachHang($id_don_hang_khach_hang);
            $donHangKhachHangRepository->updateTinhTrangDonHangKhachHang($id_don_hang_khach_hang, $tong_so_met_da_giao);

            // Update lại id_khach_hang, id_loai_vai, id_mau, khổ cho các Hóa đơn xuất mà thuộc Đơn hàng khách hàng đang được cập nhật
            $hoaDonXuatRepository->updateKhachHang_LoaiVai_Mau_KhoChoCacHoaDonXuatThuocDonHangKhachHang($id_don_hang_khach_hang, $id_khach_hang_moi, $id_loai_vai, $id_mau, $kho);

            // Lấy đơn hàng khách hàng cũ (trước khi cập nhật)
            $don_hang_khach_hang_cu = $request->get('don_hang_khach_hang_cu');
            $don_hang_khach_hang_cu = json_decode($don_hang_khach_hang_cu);
            $id_khach_hang_cu = $don_hang_khach_hang_cu->id_khach_hang;

            // Update lại Công nợ của Khách hàng cũ và Khách hàng mới
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

            //echo "<script> alert('Cập nhật thành công !'); </script>";
        }

        // Lấy danh sách chức năng tương ứng với quyền của user
        $list_chuc_nang = $this->taoLinkChoListChucNang(self::QUYEN_BAN_HANG);

        // Lấy danh sách id đơn hàng khách hàng
        $list_id_don_hang_khach_hang = $donHangKhachHangRepository->getDanhSachIdDonHangKhachHang();

        // Lấy đơn hàng khách hàng mà user đã chọn
        $don_hang_khach_hang_duoc_chon = $donHangKhachHangRepository->getDonHangKhachHangById($id_don_hang_khach_hang);
        // Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
        /*$temp = explode(' ', $don_hang_khach_hang_duoc_chon->ten_khach_hang);
        $don_hang_khach_hang_duoc_chon->ten_khach_hang = $temp[count($temp) - 1];*/
        $don_hang_khach_hang_duoc_chon_json = json_encode($don_hang_khach_hang_duoc_chon);

        // Lấy danh sách khách hàng
        $list_khach_hang = $khachHangRepository->getDanhSachKhachHang();
        // Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
        /*foreach ($list_khach_hang as $khach_hang)
        {
            $temp = explode(' ', $khach_hang->ho_ten);
            $khach_hang->ho_ten = $temp[count($temp) - 1];
        }*/

        // Lấy danh sách loại vải
        $list_loai_vai = $loaiVaiRepository->getDanhSachLoaiVai();

        // Lấy danh sách màu
        $list_mau = $mauRepository->getDanhSachMau();

        // Lấy danh sách khổ
        $list_kho = $this->kho;

        return view('cap_nhat_don_hang_khach_hang')->with('list_chuc_nang', $list_chuc_nang)
                                                   ->with('list_id_don_hang_khach_hang', $list_id_don_hang_khach_hang)
                                                   ->with('don_hang_khach_hang_duoc_chon', $don_hang_khach_hang_duoc_chon)
                                                   ->with('don_hang_khach_hang_cu', $don_hang_khach_hang_duoc_chon_json)
                                                   ->with('list_khach_hang', $list_khach_hang)
                                                   ->with('list_loai_vai', $list_loai_vai)
                                                   ->with('list_mau', $list_mau)
                                                   ->with('list_kho', $list_kho);
    }
}
