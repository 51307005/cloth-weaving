<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

////////// LOGIN //////////
Route::get('/login_he_thong', [
    'as' => 'route_get_login_he_thong',
    'uses' => 'QuanLyHeThongController@getLogin'
    ]);

Route::post('/login_he_thong', [
    'as' => 'route_post_login_he_thong',
    'uses' => 'QuanLyHeThongController@postLogin'
    ]);

Route::get('/logout_he_thong', [
    'as' => 'route_get_logout_he_thong',
    'uses' => 'QuanLyHeThongController@getLogout'
    ]);
////////// END LOGIN //////////

////////// PHÂN QUYỀN //////////
Route::get('/he_thong_quan_ly/manager', [
    'as' => 'route_get_trang_chu_manager',
    'uses' => 'ManagerController@getTrangChu'
    ]);

Route::get('/he_thong_quan_ly/san_xuat', [
    'as' => 'route_get_trang_chu_san_xuat',
    'uses' => 'SanXuatController@getTrangChu'
    ]);

Route::get('/he_thong_quan_ly/kho', [
    'as' => 'route_get_trang_chu_kho',
    'uses' => 'KhoController@getTrangChu'
    ]);

Route::get('/he_thong_quan_ly/ban_hang', [
    'as' => 'route_get_trang_chu_ban_hang',
    'uses' => 'BanHangController@getTrangChu'
    ]);
////////// END PHÂN QUYỀN //////////

////////// MỘC //////////
Route::get('/he_thong_quan_ly/kho/kho_moc', [
    'as' => 'route_get_kho_moc',
    'uses' => 'KhoMocController@getKhoMoc'
    ]);

Route::post('/he_thong_quan_ly/kho/kho_moc', [
    'as' => 'route_post_kho_moc',
    'uses' => 'KhoMocController@postKhoMoc'
    ]);

Route::get('/he_thong_quan_ly/kho/nhap_moc', [
    'as' => 'route_get_nhap_moc',
    'uses' => 'KhoMocController@getNhapMoc'
    ]);

Route::post('/he_thong_quan_ly/kho/nhap_moc', [
    'as' => 'route_post_nhap_moc',
    'uses' => 'KhoMocController@postNhapMoc'
    ]);

Route::get('/he_thong_quan_ly/kho/cap_nhat_cay_moc/{id_cay_moc?}', [
    'as' => 'route_get_cap_nhat_cay_moc',
    'uses' => 'KhoMocController@getCapNhatCayMoc'
    ]);

Route::post('/he_thong_quan_ly/kho/cap_nhat_cay_moc/{id_cay_moc}', [
    'as' => 'route_post_cap_nhat_cay_moc',
    'uses' => 'KhoMocController@postCapNhatCayMoc'
    ]);

Route::get('/he_thong_quan_ly/kho/phieu_xuat_moc', [
    'as' => 'route_get_phieu_xuat_moc',
    'uses' => 'KhoMocController@getPhieuXuatMoc'
    ]);

Route::post('/he_thong_quan_ly/kho/phieu_xuat_moc', [
    'as' => 'route_post_phieu_xuat_moc',
    'uses' => 'KhoMocController@postPhieuXuatMoc'
    ]);

Route::get('/he_thong_quan_ly/kho/them_phieu_xuat_moc', [
    'as' => 'route_get_them_phieu_xuat_moc',
    'uses' => 'KhoMocController@getThemPhieuXuatMoc'
    ]);

Route::post('/he_thong_quan_ly/kho/them_phieu_xuat_moc', [
    'as' => 'route_post_them_phieu_xuat_moc',
    'uses' => 'KhoMocController@postThemPhieuXuatMoc'
    ]);

Route::get('/he_thong_quan_ly/kho/cap_nhat_phieu_xuat_moc/{id_phieu_xuat_moc?}', [
    'as' => 'route_get_cap_nhat_phieu_xuat_moc',
    'uses' => 'KhoMocController@getCapNhatPhieuXuatMoc'
    ]);

