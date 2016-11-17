<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Đơn hàng khách hàng</title>

        <link href="{{ url('/') }}/resources/assets/css/bootstrap-3.3.7.css" type="text/css" rel="stylesheet">
        <script src="{{ url('/') }}/resources/assets/js/jquery-3.1.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/bootstrap-3.3.7.js" type="text/javascript"></script>

        <style>
            ul.pagination {
                margin: 0px;
            }

            #tbl_thong_ke_don_hang_khach_hang td {
                padding-left: 5px;
            }

            #tbl_list_don_hang_khach_hang td {
                padding-left: 5px;
                padding-right: 5px;
            }
        </style>
    </head>
    <body>
        <div id="container" class="container" style="margin-bottom:20px;">
            <div id="content">
                <!-- HEADER -->
                <div style="margin-top:15px;border:1px solid black;">
                    <div style="float:left;width:80%;text-align:center;color:red;">
                        <h2>QUẢN LÝ BÁN HÀNG</h2>
                    </div>
                    <div style="float:left;width:20%;margin-top:16px;">
                        <span>Xin chào <b>{{ Session::get('username') }}</b></span><br>
                        <a href="{{ route('route_get_logout_he_thong') }}">Đăng xuất</a>
                    </div>
                    <div style="clear:both;"></div>
                </div>
                <!-- END HEADER -->
                <!-- NỘI DUNG -->
                <div style="border:1px solid black;border-top:none;">
                    <!-- LIST CHỨC NĂNG -->
                    <div id="div_chuc_nang" style="float:left;width:14%;">
                        <div style="font-weight:bold;text-align:center;border-bottom:1px solid black;border-right:1px solid black;">Chức năng</div>
                        <ul id="ul_chuc_nang" style="list-style-type:none;padding-left:0px;margin-bottom:-1px;">
                            @foreach ($list_chuc_nang as $chuc_nang => $link)
                                <li style="border-right:1px solid black;border-bottom:1px solid black;padding-left:10px;">
                                    <a href="{{ $link }}">{{ $chuc_nang }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- END LIST CHỨC NĂNG -->
                    <div style="float:left;width:86%;">
                        <!-- MAIN CONTENT -->
                        <div id="main_content">
                            <div style="margin-left:20px;margin-top:18px;">
                                <h2 style="text-align:center;margin-bottom:0px;">Danh sách đơn hàng khách hàng</h2>
                                <div id="button_group" style="float:left;width:40%;">
                                    <input type="button" value="Xem tất cả đơn hàng" onclick="xemTatCaDonHang()">
                                    <input type="button" value="Thêm đơn hàng" onclick="themDonHang()" style="margin-left:5px;margin-right:5px;">
                                    <input type="button" value="Cập nhật đơn hàng" onclick="capNhatDonHang()">
                                </div>
                                <div id="loc_don_hang_theo_khach_hang" style="float:right;width:58%;">
                                    Lọc các đơn hàng mới hoặc chưa hoàn thành của khách hàng: 
                                    <select id="idKhachHang" name="idKhachHang">
                                        @foreach ($list_khach_hang as $khach_hang)
                                            <option value="{{ $khach_hang->id }}" {{ (isset($khach_hang_duoc_chon) && ($khach_hang->id == $khach_hang_duoc_chon->id))?'selected':'' }}>
                                                {{ $khach_hang->ho_ten }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="button" value="Lọc" onclick="loc()">
                                </div>
                                <div style="clear:both;"></div>
                                <div id="thong_ke_don_hang_khach_hang">
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    <h3 style="margin-top:0px;margin-bottom:5px;">{{ $kho_moc_duoc_chon->ten }}</h3>
                                    @if (isset($message))
                                        <div style="text-align:center;color:red;margin-top:25px;">{{ $message }}</div>
                                    @else
                                        <table id="tbl_thong_ke_kho_moc">
                                            <tr>
                                                <td style="padding-left:0px;">
                                                    Tổng số cây mộc{{ isset($loai_vai_duoc_chon)?' '.$loai_vai_duoc_chon->ten:'' }}{{ isset($tong_so_cay_moc)?'':' tồn kho' }}:
                                                </td>
                                                <td>
                                                    {{ isset($tong_so_cay_moc)?$tong_so_cay_moc:$tong_so_cay_moc_ton_kho }} cây
                                                </td>
                                            </tr>
                                            @if (!isset($loai_vai_duoc_chon))
                                                @foreach ($soCayMocTheoLoaiVai as $element)
                                                    <tr>
                                                        <td style="padding-left:0px;">Loại vải {{ $element->ten_loai_vai }}:</td>
                                                        <td>{{ $element->so_cay_moc }} cây</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </table>
                                    @endif
                                </div>
                                @if (!isset($message))
                                    <!-- PHÂN TRANG -->
                                    <div id="phan_trang" style="margin-top:5px;">
                                        {!! $list_cay_moc->render() !!}
                                    </div>
                                    <!-- END PHÂN TRANG -->
                                    <!-- LIST CÂY MỘC -->
                                    <div id="list_cay_moc" style="margin-top:5px;margin-bottom:15px;">
                                        <table id="tbl_list_cay_moc" border="1px solid black" style="border-collapse:collapse;">
                                            <tr style="text-align:center;font-weight:bold;">
                                                <td style="width:59px;">Mã cây mộc</td>
                                                @if (!isset($loai_vai_duoc_chon))
                                                    <td style="width:111px;">Loại vải</td>
                                                @endif
                                                <td style="width:0px;">Số mét</td>
                                                <td style="width:110px;">Nhân viên dệt</td>
                                                <td style="width:63px;">Mã máy dệt</td>
                                                <td style="width:143px;">Ngày giờ dệt</td>
                                                <td style="width:143px;">Ngày giờ nhập kho</td>
                                                @if (isset($tong_so_cay_moc))
                                                    <td style="width:76px;">Mã phiếu xuất mộc</td>
                                                    <td style="width:76px;">Tình trạng</td>
                                                    <td style="width:0px;">Mã lô nhuộm</td>
                                                @endif
                                                @if ($showButtonXoa == true)
                                                    <td>
                                                        <input type="button" value="Xóa" onclick="xoa()">
                                                    </td>
                                                @endif
                                            </tr>
                                            @foreach ($list_cay_moc as $cay_moc)
                                                <tr style="text-align:center;">
                                                    <td style="text-align:right;">
                                                        <a href="{{ route('route_get_cap_nhat_cay_moc', ['id_cay_moc' => $cay_moc->id]) }}">
                                                            {{ $cay_moc->id }}
                                                        </a>
                                                    </td>
                                                    @if (!isset($loai_vai_duoc_chon))
                                                        <td style="text-align:left;">{{ $cay_moc->ten_loai_vai }}</td>
                                                    @endif
                                                    <td style="text-align:right;">{{ number_format($cay_moc->so_met, 0, ',', '.') }}</td>
                                                    <td style="text-align:left;">{{ $cay_moc->ten_nhan_vien_det }}</td>
                                                    <td style="text-align:right;">{{ $cay_moc->ma_may_det }}</td>
                                                    <td>{{ $cay_moc->ngay_gio_det }}</td>
                                                    <td>{{ $cay_moc->ngay_gio_nhap_kho }}</td>
                                                    @if (isset($tong_so_cay_moc))
                                                        <td style="text-align:right;">{{ $cay_moc->id_phieu_xuat_moc }}</td>
                                                        <td style="text-align:center;">{{ $cay_moc->tinh_trang }}</td>
                                                        <td style="text-align:right;">{{ $cay_moc->id_lo_nhuom }}</td>
                                                    @endif
                                                    @if ($showButtonXoa == true)
                                                        <td>
                                                            <input type="checkbox" value="{{ $cay_moc->id }}">
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <!-- END LIST CÂY MỘC -->
                                @endif
                            </div>
                        </div>
                        <!-- END MAIN CONTENT -->
                    </div>
                    <div style="clear:both;"></div>
                </div>
                <!-- END NỘI DUNG -->
            </div>
        </div>
        <script>
            // Đổi ký hiệu "<<" thành "Previous" và ">>" thành "Next" trong chuỗi button phân trang
            $('ul.pagination > li:first > span').text('Previous');
            $('ul.pagination > li:first > a').text('Previous');
            $('ul.pagination > li:last > span').text('Next');
            $('ul.pagination > li:last > a').text('Next');

            function xemTatCaCayMoc()
            {
                $('#xem_tat_ca_cay_moc').val('true');

                // Submit
                //var url = "{{ route('route_post_kho_moc') }}";
                //$('#frm_chon_kho_moc').attr('action', url);
                $('#frm_chon_kho_moc').submit();
            }

            function nhapMoc()
            {
                // Chuyển tới trang Nhập mộc
                var url = "{{ route('route_get_nhap_moc') }}";
                window.location.href = url;
            }

            function capNhatCayMoc()
            {
                // Chuyển tới trang Cập nhật cây mộc
                var url = "{{ route('route_get_cap_nhat_cay_moc') }}";
                window.location.href = url;
            }

            function loc()
            {
                $('#loc_theo_loai_vai').val('true');
                var id_loai_vai = $('#idLoaiVai').val();
                $('#id_loai_vai').val(id_loai_vai);

                // Submit
                //var url = "{{ route('route_post_kho_moc') }}";
                //$('#frm_chon_kho_moc').attr('action', url);
                $('#frm_chon_kho_moc').submit();
            }

            function xoa()
            {
                // Không có cây mộc nào được chọn
                if ($('input[type=checkbox]:checked').length == 0)
                {
                    alert('Bạn chưa chọn cây mộc nào để xóa !');
                    return false;
                }
                else    // Có ít nhất 1 cây mộc được chọn
                {
                    var answer = confirm('Bạn chắc chắn muốn xóa ?');
                    if (answer == true)
                    {
                        var id_cay_moc_muon_xoa;
                        var list_id_cay_moc_muon_xoa = '';

                        // Thiết lập chuỗi danh sách id cây mộc muốn xóa
                        $('input[type=checkbox]:checked').each(function() {
                            id_cay_moc_muon_xoa = $(this).val();
                            list_id_cay_moc_muon_xoa += id_cay_moc_muon_xoa + ',';
                        });
                        list_id_cay_moc_muon_xoa = list_id_cay_moc_muon_xoa.substring(0, list_id_cay_moc_muon_xoa.length - 1);

                        // Submit
                        $('#xoa').val('true');
                        $('#list_id_cay_moc_muon_xoa').val(list_id_cay_moc_muon_xoa);
                        //var url = "{{ route('route_post_kho_moc') }}";
                        //$('#frm_chon_kho_moc').attr('action', url);
                        $('#frm_chon_kho_moc').submit();
                    }
                    else
                    {
                        return false;
                    }
                }
            }
        </script>
    </body>
</html>
