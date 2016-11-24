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

            #tbl_thong_ke_don_hang_khach_hang{
                width: 200px;
            }

            #tbl_list_don_hang_khach_hang td {
                padding-left: 5px;
                padding-right: 5px;
            }

            .display_none {
                display: none;
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
                                <h2 style="text-align:center;margin-bottom:20px;">Danh sách đơn hàng khách hàng</h2>
                                <div id="button_group" style="float:left;width:45%;">
                                    <input type="button" value="Xem tất cả đơn hàng" onclick="xemTatCaDonHang()">
                                    <input type="button" value="Thêm đơn hàng" onclick="themDonHang()" style="margin-left:5px;margin-right:5px;">
                                    <input type="button" value="Cập nhật đơn hàng" onclick="capNhatDonHang()">
                                </div>
                                <!-- FORM SUBMIT -->
                                <div id="loc_don_hang_theo_khach_hang" style="float:right;width:53%;">
                                    {!! Form::open(array('route' => 'route_post_don_hang_khach_hang', 'method' => 'post', 'id' => 'frm_chon_khach_hang')) !!}
                                        <div style="float:left;width:58%;">
                                            Lọc các đơn hàng mới hoặc chưa hoàn thành của khách hàng:
                                        </div>
                                        <div style="float:left;">
                                            <select id="idKhachHang" name="idKhachHang" style="width:150px;margin-left:2px;">
                                                @foreach ($list_khach_hang as $khach_hang)
                                                    <option value="{{ $khach_hang->id }}" {{ (isset($khach_hang_duoc_chon) && ($khach_hang->id == $khach_hang_duoc_chon->id))?'selected':'' }}>
                                                        {{ $khach_hang->ho_ten }}
                                                    </option>
                                                @endforeach
                                            </select>&nbsp;
                                            <input type="button" value="Lọc" onclick="loc()">
                                        </div>
                                        <div style="clear:both;"></div>
                                        <input type="hidden" id="xem_tat_ca_don_hang" name="xem_tat_ca_don_hang" value="false">
                                        <input type="hidden" id="loc_theo_khach_hang" name="loc_theo_khach_hang" value="false">
                                        <input type="hidden" id="xoa" name="xoa" value="false">
                                        <input type="hidden" id="list_id_don_hang_khach_hang_muon_xoa" name="list_id_don_hang_khach_hang_muon_xoa" value="">
                                    {!! Form::close() !!}
                                </div>
                                <!-- END FORM SUBMIT -->
                                <div style="clear:both;"></div>
                                <div id="thong_ke_don_hang_khach_hang">
                                    @if (isset($khach_hang_duoc_chon))
                                        <h3 style="margin-top:5px;margin-bottom:10px;">Khách hàng: {{ $khach_hang_duoc_chon->ho_ten }}</h3>
                                    @endif
                                    @if (isset($message))
                                        <div style="text-align:center;color:red;margin-top:25px;margin-bottom:25px;">{{ $message }}</div>
                                    @else
                                        <table id="tbl_thong_ke_don_hang_khach_hang">
                                            @foreach ($tong_so_don_hang_khach_hang_theo_tinh_trang as $tinh_trang => $tong_so_don_hang_khach_hang)
                                                <tr>
                                                    <td>Đơn hàng {{ ($tinh_trang == 'Hoàn thành')?'đã ':'' }}{{ $tinh_trang }}:</td>
                                                    <td>{{ number_format($tong_so_don_hang_khach_hang, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @endif
                                </div>
                                <script>
                                    @if (!isset($xem_tat_ca_don_hang))
                                        $('#tbl_thong_ke_don_hang_khach_hang tr:last').addClass('display_none');
                                    @endif
                                </script>
                                @if (!isset($message))
                                    <!-- PHÂN TRANG -->
                                    <div id="phan_trang" style="margin-top:5px;">
                                        {!! $listDonHangKhachHang->render() !!}
                                    </div>
                                    <!-- END PHÂN TRANG -->
                                    <!-- LIST ĐƠN HÀNG KHÁCH HÀNG -->
                                    <div id="list_don_hang_khach_hang" style="margin-top:5px;margin-bottom:15px;">
                                        <table id="tbl_list_don_hang_khach_hang" border="1px solid black" style="border-collapse:collapse;">
                                            <tr style="text-align:center;font-weight:bold;">
                                                <td style="width:105px;">Mã đơn hàng khách hàng</td>
                                                @if (!isset($khach_hang_duoc_chon))
                                                    <td style="width:150px;">Khách hàng</td>
                                                @endif
                                                <td style="width:125px;">Loại vải</td>
                                                <td style="width:0px;">Màu</td>
                                                <td style="width:0px;">Khổ (m)</td>
                                                <td style="width:60px;">Tổng số mét</td>
                                                <td style="width:85px;">Hạn chót</td>
                                                <td style="width:0px;">Ngày giờ đặt hàng</td>
                                                <td style="width:65px;">Đã giao (m)</td>
                                                <td style="width:125px;">Tình trạng</td>
                                                @if ($showButtonXoa == true)
                                                    <td>
                                                        <input type="button" value="Xóa" onclick="xoa()">
                                                    </td>
                                                @endif
                                            </tr>
                                            @foreach ($listDonHangKhachHang as $don_hang_khach_hang)
                                                <tr style="text-align:center;">
                                                    <td style="text-align:right;">
                                                        <a href="{{ route('route_get_cap_nhat_don_hang_khach_hang', ['id_don_hang_khach_hang' => $don_hang_khach_hang->id]) }}">
                                                            {{ $don_hang_khach_hang->id }}
                                                        </a>
                                                    </td>
                                                    @if (!isset($khach_hang_duoc_chon))
                                                        <td style="text-align:left;">{{ $don_hang_khach_hang->ten_khach_hang }}</td>
                                                    @endif
                                                    <td style="text-align:left;">{{ $don_hang_khach_hang->ten_loai_vai }}</td>
                                                    <td style="text-align:left;">{{ $don_hang_khach_hang->ten_mau }}</td>
                                                    <td style="text-align:right;">{{ number_format($don_hang_khach_hang->kho, 1, ',', '.') }}</td>
                                                    <td style="text-align:right;">{{ number_format($don_hang_khach_hang->tong_so_met, 0, ',', '.') }}</td>
                                                    <td>{{ $don_hang_khach_hang->han_chot }}</td>
                                                    <td>{{ $don_hang_khach_hang->ngay_gio_dat_hang }}</td>
                                                    <td style="text-align:right;">{{ number_format($don_hang_khach_hang->tong_so_met_da_giao, 0, ',', '.') }}</td>
                                                    <td style="text-align:left;">{{ $don_hang_khach_hang->tinh_trang }}</td>
                                                    @if ($showButtonXoa == true)
                                                        <td>
                                                            <input type="checkbox" value="{{ $don_hang_khach_hang->id }}">
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <!-- END LIST ĐƠN HÀNG KHÁCH HÀNG -->
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

            function xemTatCaDonHang()
            {
                $('#xem_tat_ca_don_hang').val('true');

                // Submit
                //var url = "{{ route('route_post_don_hang_khach_hang') }}";
                //$('#frm_chon_khach_hang').attr('action', url);
                $('#frm_chon_khach_hang').submit();
            }

            function themDonHang()
            {
                // Chuyển tới trang Thêm đơn hàng khách hàng
                var url = "{{ route('route_get_them_don_hang_khach_hang') }}";
                window.location.href = url;
            }

            function capNhatDonHang()
            {
                // Chuyển tới trang Cập nhật đơn hàng khách hàng
                var url = "{{ route('route_get_cap_nhat_don_hang_khach_hang') }}";
                window.location.href = url;
            }

            function loc()
            {
                $('#loc_theo_khach_hang').val('true');

                // Submit
                //var url = "{{ route('route_post_don_hang_khach_hang') }}";
                //$('#frm_chon_khach_hang').attr('action', url);
                $('#frm_chon_khach_hang').submit();
            }

            function xoa()
            {
                // Không có đơn hàng khách hàng nào được chọn
                if ($('input[type=checkbox]:checked').length == 0)
                {
                    alert('Bạn chưa chọn đơn hàng khách hàng nào để xóa !');
                    return false;
                }
                else    // Có ít nhất 1 đơn hàng khách hàng được chọn
                {
                    var answer = confirm('Bạn chắc chắn muốn xóa ?');
                    if (answer == true)
                    {
                        var id_don_hang_khach_hang_muon_xoa;
                        var list_id_don_hang_khach_hang_muon_xoa = '';

                        // Thiết lập chuỗi danh sách id đơn hàng khách hàng muốn xóa
                        $('input[type=checkbox]:checked').each(function() {
                            id_don_hang_khach_hang_muon_xoa = $(this).val();
                            list_id_don_hang_khach_hang_muon_xoa += id_don_hang_khach_hang_muon_xoa + ',';
                        });
                        list_id_don_hang_khach_hang_muon_xoa = list_id_don_hang_khach_hang_muon_xoa.substring(0, list_id_don_hang_khach_hang_muon_xoa.length - 1);

                        // Submit
                        $('#xoa').val('true');
                        $('#list_id_don_hang_khach_hang_muon_xoa').val(list_id_don_hang_khach_hang_muon_xoa);
                        //var url = "{{ route('route_post_don_hang_khach_hang') }}";
                        //$('#frm_chon_khach_hang').attr('action', url);
                        $('#frm_chon_khach_hang').submit();
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
