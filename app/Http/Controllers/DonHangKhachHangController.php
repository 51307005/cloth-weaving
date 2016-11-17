<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HelperController;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Repositories\KhachHangRepository;
use App\Http\Repositories\DonHangKhachHangRepository;
use App\Http\Repositories\HoaDonXuatRepository;

class DonHangKhachHangController extends HelperController
{
    public function getDonHangKhachHang()
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
                    // Chưa làm PHÂN TRANG
                    // Xử lý cho trường hợp phân trang
                    /*if ($request->has('page'))  // Có biến page trên URL
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
                            }/*

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
                            }/*

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
                            }/*

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
                    {*/
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

                        // Lấy tổng số đơn hàng khách hàng theo tình trạng: "Mới" / "Chưa hoàn thành" / "Hoàn thành"
                        $donHangKhachHangRepository = new DonHangKhachHangRepository();
                        $tong_so_don_hang_khach_hang_theo_tinh_trang = $donHangKhachHangRepository->demTongSoDonHangKhachHangTheoTinhTrang();

                        // Lấy danh sách đơn hàng khách hàng "Chưa hoàn thành" / "Mới"
                        $hoaDonXuatRepository = new HoaDonXuatRepository();
                        $listDonHangKhachHang_ChuaHoanThanh_Moi = $donHangKhachHangRepository->getDanhSachDonHangKhachHangChuaHoanThanh_Moi();
                        // Tính "tổng số mét đã giao" của từng đơn hàng khách hàng ; Format cho "Hạn chót" và "Ngày giờ đặt hàng" ; Xử lý chỉ lấy tên khách hàng chứ không lấy cả họ tên (nếu cần)
                        foreach ($listDonHangKhachHang_ChuaHoanThanh_Moi as $don_hang_khach_hang)
                        {
                            // Tính "tổng số mét đã giao" của từng đơn hàng khách hàng
                            if ($don_hang_khach_hang->tinh_trang == 'Mới')
                            {
                                $don_hang_khach_hang->tong_so_met_da_giao = 0;
                            }
                            else if ($don_hang_khach_hang->tinh_trang == 'Chưa hoàn thành')
                            {
                                $don_hang_khach_hang->tong_so_met_da_giao = $hoaDonXuatRepository->tinhTongSoMetDaGiaoCuaDonHangKhachHang($don_hang_khach_hang->id);
                            }

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

                        // Thiết lập việc có show button Xóa hay không
                        $showButtonXoa = false;
                        if (Session::get('quyen') == self::QUYEN_ADMIN)
                        {
                            $showButtonXoa = true;
                        }

                        return view('don_hang_khach_hang')->with('list_chuc_nang', $list_chuc_nang)
                                                          ->with('list_khach_hang', $list_khach_hang)
                                                          ->with('tong_so_don_hang_khach_hang_theo_tinh_trang', $tong_so_don_hang_khach_hang_theo_tinh_trang)
                                                          ->with('listDonHangKhachHang_ChuaHoanThanh_Moi', $listDonHangKhachHang_ChuaHoanThanh_Moi)
                                                          ->with('showButtonXoa', $showButtonXoa);
                    //}
            }
        }

        // Chưa Login
        return redirect()->to(route('route_get_login_he_thong'));
    }

    public function postDonHangKhachHang(Request $request)
    {
        
    }

    public function getThemDonHangKhachHang()
    {
        
    }

    public function postThemDonHangKhachHang(ThemPhieuXuatMocRequest $request)
    {
        
    }

    public function getCapNhatDonHangKhachHang($id_don_hang_khach_hang = null)
    {
        
    }

    public function postCapNhatDonHangKhachHang(Request $request, $id_don_hang_khach_hang)
    {
        
    }
}