Route::post('/he_thong_quan_ly/kho/cap_nhat_phieu_xuat_moc/{id_phieu_xuat_moc}', [
    'as' => 'route_post_cap_nhat_phieu_xuat_moc',
    'uses' => 'KhoMocController@postCapNhatPhieuXuatMoc'
    ]);

Route::get('/he_thong_quan_ly/kho/xuat_moc', [
    'as' => 'route_get_xuat_moc',
    'uses' => 'KhoMocController@getXuatMoc'
    ]);

Route::post('/he_thong_quan_ly/kho/xuat_moc', [
    'as' => 'route_post_xuat_moc',
    'uses' => 'KhoMocController@postXuatMoc'
    ]);

Route::get('/he_thong_quan_ly/kho/cap_nhat_xuat_moc/{id_phieu_xuat_moc?}', [
    'as' => 'route_get_cap_nhat_xuat_moc',
    'uses' => 'KhoMocController@getCapNhatXuatMoc'
    ]);

Route::post('/he_thong_quan_ly/kho/cap_nhat_xuat_moc/{id_phieu_xuat_moc}', [
    'as' => 'route_post_cap_nhat_xuat_moc',
    'uses' => 'KhoMocController@postCapNhatXuatMoc'
    ]);

Route::post('/he_thong_quan_ly/kho/show_thong_tin_cay_moc', [
    'as' => 'route_post_show_thong_tin_cay_moc',
    'uses' => 'KhoMocController@postShowThongTinCayMoc'
    ]);

Route::post('/he_thong_quan_ly/kho/show_lai_danh_sach_ma_cay_moc', [
    'as' => 'route_post_show_lai_danh_sach_ma_cay_moc',
    'uses' => 'KhoMocController@postShowLaiDanhSachMaCayMoc'
    ]);
////////// END MỘC //////////

////////// VẢI THÀNH PHẨM //////////
Route::get('/he_thong_quan_ly/kho/kho_thanh_pham', [
    'as' => 'route_get_kho_thanh_pham',
    'uses' => 'KhoThanhPhamController@getKhoThanhPham'
    ]);

Route::post('/he_thong_quan_ly/kho/kho_thanh_pham', [
    'as' => 'route_post_kho_thanh_pham',
    'uses' => 'KhoThanhPhamController@postKhoThanhPham'
    ]);

Route::get('/he_thong_quan_ly/kho/nhap_vai_thanh_pham', [
    'as' => 'route_get_nhap_vai_thanh_pham',
    'uses' => 'KhoThanhPhamController@getNhapVaiThanhPham'
    ]);

Route::post('/he_thong_quan_ly/kho/nhap_vai_thanh_pham', [
    'as' => 'route_post_nhap_vai_thanh_pham',
    'uses' => 'KhoThanhPhamController@postNhapVaiThanhPham'
    ]);

Route::get('/he_thong_quan_ly/kho/cap_nhat_cay_vai_thanh_pham/{id_cay_thanh_pham?}', [
    'as' => 'route_get_cap_nhat_cay_vai_thanh_pham',
    'uses' => 'KhoThanhPhamController@getCapNhatCayVaiThanhPham'
    ]);

Route::post('/he_thong_quan_ly/kho/cap_nhat_cay_vai_thanh_pham/{id_cay_thanh_pham}', [
    'as' => 'route_post_cap_nhat_cay_vai_thanh_pham',
    'uses' => 'KhoThanhPhamController@postCapNhatCayVaiThanhPham'
    ]);

Route::get('/he_thong_quan_ly/kho/xuat_vai_thanh_pham', [
    'as' => 'route_get_xuat_vai_thanh_pham',
    'uses' => 'KhoThanhPhamController@getXuatVaiThanhPham'
    ]);

Route::post('/he_thong_quan_ly/kho/xuat_vai_thanh_pham', [
    'as' => 'route_post_xuat_vai_thanh_pham',
    'uses' => 'KhoThanhPhamController@postXuatVaiThanhPham'
    ]);

Route::get('/he_thong_quan_ly/kho/cap_nhat_xuat_vai_thanh_pham/{id_hoa_don_xuat?}', [
    'as' => 'route_get_cap_nhat_xuat_vai_thanh_pham',
    'uses' => 'KhoThanhPhamController@getCapNhatXuatVaiThanhPham'
    ]);

