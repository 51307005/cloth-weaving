<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Phiếu xuất mộc</title>

        <link href="{{ url('/') }}/resources/assets/css/bootstrap-3.3.7.css" type="text/css" rel="stylesheet">
        <script src="{{ url('/') }}/resources/assets/js/jquery-3.1.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/bootstrap-3.3.7.js" type="text/javascript"></script>

        <style>
            ul.pagination {
                margin: 0px;
            }

            #tbl_list_phieu_xuat_moc td {
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
                        <h2>QUẢN LÝ KHO</h2>
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
                    <div id="div_chuc_nang" style="float:left;width:13%;">
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
                            <h3 style="text-align:center;">DANH SÁCH PHIẾU XUẤT MỘC</h3>
                            <div id="button_group" style="margin-left:20px;margin-top:14px;">
                                <input type="button" value="Thêm phiếu" onclick="themPhieu()">&nbsp;
                                <input type="button" value="Cập nhật phiếu" onclick="capNhatPhieu()">
                            </div>
                            <!-- FORM XÓA PHIẾU XUẤT MỘC -->
                            {!! Form::open(array('route' => 'route_post_phieu_xuat_moc', 'method' => 'post', 'id' => 'frm_xoa_phieu_xuat_moc')) !!}
                                <input type="hidden" id="list_id_phieu_xuat_moc_muon_xoa" name="list_id_phieu_xuat_moc_muon_xoa" value="">
                            {!! Form::close() !!}
                            <!-- END FORM XÓA PHIẾU XUẤT MỘC -->
                            <!-- PHÂN TRANG -->
                            <div id="phan_trang" style="margin-top:8px;margin-left:20px;">
                                {!! $list_phieu_xuat_moc->render() !!}
                            </div>
                            <!-- END PHÂN TRANG -->
                            <!-- LIST PHIẾU XUẤT MỘC -->
                            <div id="list_phieu_xuat_moc" style="margin-top:5px;margin-bottom:15px;margin-left:20px;">
                                <table id="tbl_list_phieu_xuat_moc" border="1px solid black" style="border-collapse:collapse;">
                                    <tr style="text-align:center;font-weight:bold;">
                                        <td>Mã phiếu xuất mộc</td>
                                        <td>Tổng số cây mộc</td>
                                        <td>Tổng số mét</td>
                                        <td>Kho</td>
                                        <td>Nhân viên xuất</td>
                                        <td>Ngày giờ xuất kho</td>
                                        @if ($showButtonXoa == true)
                                            <td>
                                                <input type="button" value="Xóa" onclick="xoa()">
                                            </td>
                                        @endif
                                    </tr>
                                    @foreach ($list_phieu_xuat_moc as $phieu_xuat_moc)
                                        <tr>
                                            <td style="text-align:right;">
                                                <a href="{{ route('route_get_cap_nhat_phieu_xuat_moc', ['id_phieu_xuat_moc' => $phieu_xuat_moc->id]) }}">
                                                    {{ $phieu_xuat_moc->id }}
                                                </a>
                                            </td>
                                            <td style="text-align:right;">{{ number_format($phieu_xuat_moc->tong_so_cay_moc, 0, ',', '.') }}</td>
                                            <td style="text-align:right;">{{ number_format($phieu_xuat_moc->tong_so_met, 0, ',', '.') }}</td>
                                            <td style="text-align:left;">{{ $phieu_xuat_moc->ten_kho }}</td>
                                            <td style="text-align:left;">{{ $phieu_xuat_moc->ten_nhan_vien_xuat }}</td>
                                            <td style="text-align:center;">{{ $phieu_xuat_moc->ngay_gio_xuat_kho }}</td>
                                            @if ($showButtonXoa == true)
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="{{ $phieu_xuat_moc->id }}">
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <!-- END LIST PHIẾU XUẤT MỘC -->
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

            function themPhieu()
            {
                // Chuyển tới trang Thêm phiếu xuất mộc
                var url = "{{ route('route_get_them_phieu_xuat_moc') }}";
                window.location.href = url;
            }

            function capNhatPhieu()
            {
                // Chuyển tới trang Cập nhật phiếu xuất mộc
                var url = "{{ route('route_get_cap_nhat_phieu_xuat_moc') }}";
                window.location.href = url;
            }

            function xoa()
            {
                // Không có phiếu xuất mộc nào được chọn
                if ($('input[type=checkbox]:checked').length == 0)
                {
                    alert('Bạn chưa chọn phiếu xuất mộc nào để xóa !');
                    return false;
                }
                else    // Có ít nhất 1 phiếu xuất mộc được chọn
                {
                    var answer = confirm('Bạn chắc chắn muốn xóa ?');
                    if (answer == true)
                    {
                        var id_phieu_xuat_moc_muon_xoa;
                        var list_id_phieu_xuat_moc_muon_xoa = '';

                        // Thiết lập chuỗi danh sách id phiếu xuất mộc muốn xóa
                        $('input[type=checkbox]:checked').each(function() {
                            id_phieu_xuat_moc_muon_xoa = $(this).val();
                            list_id_phieu_xuat_moc_muon_xoa += id_phieu_xuat_moc_muon_xoa + ',';
                        });
                        list_id_phieu_xuat_moc_muon_xoa = list_id_phieu_xuat_moc_muon_xoa.substring(0, list_id_phieu_xuat_moc_muon_xoa.length - 1);

                        // Submit
                        $('#list_id_phieu_xuat_moc_muon_xoa').val(list_id_phieu_xuat_moc_muon_xoa);
                        //var url = "{{ route('route_post_phieu_xuat_moc') }}";
                        //$('#frm_xoa_phieu_xuat_moc').attr('action', url);
                        $('#frm_xoa_phieu_xuat_moc').submit();
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
