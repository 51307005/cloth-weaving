<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Thêm hóa đơn xuất</title>

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
            #tbl_them_hoa_don_xuat input, select {
                width: 170px;
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
                            <h3 style="text-align:center;">THÊM HÓA ĐƠN XUẤT</h3>
                            <!-- FORM THÊM HÓA ĐƠN XUẤT -->
                            <div style="margin-top:10px;margin-left:30px;margin-bottom:10px;float:left;width:50%;">
                                {!! Form::open(array('route' => 'route_post_them_hoa_don_xuat', 'method' => 'post', 'id' => 'frm_them_hoa_don_xuat')) !!}
                                    <table id="tbl_them_hoa_don_xuat" style="width:375px;height:410px;">
                                        <tr>
                                            <td style="font-weight:bold;">Mã hóa đơn xuất:</td>
                                            <td>
                                                <input type="text" id="id_hoa_don_xuat" name="id_hoa_don_xuat" value="{{ $id_hoa_don_xuat_cuoi_cung + 1 }}" readonly style="background-color:#cccccc;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Mã đơn hàng khách hàng:</td>
                                            <td>
                                                <select id="id_don_hang_khach_hang" name="id_don_hang_khach_hang" onchange="showThongTinDonHangKhachHang($(this).val())">
                                                    <option value="null"></option>
                                                    @foreach ($listIdDonHangKhachHangChuaHoanThanh_Moi as $don_hang_khach_hang)
                                                        <option value="{{ $don_hang_khach_hang->id }}">{{ $don_hang_khach_hang->id }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Khách hàng:</td>
                                            <td>
                                                <input type="text" id="khach_hang" name="khach_hang" value="" readonly style="background-color:#cccccc;">
                                                <input type="hidden" id="id_khach_hang" name="id_khach_hang" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Loại vải:</td>
                                            <td>
                                                <input type="text" id="loai_vai" name="loai_vai" value="" readonly style="background-color:#cccccc;">
                                                <input type="hidden" id="id_loai_vai" name="id_loai_vai" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Màu:</td>
                                            <td>
                                                <input type="text" id="mau" name="mau" value="" readonly style="background-color:#cccccc;">
                                                <input type="hidden" id="id_mau" name="id_mau" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Khổ (m):</td>
                                            <td>
                                                <input type="text" id="Kho" name="Kho" value="" readonly style="background-color:#cccccc;">
                                                <input type="hidden" id="kho" name="kho" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Tổng số cây vải:</td>
                                            <td>
                                                <input type="text" id="tong_so_cay_vai" name="tong_so_cay_vai" value="" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Tổng số mét:</td>
                                            <td>
                                                <input type="text" id="tong_so_met" name="tong_so_met" value="" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Tổng tiền (VNĐ):</td>
                                            <td>
                                                <input type="text" id="tong_tien" name="tong_tien" value="" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Kho:</td>
                                            <td>
                                                <select id="id_kho" name="id_kho">
                                                    @foreach ($list_kho_thanh_pham as $kho_thanh_pham)
                                                        <option value="{{ $kho_thanh_pham->id }}">{{ $kho_thanh_pham->ten }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Nhân viên xuất hóa đơn:</td>
                                            <td>
                                                <select id="id_nhan_vien_xuat" name="id_nhan_vien_xuat">
                                                    @foreach ($list_nhan_vien_xuat_hoa_don as $nhan_vien_xuat_hoa_don)
                                                        <option value="{{ $nhan_vien_xuat_hoa_don->id }}">{{ $nhan_vien_xuat_hoa_don->ho_ten }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Ngày giờ xuất hóa đơn:</td>
                                            <td>
                                                <input type="text" id="ngay_gio_xuat_hoa_don" name="ngay_gio_xuat_hoa_don" value="" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Tính chất:</td>
                                            <td>
                                                <select id="tinh_chat" name="tinh_chat">
                                                    @foreach ($list_tinh_chat as $tinh_chat)
                                                        <option value="{{ $tinh_chat }}">{{ $tinh_chat }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <input type="button" id="btn_them" value="Thêm" onclick="themHoaDonXuat()">
                                            </td>
                                        </tr>
                                    </table>
                                {!! Form::close() !!}
                            </div>
                            <!-- END FORM THÊM HÓA ĐƠN XUẤT -->
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
            $('#ngay_gio_xuat_hoa_don').datetimepicker({
                dateFormat: 'yy-mm-dd',
                timeFormat: 'HH:mm:ss'
            });

            $('#tong_so_cay_vai, #tong_so_met, #tong_tien').numeric({
                decimal: false,
                negative: false
            });

            function showThongTinDonHangKhachHang(id_don_hang_khach_hang)
            {
                // Trường hợp: id_don_hang_khach_hang = null
                if (id_don_hang_khach_hang == 'null')
                {
                    // Xóa thông tin đơn hàng khách hàng trước đó
                    $('#khach_hang').val('');
                    $('#id_khach_hang').val('');
                    $('#loai_vai').val('');
                    $('#id_loai_vai').val('');
                    $('#mau').val('');
                    $('#id_mau').val('');
                    $('#Kho').val('');
                    $('#kho').val('');
                }
                else
                {
                    // Thiết lập Ajax
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // Lấy thông tin đơn hàng khách hàng mà user đã chọn
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('route_post_show_thong_tin_don_hang_khach_hang') }}",
                        data: {id_don_hang_khach_hang: id_don_hang_khach_hang},
                        dataType: 'json'
                    }).done(function(don_hang_khach_hang_duoc_chon) {
                            // Show thông tin đơn hàng khách hàng mà user đã chọn
                            $('#khach_hang').val(don_hang_khach_hang_duoc_chon.ten_khach_hang);
                            $('#id_khach_hang').val(don_hang_khach_hang_duoc_chon.id_khach_hang);
                            $('#loai_vai').val(don_hang_khach_hang_duoc_chon.ten_loai_vai);
                            $('#id_loai_vai').val(don_hang_khach_hang_duoc_chon.id_loai_vai);
                            $('#mau').val(don_hang_khach_hang_duoc_chon.ten_mau);
                            $('#id_mau').val(don_hang_khach_hang_duoc_chon.id_mau);
                            $('#Kho').val($.number(don_hang_khach_hang_duoc_chon.kho, 1, ',', '.'));
                            $('#kho').val(don_hang_khach_hang_duoc_chon.kho);
                       })
                      .fail(function(jqXHR, textStatus) {
                            alert('Request failed: ' + textStatus);
                       });
                }
            }

            function themHoaDonXuat()
            {
                // Validate Mã đơn hàng khách hàng
                var id_don_hang_khach_hang = $('#id_don_hang_khach_hang').val();
                if (id_don_hang_khach_hang == 'null')
                {
                    alert('Mã đơn hàng khách hàng không hợp lệ !');
                    return false;
                }

                // Validate Tổng số cây vải
                var tong_so_cay_vai = $('#tong_so_cay_vai').val();
                if (tong_so_cay_vai == '')
                {
                    alert('Bạn chưa nhập tổng số cây vải !');
                    return false;
                }
                else if (parseInt(tong_so_cay_vai) == 0)
                {
                    alert('Tổng số cây vải ít nhất phải là 1 !');
                    return false;
                }

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

                // Validate Tổng tiền
                var tong_tien = $('#tong_tien').val();
                if (tong_tien == '')
                {
                    alert('Bạn chưa nhập tổng tiền !');
                    return false;
                }
                else if (parseInt(tong_tien) == 0)
                {
                    alert('Tổng tiền ít nhất phải là 1 !');
                    return false;
                }

                // Validate Ngày giờ xuất hóa đơn
                var ngay_gio_xuat_hoa_don = $('#ngay_gio_xuat_hoa_don').val();
                if (ngay_gio_xuat_hoa_don == '')
                {
                    alert('Bạn chưa nhập ngày giờ xuất hóa đơn !');
                    return false;
                }
                else
                {
                    var ngayGioXuatHoaDon = new Date(ngay_gio_xuat_hoa_don);
                    if (isNaN(ngayGioXuatHoaDon))
                    {
                        alert('Ngày giờ xuất hóa đơn không hợp lệ !');
                        return false;
                    }
                }

                // Validate successful
                // Submit
                //var url = "{{ route('route_post_them_hoa_don_xuat') }}";
                //$('#frm_them_hoa_don_xuat').attr('action', url);
                $('#frm_them_hoa_don_xuat').submit();
            }
        </script>
    </body>
</html>
