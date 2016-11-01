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

/*////////// PHÂN QUYỀN //////////
Route::get('/he_thong_quan_ly/manager', [
    'as' => 'route_get_trang_chu_manager',
    'uses' => 'ManagerController@getTrangChu'
    ]);

Route::get('/he_thong_quan_ly/san_xuat', [
    'as' => 'route_get_trang_chu_san_xuat',
    'uses' => 'SanXuatController@getTrangChu'
    ]);
*/
Route::get('/he_thong_quan_ly/kho', [
    'as' => 'route_get_trang_chu_kho',
    'uses' => 'KhoController@getTrangChu'
    ]);
/*
Route::get('/he_thong_quan_ly/ban_hang', [
    'as' => 'route_get_trang_chu_ban_hang',
    'uses' => 'BanHangController@getTrangChu'
    ]);
*/////////// END PHÂN QUYỀN //////////

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

Route::get('/he_thong_quan_ly/kho/cap_nhat_xuat_moc', [
    'as' => 'route_get_cap_nhat_xuat_moc',
    'uses' => 'KhoMocController@getCapNhatXuatMoc'
    ]);

Route::post('/he_thong_quan_ly/kho/cap_nhat_xuat_moc', [
    'as' => 'route_post_cap_nhat_xuat_moc',
    'uses' => 'KhoMocController@postCapNhatXuatMoc'
    ]);
////////// END MỘC //////////
