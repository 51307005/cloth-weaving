<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cập nhật đơn hàng khách hàng</title>

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
            #tbl_cap_nhat_don_hang_khach_hang input, #tbl_cap_nhat_don_hang_khach_hang select {
                width: 170px;
            }

            #btn_cap_nhat {
                width: 76px !important;
            }

            input, select {
                padding-left: 5px;
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
                            <h3 style="text-align:center;">CẬP NHẬT ĐƠN HÀNG KHÁCH HÀNG</h3>
                            <!-- FORM CHỌN MÃ ĐƠN HÀNG KHÁCH HÀNG -->
                            <div style="margin-top:20px;margin-left:30px;">
                                {!! Form::open(array('method' => 'post', 'id' => 'frm_chon_ma_don_hang_khach_hang')) !!}
                                    <b>Chọn mã đơn hàng khách hàng:</b>
                                    <select id="IdDonHangKhachHang" name="IdDonHangKhachHang" style="margin-left:5px;margin-right:5px;width:131px;">
                                        @foreach ($list_id_don_hang_khach_hang as $don_hang_khach_hang)
                                            <option value="{{ $don_hang_khach_hang->id }}" {{ (isset($don_hang_khach_hang_duoc_chon) && ($don_hang_khach_hang->id == $don_hang_khach_hang_duoc_chon->id))?'selected':'' }}>
                                                {{ $don_hang_khach_hang->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input id="btn_chon" type="button" value="Chọn" onclick="chonDonHangKhachHang()">
                                    <input type="hidden" name="frm_chon_ma_don_hang_khach_hang" value="true">
                                {!! Form::close() !!}
                            </div>
                            <!-- END FORM CHỌN MÃ ĐƠN HÀNG KHÁCH HÀNG -->
                            @if (isset($errorMessage))
                                <!-- ERROR MESSAGES -->
                                <div id="error_messages" class="alert alert-info" style="text-align:center;color:red;margin-top:12px;margin-left:12px;margin-right:12px;">
                                    {{ $errorMessage }}
                                </div>
                                <!-- END ERROR MESSAGES -->
                            @endif
                            @if (isset($don_hang_khach_hang_duoc_chon))
                                <!-- FORM CẬP NHẬT ĐƠN HÀNG KHÁCH HÀNG -->
                                <div style="margin-left:30px;margin-top:15px;margin-bottom:15px;float:left;width:50%;">
                                    {!! Form::open(array('method' => 'post', 'id' => 'frm_cap_nhat_don_hang_khach_hang')) !!}
                                        <input type="hidden" id="don_hang_khach_hang_cu" name="don_hang_khach_hang_cu" value="{{ $don_hang_khach_hang_cu }}">
                                        <table id="tbl_cap_nhat_don_hang_khach_hang" style="width:370px;height:290px;">
                                            <tr>
                                                <td style="font-weight:bold;">Mã đơn hàng khách hàng:</td>
                                                <td>
                                                    <input type="text" id="idDonHangKhachHang" name="idDonHangKhachHang" value="{{ $don_hang_khach_hang_duoc_chon->id }}" readonly style="background-color:#cccccc;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Khách hàng:</td>
                                                <td>
                                                    <select id="id_khach_hang" name="id_khach_hang">
                                                        @foreach ($list_khach_hang as $khach_hang)
                                                            <option value="{{ $khach_hang->id }}" {{ ($khach_hang->id == $don_hang_khach_hang_duoc_chon->id_khach_hang)?'selected':'' }}>
                                                                {{ $khach_hang->ho_ten }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Loại vải:</td>
                                                <td>
                                                    <select id="id_loai_vai" name="id_loai_vai">
                                                        @foreach ($list_loai_vai as $loai_vai)
                                                            <option value="{{ $loai_vai->id }}" {{ ($loai_vai->id == $don_hang_khach_hang_duoc_chon->id_loai_vai)?'selected':'' }}>
                                                                {{ $loai_vai->ten }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Màu:</td>
                                                <td>
                                                    <select id="id_mau" name="id_mau">
                                                        @foreach ($list_mau as $mau)
                                                            <option value="{{ $mau->id }}" {{ ($mau->id == $don_hang_khach_hang_duoc_chon->id_mau)?'selected':'' }}>
                                                                {{ $mau->ten }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Khổ (m):</td>
                                                <td>
                                                    <select id="kho" name="kho">
                                                        @foreach ($list_kho as $kho)
                                                            <option value="{{ $kho }}" {{ ($kho == $don_hang_khach_hang_duoc_chon->kho)?'selected':'' }}>
                                                                {{ number_format($kho, 1, ',', '.') }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Tổng số mét:</td>
                                                <td>
                                                    <input type="text" id="tong_so_met" name="tong_so_met" value="{{ $don_hang_khach_hang_duoc_chon->tong_so_met }}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Hạn chót:</td>
                                                <td>
                                                    <input type="text" id="han_chot" name="han_chot" value="{{ $don_hang_khach_hang_duoc_chon->han_chot }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Ngày giờ đặt hàng:</td>
                                                <td>
                                                    <input type="text" id="ngay_gio_dat_hang" name="ngay_gio_dat_hang" value="{{ $don_hang_khach_hang_duoc_chon->ngay_gio_dat_hang }}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Tình trạng:</td>
                                                <td>
                                                    <input type="text" id="tinh_trang" name="tinh_trang" value="{{ $don_hang_khach_hang_duoc_chon->tinh_trang }}" readonly style="background-color:#cccccc;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <input id="btn_cap_nhat" type="button" value="Cập nhật" onclick="capNhatDonHangKhachHang()">
                                                </td>
                                            </tr>
                                        </table>
                                    {!! Form::close() !!}
                                </div>
                                <script>
                                    $('#tong_so_met').numeric({
                                        decimal: false,
                                        negative: false
                                    });

                                    $('#han_chot').datepicker({
                                        dateFormat: 'yy-mm-dd'
                                    });

                                    $('#ngay_gio_dat_hang').datetimepicker({
                                        dateFormat: 'yy-mm-dd',
                                        timeFormat: 'HH:mm:ss'
                                    });
                                </script>
                                <!-- END FORM CẬP NHẬT ĐƠN HÀNG KHÁCH HÀNG -->
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
            function chonDonHangKhachHang()
            {
                // Submit
                var id_don_hang_khach_hang = $('#IdDonHangKhachHang').val();
                var url = "{{ url('/') }}/he_thong_quan_ly/ban_hang/cap_nhat_don_hang_khach_hang/" + id_don_hang_khach_hang;
                $('#frm_chon_ma_don_hang_khach_hang').attr('action', url);
                $('#frm_chon_ma_don_hang_khach_hang').submit();
            }

            function capNhatDonHangKhachHang()
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
                var id_don_hang_khach_hang = $('#idDonHangKhachHang').val();
                var url = "{{ url('/') }}/he_thong_quan_ly/ban_hang/cap_nhat_don_hang_khach_hang/" + id_don_hang_khach_hang;
                $('#frm_cap_nhat_don_hang_khach_hang').attr('action', url);
                $('#frm_cap_nhat_don_hang_khach_hang').submit();
            }
        </script>
    </body>
</html>