Route::post('/he_thong_quan_ly/kho/cap_nhat_xuat_vai_thanh_pham/{id_hoa_don_xuat}', [
    'as' => 'route_post_cap_nhat_xuat_vai_thanh_pham',
    'uses' => 'KhoThanhPhamController@postCapNhatXuatVaiThanhPham'
    ]);

Route::get('/he_thong_quan_ly/ban_hang/hoa_don_xuat', [
    'as' => 'route_get_hoa_don_xuat',
    'uses' => 'KhoThanhPhamController@getHoaDonXuat'
    ]);

Route::post('/he_thong_quan_ly/ban_hang/hoa_don_xuat', [
    'as' => 'route_post_hoa_don_xuat',
    'uses' => 'KhoThanhPhamController@postHoaDonXuat'
    ]);

Route::get('/he_thong_quan_ly/ban_hang/them_hoa_don_xuat', [
    'as' => 'route_get_them_hoa_don_xuat',
    'uses' => 'KhoThanhPhamController@getThemHoaDonXuat'
    ]);

Route::post('/he_thong_quan_ly/ban_hang/them_hoa_don_xuat', [
    'as' => 'route_post_them_hoa_don_xuat',
    'uses' => 'KhoThanhPhamController@postThemHoaDonXuat'
    ]);

Route::get('/he_thong_quan_ly/ban_hang/cap_nhat_hoa_don_xuat/{id_hoa_don_xuat?}', [
    'as' => 'route_get_cap_nhat_hoa_don_xuat',
    'uses' => 'KhoThanhPhamController@getCapNhatHoaDonXuat'
    ]);

Route::post('/he_thong_quan_ly/ban_hang/cap_nhat_hoa_don_xuat/{id_hoa_don_xuat}', [
    'as' => 'route_post_cap_nhat_hoa_don_xuat',
    'uses' => 'KhoThanhPhamController@postCapNhatHoaDonXuat'
    ]);

Route::post('/he_thong_quan_ly/kho/show_loai_vai', [
    'as' => 'route_post_show_loai_vai',
    'uses' => 'KhoThanhPhamController@postShowLoaiVai'
    ]);

Route::post('/he_thong_quan_ly/kho/show_mau', [
    'as' => 'route_post_show_mau',
    'uses' => 'KhoThanhPhamController@postShowMau'
    ]);

Route::post('/he_thong_quan_ly/kho/show_thong_tin_cay_thanh_pham', [
    'as' => 'route_post_show_thong_tin_cay_thanh_pham',
    'uses' => 'KhoThanhPhamController@postShowThongTinCayThanhPham'
    ]);

Route::post('/he_thong_quan_ly/kho/show_lai_danh_sach_ma_cay_thanh_pham', [
    'as' => 'route_post_show_lai_danh_sach_ma_cay_thanh_pham',
    'uses' => 'KhoThanhPhamController@postShowLaiDanhSachMaCayThanhPham'
    ]);

Route::post('/he_thong_quan_ly/ban_hang/show_thong_tin_don_hang_khach_hang', [
    'as' => 'route_post_show_thong_tin_don_hang_khach_hang',
    'uses' => 'KhoThanhPhamController@postShowThongTinDonHangKhachHang'
    ]);
////////// END VẢI THÀNH PHẨM //////////

////////// ĐƠN HÀNG KHÁCH HÀNG //////////
Route::get('/he_thong_quan_ly/ban_hang/don_hang_khach_hang', [
    'as' => 'route_get_don_hang_khach_hang',
    'uses' => 'DonHangKhachHangController@getDonHangKhachHang'
    ]);

Route::post('/he_thong_quan_ly/ban_hang/don_hang_khach_hang', [
    'as' => 'route_post_don_hang_khach_hang',
    'uses' => 'DonHangKhachHangController@postDonHangKhachHang'
    ]);

