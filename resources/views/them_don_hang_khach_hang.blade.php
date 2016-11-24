<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Thêm đơn hàng khách hàng</title>

        <link href="{{ url('/') }}/resources/assets/css/jquery-ui-1.11.4.css" type="text/css" rel="stylesheet">
        <link href="{{ url('/') }}/resources/assets/css/jquery-ui-timepicker.css" type="text/css" rel="stylesheet">
        <link href="{{ url('/') }}/resources/assets/css/bootstrap-3.3.7.css" type="text/css" rel="stylesheet">
        <script src="{{ url('/') }}/resources/assets/js/jquery-3.1.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/jquery-ui-1.11.4.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/jquery-ui-timepicker-1.6.3.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/jquery-numeric-1.4.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/jquery-number-2.1.6.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/bootstrap-3.3.7.js" type="text/javascript"></script>

        <style>
            #tbl_them_don_hang_khach_hang input, select {
                width: 165px;
                padding-left: 5px;
            }

            #btn_them {
                width: 60px !important;
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
                            <h3 style="text-align:center;">THÊM ĐƠN HÀNG KHÁCH HÀNG</h3>
                            <!-- FORM THÊM ĐƠN HÀNG KHÁCH HÀNG -->
                            <div style="margin-top:10px;margin-left:30px;margin-bottom:10px;float:left;width:50%;">
                                {!! Form::open(array('route' => 'route_post_them_don_hang_khach_hang', 'method' => 'post', 'id' => 'frm_them_don_hang_khach_hang')) !!}
                                    <table id="tbl_them_don_hang_khach_hang" style="width:365px;height:250px;">
                                        <tr>
                                            <td style="font-weight:bold;">Mã đơn hàng khách hàng:</td>
                                            <td>
                                                <input type="text" id="id_don_hang_khach_hang" name="id_don_hang_khach_hang" value="{{ $id_don_hang_khach_hang_cuoi_cung + 1 }}" readonly style="background-color:#cccccc;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Khách hàng:</td>
                                            <td>
                                                <select id="id_khach_hang" name="id_khach_hang">
                                                    @foreach ($list_khach_hang as $khach_hang)
                                                        <option value="{{ $khach_hang->id }}">{{ $khach_hang->ho_ten }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Loại vải:</td>
                                            <td>
                                                <select id="id_loai_vai" name="id_loai_vai">
                                                    @foreach ($list_loai_vai as $loai_vai)
                                                        <option value="{{ $loai_vai->id }}">{{ $loai_vai->ten }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Màu:</td>
                                            <td>
                                                <select id="id_mau" name="id_mau">
                                                    @foreach ($list_mau as $mau)
                                                        <option value="{{ $mau->id }}">{{ $mau->ten }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Khổ (m):</td>
                                            <td>
                                                <select id="kho" name="kho">
                                                    @foreach ($list_kho as $kho)
                                                        <option value="{{ $kho }}">{{ number_format($kho, 1, ',', '.') }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Tổng số mét:</td>
                                            <td>
                                                <input type="text" id="tong_so_met" name="tong_so_met" value="" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Hạn chót:</td>
                                            <td>
                                                <input type="text" id="han_chot" name="han_chot" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Ngày giờ đặt hàng:</td>
                                            <td>
                                                <input type="text" id="ngay_gio_dat_hang" name="ngay_gio_dat_hang" value="" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <input type="button" id="btn_them" value="Thêm" onclick="themDonHangKhachHang()">
                                            </td>
                                        </tr>
                                    </table>
                                {!! Form::close() !!}
                            </div>
                            <!-- END FORM THÊM ĐƠN HÀNG KHÁCH HÀNG -->
                            @if (count($errors) > 0)
                                <!-- VALIDATION ERROR MESSAGES -->
                                <div id="validation_error_messages" class="alert alert-info" style="float:left;margin-top:15px;">
                                    <ul style="padding-left:0px;color:red;">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- END VALIDATION ERROR MESSAGES -->
                            @endif
                            <div style="clear:both;"></div>
                        </div>
                        <!-- END MAIN CONTENT -->
                    </div>
                    <div style="clear:both;"></div>
                </div>
                <!-- END NỘI DUNG -->
            </div>
        </div>
        <script>
            $('#han_chot').datepicker({
                dateFormat: 'yy-mm-dd'
            });

            $('#ngay_gio_dat_hang').datetimepicker({
                dateFormat: 'yy-mm-dd',
                timeFormat: 'HH:mm:ss'
            });

            $('#tong_so_met').numeric({
                decimal: false,
                negative: false
            });

            function themDonHangKhachHang()
            {
                // Validate Tổng số mét
                var tong_so_met = $('#tong_so_met').val();
                if (tong_so_met == '')
                {
                    alert('Bạn chưa nhập tổng số mét !');
                    return false;
                }
                else if (parseInt(tong_so_met) == 0)
                {
                    alert('Tổng số mét ít nhất phải là 1 !');
                    return false;
                }

                // Validate Hạn chót
                var han_chot = $('#han_chot').val();
                if (han_chot != '')
                {
                    var hanChot = new Date(han_chot);
                    if (isNaN(hanChot))
                    {
                        alert('Hạn chót không hợp lệ !');
                        return false;
                    }
                }

                // Validate Ngày giờ đặt hàng
                var ngay_gio_dat_hang = $('#ngay_gio_dat_hang').val();
                if (ngay_gio_dat_hang == '')
                {
                    alert('Bạn chưa nhập ngày giờ đặt hàng !');
                    return false;
                }
                else
                {
                    var ngayGioDatHang = new Date(ngay_gio_dat_hang);
                    if (isNaN(ngayGioDatHang))
                    {
                        alert('Ngày giờ đặt hàng không hợp lệ !');
                        return false;
                    }
                }

                // Validate trường hợp: Hạn chót <= Ngày giờ đặt hàng
                var hanchot = new Date(han_chot);
                var ngaygiodathang = new Date(ngay_gio_dat_hang);
                if (hanchot.getTime() <= ngaygiodathang.getTime())
                {
                    alert('Hạn chót phải sau ngày giờ đặt hàng !');
                    return false;
                }

                // Validate successful
                // Submit
                //var url = "{{ route('route_post_them_don_hang_khach_hang') }}";
                //$('#frm_them_don_hang_khach_hang').attr('action', url);
                $('#frm_them_don_hang_khach_hang').submit();
            }
        </script>
    </body>
</html>
