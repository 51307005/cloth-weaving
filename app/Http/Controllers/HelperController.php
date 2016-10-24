<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class HelperController extends BaseController
{
    const QUYEN_ADMIN = 1;
    const QUYEN_SAN_XUAT = 2;
    const QUYEN_KHO = 3;
    const QUYEN_BAN_HANG = 4;

    public $list_chuc_nang_admin = array('tên chức năng 1', 'tên chức năng 2');
    public $list_chuc_nang_san_xuat = array('tên chức năng 1', 'tên chức năng 2');
    public $list_chuc_nang_kho = array(
        'Danh sách kho', 'Kho sợi', 'Kho mộc', 'Kho thành phẩm',
        'Loại sợi', 'Nhà cung cấp', 'Đơn hàng công ty', 'Hóa đơn nhập',
        'Phiếu xuất sợi', 'Phiếu xuất mộc', 'Xuất mộc', 'Cập nhật xuất mộc',
        'Xuất vải thành phẩm', 'Cập nhật xuất vải thành phẩm', 'Đề xuất mua nguyên vật liệu'
        );
    public $list_chuc_nang_ban_hang = array('tên chức năng 1', 'tên chức năng 2');

    public $links_list_chuc_nang_admin = array('link 1', 'link 2');
    public $links_list_chuc_nang_san_xuat = array('link 1', 'link 2');
    public $links_list_chuc_nang_kho = array(
        'danh_sach_kho', 'kho_soi', 'kho_moc', 'kho_thanh_pham',
        'loai_soi', 'nha_cung_cap', 'don_hang_cong_ty', 'hoa_don_nhap',
        'phieu_xuat_soi', 'phieu_xuat_moc', 'xuat_moc', 'cap_nhat_xuat_moc',
        'xuat_vai_thanh_pham', 'cap_nhat_xuat_vai_thanh_pham', 'de_xuat_mua_nguyen_vat_lieu'
        );
    public $links_list_chuc_nang_ban_hang = array('link 1', 'link 2');

    public function taoLinkChoListChucNang($quyen)
    {
        $url = '';
        $list_chuc_nang = array();

        switch ($quyen)
        {
            case self::QUYEN_ADMIN:
                $url = route('route_get_trang_chu_manager');
                for ($i = 0 ; $i < count($this->list_chuc_nang_admin) ; $i++)
                {
                    $list_chuc_nang[$this->list_chuc_nang_admin[$i]] = $url.'/'.$this->links_list_chuc_nang_admin[$i];
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