Route::get('/he_thong_quan_ly/ban_hang/them_don_hang_khach_hang', [
    'as' => 'route_get_them_don_hang_khach_hang',
    'uses' => 'DonHangKhachHangController@getThemDonHangKhachHang'
    ]);

Route::post('/he_thong_quan_ly/ban_hang/them_don_hang_khach_hang', [
    'as' => 'route_post_them_don_hang_khach_hang',
    'uses' => 'DonHangKhachHangController@postThemDonHangKhachHang'
    ]);

Route::get('/he_thong_quan_ly/ban_hang/cap_nhat_don_hang_khach_hang/{id_don_hang_khach_hang?}', [
    'as' => 'route_get_cap_nhat_don_hang_khach_hang',
    'uses' => 'DonHangKhachHangController@getCapNhatDonHangKhachHang'
    ]);

Route::post('/he_thong_quan_ly/ban_hang/cap_nhat_don_hang_khach_hang/{id_don_hang_khach_hang}', [
    'as' => 'route_post_cap_nhat_don_hang_khach_hang',
    'uses' => 'DonHangKhachHangController@postCapNhatDonHangKhachHang'
    ]);
////////// END ĐƠN HÀNG KHÁCH HÀNG //////////

////////// KHÁCH HÀNG //////////
Route::get('/he_thong_quan_ly/ban_hang/khach_hang', [
    'as' => 'route_get_khach_hang',
    'uses' => 'KhachHangController@getKhachHang'
    ]);

Route::post('/he_thong_quan_ly/ban_hang/khach_hang', [
    'as' => 'route_post_khach_hang',
    'uses' => 'KhachHangController@postKhachHang'
    ]);

Route::get('/he_thong_quan_ly/ban_hang/them_khach_hang', [
    'as' => 'route_get_them_khach_hang',
    'uses' => 'KhachHangController@getThemKhachHang'
    ]);

Route::post('/he_thong_quan_ly/ban_hang/them_khach_hang', [
    'as' => 'route_post_them_khach_hang',
    'uses' => 'KhachHangController@postThemKhachHang'
    ]);

Route::get('/he_thong_quan_ly/ban_hang/cap_nhat_khach_hang/{id_khach_hang?}', [
    'as' => 'route_get_cap_nhat_khach_hang',
    'uses' => 'KhachHangController@getCapNhatKhachHang'
    ]);

Route::post('/he_thong_quan_ly/ban_hang/cap_nhat_khach_hang/{id_khach_hang}', [
    'as' => 'route_post_cap_nhat_khach_hang',
    'uses' => 'KhachHangController@postCapNhatKhachHang'
    ]);
////////// END KHÁCH HÀNG //////////

////////// LÔ NHUỘM //////////
Route::get('/he_thong_quan_ly/san_xuat/lo_nhuom', [
    'as' => 'route_get_lo_nhuom',
    'uses' => 'LoNhuomController@getLoNhuom'
    ]);

Route::post('/he_thong_quan_ly/san_xuat/lo_nhuom', [
    'as' => 'route_post_lo_nhuom',
    'uses' => 'LoNhuomController@postLoNhuom'
    ]);

Route::get('/he_thong_quan_ly/san_xuat/them_lo_nhuom', [
    'as' => 'route_get_them_lo_nhuom',
    'uses' => 'LoNhuomController@getThemLoNhuom'
    ]);

Route::post('/he_thong_quan_ly/san_xuat/them_lo_nhuom', [
    'as' => 'route_post_them_lo_nhuom',
    'uses' => 'LoNhuomController@postThemLoNhuom'
    ]);

Route::get('/he_thong_quan_ly/san_xuat/cap_nhat_lo_nhuom/{id_lo_nhuom?}', [
    'as' => 'route_get_cap_nhat_lo_nhuom',
    'uses' => 'LoNhuomController@getCapNhatLoNhuom'
    ]);

Route::post('/he_thong_quan_ly/san_xuat/cap_nhat_lo_nhuom/{id_lo_nhuom}', [
    'as' => 'route_post_cap_nhat_lo_nhuom',
    'uses' => 'LoNhuomController@postCapNhatLoNhuom'
    ]);
////////// END LÔ NHUỘM //////////
