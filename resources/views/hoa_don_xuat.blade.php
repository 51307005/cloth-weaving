<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Hóa đơn xuất</title>

        <link href="{{ url('/') }}/resources/assets/css/bootstrap-3.3.7.css" type="text/css" rel="stylesheet">
        <script src="{{ url('/') }}/resources/assets/js/jquery-3.1.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/bootstrap-3.3.7.js" type="text/javascript"></script>

        <style>
            ul.pagination {
                margin: 0px;
            }

            #tbl_list_hoa_don_xuat td {
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
                            <h3 style="text-align:center;">DANH SÁCH HÓA ĐƠN XUẤT</h3>
                            <div id="button_group" style="margin-left:10px;margin-top:14px;">
                                <input type="button" value="Thêm hóa đơn" onclick="themHoaDon()">&nbsp;
                                <input type="button" value="Cập nhật hóa đơn" onclick="capNhatHoaDon()">
                            </div>
                            @if (isset($message))
                                <div style="text-align:center;color:red;margin-top:25px;margin-bottom:25px;">{{ $message }}</div>
                            @else
                                <!-- FORM XÓA HÓA ĐƠN XUẤT -->
                                {!! Form::open(array('route' => 'route_post_hoa_don_xuat', 'method' => 'post', 'id' => 'frm_xoa_hoa_don_xuat')) !!}
                                    <input type="hidden" id="list_id_hoa_don_xuat_muon_xoa" name="list_id_hoa_don_xuat_muon_xoa" value="">
                                {!! Form::close() !!}
                                <!-- END FORM XÓA HÓA ĐƠN XUẤT -->
                                <!-- PHÂN TRANG -->
                                <div id="phan_trang" style="margin-top:8px;margin-left:10px;">
                                    {!! $list_hoa_don_xuat->render() !!}
                                </div>
                                <!-- END PHÂN TRANG -->
                                <!-- LIST HÓA ĐƠN XUẤT -->
                                <div id="list_hoa_don_xuat" style="margin-top:5px;margin-bottom:15px;margin-left:10px;">
                                    <table id="tbl_list_hoa_don_xuat" border="1px solid black" style="border-collapse:collapse;">
                                        <tr style="text-align:center;font-weight:bold;">
                                            <td style="width:55px;">Mã hóa đơn xuất</td>
                                            <td style="width:55px;">Mã đơn hàng khách hàng</td>
                                            <td style="width:125px;">Khách hàng</td>
                                            <td style="width:115px;">Loại vải</td>
                                            <td style="width:50px;">Màu</td>
                                            <td style="width:0px;">Khổ (m)</td>
                                            <td style="width:50px;">Tổng số cây vải</td>
                                            <td style="width:55px;">Tổng số mét</td>
                                            <td style="width:92px;">Tổng tiền (VNĐ)</td>
                                            <td style="width:60px;">Kho</td>
                                            <td style="width:{{ ($showButtonXoa == true)?83:118 }}px;">Nhân viên xuất hóa đơn</td>
                                            <td style="width:0px;">Ngày giờ xuất hóa đơn</td>
                                            <td style="width:{{ ($showButtonXoa == true)?0:61 }}px;">Tính chất</td>
                                            @if ($showButtonXoa == true)
                                                <td style="width:0px;">
                                                    <input type="button" value="Xóa" onclick="xoa()">
                                                </td>
                                            @endif
                                        </tr>
                                        @foreach ($list_hoa_don_xuat as $hoa_don_xuat)
                                            <tr>
                                                <td style="text-align:right;">
                                                    <a href="{{ route('route_get_cap_nhat_hoa_don_xuat', ['id_hoa_don_xuat' => $hoa_don_xuat->id]) }}">
                                                        {{ $hoa_don_xuat->id }}
                                                    </a>
                                                </td>
                                                <td style="text-align:right;">{{ $hoa_don_xuat->id_don_hang_khach_hang }}</td>
                                                <td style="text-align:left;">{{ $hoa_don_xuat->ten_khach_hang }}</td>
                                                <td style="text-align:left;">{{ $hoa_don_xuat->ten_loai_vai }}</td>
                                                <td style="text-align:left;">{{ $hoa_don_xuat->ten_mau }}</td>
                                                <td style="text-align:right;">{{ number_format($hoa_don_xuat->kho, 1, ',', '.') }}</td>
                                                <td style="text-align:right;">{{ number_format($hoa_don_xuat->tong_so_cay_vai, 0, ',', '.') }}</td>
                                                <td style="text-align:right;">{{ number_format($hoa_don_xuat->tong_so_met, 0, ',', '.') }}</td>
                                                <td style="text-align:right;">{{ number_format($hoa_don_xuat->tong_tien, 0, ',', '.') }}</td>
                                                <td style="text-align:left;">{{ $hoa_don_xuat->ten_kho }}</td>
                                                <td style="text-align:left;">{{ $hoa_don_xuat->ten_nhan_vien_xuat }}</td>
                                                <td style="text-align:center;">{{ $hoa_don_xuat->ngay_gio_xuat_hoa_don }}</td>
                                                <td style="text-align:center;">{{ $hoa_don_xuat->tinh_chat }}</td>
                                                @if ($showButtonXoa == true)
                                                    <td style="text-align:center;">
                                                        <input type="checkbox" value="{{ $hoa_don_xuat->id }}">
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <!-- END LIST HÓA ĐƠN XUẤT -->
                            @endif
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
            $('ul.pagination>li:first>span').text('Previous');
            $('ul.pagination>li:first>a').text('Previous');
            $('ul.pagination>li:last>span').text('Next');
            $('ul.pagination>li:last>a').text('Next');

            function themHoaDon()
            {
                // Chuyển tới trang Thêm hóa đơn xuất
                var url = "{{ route('route_get_them_hoa_don_xuat') }}";
                window.location.href = url;
            }

            function capNhatHoaDon()
            {
                // Chuyển tới trang Cập nhật hóa đơn xuất
                var url = "{{ route('route_get_cap_nhat_hoa_don_xuat') }}";
                window.location.href = url;
            }

            function xoa()
            {
                // Không có hóa đơn xuất nào được chọn
                if ($('input[type=checkbox]:checked').length == 0)
                {
                    alert('Bạn chưa chọn hóa đơn xuất nào để xóa !');
                    return false;
                }
                else    // Có ít nhất 1 hóa đơn xuất được chọn
                {
                    var answer = confirm('Bạn chắc chắn muốn xóa ?');
                    if (answer == true)
                    {
                        var id_hoa_don_xuat_muon_xoa;
                        var list_id_hoa_don_xuat_muon_xoa = '';

                        // Thiết lập chuỗi danh sách id hóa đơn xuất muốn xóa
                        $('input[type=checkbox]:checked').each(function() {
                            id_hoa_don_xuat_muon_xoa = $(this).val();
                            list_id_hoa_don_xuat_muon_xoa += id_hoa_don_xuat_muon_xoa + ',';
                        });
                        list_id_hoa_don_xuat_muon_xoa = list_id_hoa_don_xuat_muon_xoa.substring(0, list_id_hoa_don_xuat_muon_xoa.length - 1);

                        // Submit
                        $('#list_id_hoa_don_xuat_muon_xoa').val(list_id_hoa_don_xuat_muon_xoa);
                        //var url = "{{ route('route_post_hoa_don_xuat') }}";
                        //$('#frm_xoa_hoa_don_xuat').attr('action', url);
                        $('#frm_xoa_hoa_don_xuat').submit();
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
