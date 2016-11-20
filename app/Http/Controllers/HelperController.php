<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class HelperController extends Controller
{
    const QUYEN_ADMIN = 1;
    const QUYEN_SAN_XUAT = 2;
    const QUYEN_KHO = 3;
    const QUYEN_BAN_HANG = 4;

    const NAM = 1;
    const NU = 0;

    public $ma_may_det = array(
        1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
        11, 12, 13, 14, 15, 16, 17, 18, 19, 20
        );

    public $tinh_trang_cay_moc_vai_thanh_pham = array('Chưa xuất', 'Đã xuất');

    public $tinh_trang_don_hang_cong_ty_don_hang_khach_hang = array('Mới', 'Chưa hoàn thành', 'Hoàn thành');

    public $kho = array(0.5, 1, 1.5);

    public $chuc_vu = array(
        'Quản lý', 'Nhân viên dệt', 'Nhân viên nhuộm', 'Nhân viên pha chế màu',
        'Nhân viên kho sợi', 'Nhân viên kho mộc', 'Nhân viên kho thành phẩm', 'Nhân viên bán hàng'
        );

    public $tinh_chat = array('Trả dần', 'Trả liền');

    public $loai_thu_chi = array('Thu', 'Chi');

    public $phuong_thuc = array('Chuyển khoản', 'Tiền mặt');

    public $list_chuc_nang_admin = array(
        'Quản lý Kho', 'Quản lý Sản xuất', 'Quản lý Bán hàng',
        'Nhân viên', 'Thu - Chi', 'Thống kê'
        );
    public $list_chuc_nang_san_xuat = array(
        'Loại vải', 'Lô nhuộm', 'Màu'
        );
    public $list_chuc_nang_kho = array(
        'Danh sách kho', 'Kho sợi', 'Kho mộc', 'Kho thành phẩm',
        'Loại sợi', 'Nhà cung cấp', 'Đơn hàng công ty', 'Hóa đơn nhập',
        'Phiếu xuất sợi', 'Phiếu xuất mộc', 'Xuất mộc', 'Cập nhật xuất mộc',
        'Xuất vải thành phẩm', 'Cập nhật xuất vải thành phẩm', 'Đề xuất mua nguyên vật liệu'
        );
    public $list_chuc_nang_ban_hang = array(
        'Khách hàng', 'Đơn hàng khách hàng',
        'Hóa đơn xuất', 'Báo giá'
        );

    public $links_list_chuc_nang_admin = array(
        'kho', 'san_xuat', 'ban_hang',
        'manager/nhan_vien', 'manager/thu_chi', 'manager/thong_ke'
        );
    public $links_list_chuc_nang_san_xuat = array(
        'loai_vai', 'lo_nhuom', 'mau'
        );
    public $links_list_chuc_nang_kho = array(
        'danh_sach_kho', 'kho_soi', 'kho_moc', 'kho_thanh_pham',
        'loai_soi', 'nha_cung_cap', 'don_hang_cong_ty', 'hoa_don_nhap',
        'phieu_xuat_soi', 'phieu_xuat_moc', 'xuat_moc', 'cap_nhat_xuat_moc',
        'xuat_vai_thanh_pham', 'cap_nhat_xuat_vai_thanh_pham', 'de_xuat_mua_nguyen_vat_lieu'
        );
    public $links_list_chuc_nang_ban_hang = array(
        'khach_hang', 'don_hang_khach_hang',
        'hoa_don_xuat', 'bao_gia'
        );

    public function taoLinkChoListChucNang($quyen)
    {
        $url = '';
        $list_chuc_nang = array();

        switch ($quyen)
        {
            case self::QUYEN_ADMIN:
                $url = url('/');
                for ($i = 0 ; $i < count($this->list_chuc_nang_admin) ; $i++)
                {
                    $list_chuc_nang[$this->list_chuc_nang_admin[$i]] = $url.'/he_thong_quan_ly/'.$this->links_list_chuc_nang_admin[$i];
                }
                break;
            case self::QUYEN_SAN_XUAT:
                $url = route('route_get_trang_chu_san_xuat');
                for ($i = 0 ; $i < count($this->list_chuc_nang_san_xuat) ; $i++)
                {
                    $list_chuc_nang[$this->list_chuc_nang_san_xuat[$i]] = $url.'/'.$this->links_list_chuc_nang_san_xuat[$i];
                }
                break;
            case self::QUYEN_KHO:
                $url = route('route_get_trang_chu_kho');
                for ($i = 0 ; $i < count($this->list_chuc_nang_kho) ; $i++)
                {
                    $list_chuc_nang[$this->list_chuc_nang_kho[$i]] = $url.'/'.$this->links_list_chuc_nang_kho[$i];
                }
                break;
            case self::QUYEN_BAN_HANG:
                $url = route('route_get_trang_chu_ban_hang');
                for ($i = 0 ; $i < count($this->list_chuc_nang_ban_hang) ; $i++)
                {
                    $list_chuc_nang[$this->list_chuc_nang_ban_hang[$i]] = $url.'/'.$this->links_list_chuc_nang_ban_hang[$i];
                }
                break;
        }

        return $list_chuc_nang;
    }
}
