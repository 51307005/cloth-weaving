<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Cập nhật cây thành phẩm</title>

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
            #tbl_cap_nhat_cay_thanh_pham input, select {
                width: 255px;
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
                            <h3 style="text-align:center;">CẬP NHẬT CÂY VẢI THÀNH PHẨM</h3>
                            <!-- FORM CHỌN MÃ CÂY VẢI THÀNH PHẨM -->
                            <div style="margin-top:20px;margin-left:30px;">
                                {!! Form::open(array('method' => 'post', 'id' => 'frm_chon_ma_cay_thanh_pham')) !!}
                                    <b>Chọn mã cây thành phẩm:</b>
                                    <select id="IdCayThanhPham" name="IdCayThanhPham" style="margin-left:5px;margin-right:5px;width:215px;">
                                        @foreach ($list_id_cay_thanh_pham as $cay_thanh_pham)
                                            <option value="{{ $cay_thanh_pham->id }}" {{ (isset($cay_thanh_pham_duoc_chon) && ($cay_thanh_pham->id == $cay_thanh_pham_duoc_chon->id))?'selected':'' }}>
                                                {{ $cay_thanh_pham->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input id="btn_chon" type="button" value="Chọn" onclick="chonCayThanhPham()">
                                    <input type="hidden" name="frm_chon_ma_cay_thanh_pham" value="true">
                                {!! Form::close() !!}
                            </div>
                            <!-- END FORM CHỌN MÃ CÂY VẢI THÀNH PHẨM -->
                            @if (isset($errorMessage))
                                <!-- ERROR MESSAGES -->
                                <div id="error_messages" class="alert alert-info" style="text-align:center;color:red;margin-top:12px;margin-left:12px;">
                                    {{ $errorMessage }}
                                </div>
                                <!-- END ERROR MESSAGES -->
                            @endif
                            @if (isset($cay_thanh_pham_duoc_chon))
                                <!-- FORM CẬP NHẬT CÂY VẢI THÀNH PHẨM -->
                                <div style="margin-left:30px;margin-top:15px;margin-bottom:15px;float:left;width:50%;">
                                    {!! Form::open(array('method' => 'post', 'id' => 'frm_cap_nhat_cay_thanh_pham')) !!}
                                        <input type="hidden" id="cay_thanh_pham_cu" name="cay_thanh_pham_cu" value="{{ $cay_thanh_pham_cu }}">
                                        <table id="tbl_cap_nhat_cay_thanh_pham" style="width:420px;height:380px;">
                                            <tr>
                                                <td style="font-weight:bold;">Mã cây thành phẩm:</td>
                                                <td>
                                                    <input type="text" id="idCayThanhPham" name="idCayThanhPham" value="{{ $cay_thanh_pham_duoc_chon->id }}" readonly style="background-color:#cccccc;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Mã cây mộc:</td>
                                                <td>
                                                    <select id="id_cay_moc" name="id_cay_moc" onchange="showLoaiVai($(this).val())">
                                                        @foreach ($list_id_cay_moc as $id_cay_moc)
                                                            <option value="{{ $id_cay_moc }}" {{ ($id_cay_moc == $cay_thanh_pham_duoc_chon->id_cay_vai_moc)?'selected':'' }}>
                                                                {{ $id_cay_moc }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Loại vải:</td>
                                                <td>
                                                    <input type="text" id="loaiVai" name="loaiVai" value="{{ $cay_thanh_pham_duoc_chon->ten_loai_vai }}" readonly style="background-color:#cccccc;">
                                                    <input type="hidden" id="id_loai_vai" name="id_loai_vai" value="{{ $cay_thanh_pham_duoc_chon->id_loai_vai }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Màu:</td>
                                                <td>
                                                    <input type="text" id="mau" name="mau" value="{{ $cay_thanh_pham_duoc_chon->ten_mau }}" readonly style="background-color:#cccccc;">
                                                    <input type="hidden" id="id_mau" name="id_mau" value="{{ $cay_thanh_pham_duoc_chon->id_mau }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Khổ (m):</td>
                                                <td>
                                                    <select id="kho" name="kho">
                                                        @foreach ($list_kho as $kho)
                                                            <option value="{{ $kho }}" {{ ($kho == $cay_thanh_pham_duoc_chon->kho)?'selected':'' }}>
                                                                {{ number_format($kho, 1, ',', '.') }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Số mét:</td>
                                                <td>
                                                    <input type="text" id="so_met" name="so_met" value="{{ $cay_thanh_pham_duoc_chon->so_met }}" required onchange="tinhThanhTien()">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Đơn giá (VNĐ/m):</td>
                                                <td>
                                                    <input type="text" id="don_gia" name="don_gia" value="{{ $cay_thanh_pham_duoc_chon->don_gia }}" onchange="tinhThanhTien()">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Thành tiền (VNĐ):</td>
                                                <td>
                                                    <input type="text" id="thanh_tien" name="thanh_tien" value="{{ $cay_thanh_pham_duoc_chon->thanh_tien }}" readonly style="background-color:#cccccc;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Mã lô nhuộm:</td>
                                                <td>
                                                    <select id="id_lo_nhuom" name="id_lo_nhuom" onchange="showMau($(this).val())">
                                                        @foreach ($list_id_lo_nhuom as $lo_nhuom)
                                                            <option value="{{ $lo_nhuom->id }}" {{ ($lo_nhuom->id == $cay_thanh_pham_duoc_chon->id_lo_nhuom)?'selected':'' }}>
                                                                {{ $lo_nhuom->id }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Kho:</td>
                                                <td>
                                                    <select id="id_kho" name="id_kho">
                                                        @foreach ($list_kho_thanh_pham as $kho_thanh_pham)
                                                            <option value="{{ $kho_thanh_pham->id }}" {{ ($kho_thanh_pham->id == $cay_thanh_pham_duoc_chon->id_kho)?'selected':'' }}>
                                                                {{ $kho_thanh_pham->ten }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Ngày giờ nhập kho:</td>
                                                <td>
                                                    <input type="text" id="ngay_gio_nhap_kho" name="ngay_gio_nhap_kho" value="{{ $cay_thanh_pham_duoc_chon->ngay_gio_nhap_kho }}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Mã hóa đơn xuất:</td>
                                                <td>
                                                    <select id="id_hoa_don_xuat" name="id_hoa_don_xuat">
                                                        <option value="null">null</option>
                                                        @foreach ($list_id_hoa_don_xuat as $hoa_don_xuat)
                                                            <option value="{{ $hoa_don_xuat->id }}" {{ ($hoa_don_xuat->id == $cay_thanh_pham_duoc_chon->id_hoa_don_xuat)?'selected':'' }}>
                                                                {{ $hoa_don_xuat->id }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Tình trạng:</td>
                                                <td>
                                                    <select id="tinh_trang" name="tinh_trang">
                                                        @foreach ($list_tinh_trang as $tinh_trang)
                                                            <option value="{{ $tinh_trang }}" {{ ($tinh_trang == $cay_thanh_pham_duoc_chon->tinh_trang)?'selected':'' }}>
                                                                {{ $tinh_trang }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <input id="btn_cap_nhat" type="button" value="Cập nhật" onclick="capNhatCayThanhPham()">
                                                </td>
                                            </tr>
                                        </table>
                                    {!! Form::close() !!}
                                </div>
                                <script>
                                    $('#ngay_gio_nhap_kho').datetimepicker({
                                        dateFormat: 'yy-mm-dd',
                                        timeFormat: 'HH:mm:ss'
                                    });

                                    $('#so_met, #don_gia').numeric({
                                        decimal: false,
                                        negative: false
                                    });
                                </script>
                                <!-- END FORM CẬP NHẬT CÂY VẢI THÀNH PHẨM -->
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
            function chonCayThanhPham()
            {
                // Submit
                var id_cay_thanh_pham = $('#IdCayThanhPham').val();
                var url = "{{ url('/') }}/he_thong_quan_ly/kho/cap_nhat_cay_vai_thanh_pham/" + id_cay_thanh_pham;
                $('#frm_chon_ma_cay_thanh_pham').attr('action', url);
                $('#frm_chon_ma_cay_thanh_pham').submit();
            }

            function tinhThanhTien()
            {
                var so_met = $('#so_met').val();
                var don_gia = $('#don_gia').val();
                var thanh_tien;

                if (so_met == '' || don_gia == '' || parseInt(so_met) == 0 || parseInt(don_gia) == 0)
                {
                    thanh_tien = '';
                }
                else
                {
                    thanh_tien = parseInt(so_met) * parseInt(don_gia);
                }

                $('#thanh_tien').val(thanh_tien);
            }

            function showLoaiVai(id_cay_moc)
            {
                // Thiết lập Ajax
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Lấy thông tin cây mộc mà user đã chọn từ database
                $.ajax({
                    method: 'POST',
                    url: "{{ route('route_post_show_loai_vai') }}",
                    data: {id_cay_moc: id_cay_moc},
                    dataType: 'json'
                }).done(function(cay_moc_duoc_chon) {
                        // Show loại vải tương ứng với cây mộc mà user đã chọn
                        $('#loaiVai').val(cay_moc_duoc_chon.ten_loai_vai);
                        $('#id_loai_vai').val(cay_moc_duoc_chon.id_loai_vai);
                   })
                  .fail(function(jqXHR, textStatus) {
                        alert('Request failed: ' + textStatus);
                   });
            }

            function showMau(id_lo_nhuom)
            {
                // Thiết lập Ajax
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Lấy thông tin lô nhuộm mà user đã chọn từ database
                $.ajax({
                    method: 'POST',
                    url: "{{ route('route_post_show_mau') }}",
                    data: {id_lo_nhuom: id_lo_nhuom},
                    dataType: 'json'
                }).done(function(lo_nhuom_duoc_chon) {
                        // Show màu tương ứng với lô nhuộm mà user đã chọn
                        $('#mau').val(lo_nhuom_duoc_chon.ten_mau);
                        $('#id_mau').val(lo_nhuom_duoc_chon.id_mau);
                   })
                  .fail(function(jqXHR, textStatus) {
                        alert('Request failed: ' + textStatus);
                   });
            }

            function capNhatCayThanhPham()
            {
                // Validate Số mét
                var so_met = $('#so_met').val();
                if (so_met == '')
                {
                    alert('Bạn chưa nhập số mét cây thành phẩm !');
                    return false;
                }
                else if (parseInt(so_met) == 0)
                {
                    alert('Số mét cây thành phẩm ít nhất phải là 1 !');
                    return false;
                }

                // Validate Đơn giá
                var don_gia = $('#don_gia').val();
                if (don_gia != '' && parseInt(don_gia) == 0)
                {
                    alert('Đơn giá ít nhất phải là 1 hoặc có thể để trống không nhập !');
                    return false;
                }

                // Validate Ngày giờ nhập kho
                var ngay_gio_nhap_kho = $('#ngay_gio_nhap_kho').val();
                if (ngay_gio_nhap_kho == '')
                {
                    alert('Bạn chưa nhập ngày giờ nhập kho !');
                    return false;
                }
                else
                {
                    var ngayGioNhapKho = new Date(ngay_gio_nhap_kho);
                    if (isNaN(ngayGioNhapKho))
                    {
                        alert('Ngày giờ nhập kho không hợp lệ !');
                        return false;
                    }
                }

                // Validate mối liên hệ logic giữa: Mã hóa đơn xuất và Tình trạng
                var id_hoa_don_xuat = $('#id_hoa_don_xuat').val();
                var tinh_trang = $('#tinh_trang').val();
                if (id_hoa_don_xuat == 'null' && tinh_trang == 'Đã xuất')   // Cây thành phẩm chưa được xuất, còn tồn kho nhưng tình trạng lại là "Đã xuất"
                {
                    alert('Mã hóa đơn xuất là null thì tình trạng phải là chưa xuất !');
                    return false;
                }
                if (id_hoa_don_xuat != 'null' && tinh_trang == 'Chưa xuất')     // Cây thành phẩm nằm trong 1 hóa đơn xuất nhưng tình trạng lại là "Chưa xuất"
                {
                    alert('Mã hóa đơn xuất có tồn tại thì tình trạng phải là đã xuất !');
                    return false;
                }

                // Validate successful
                // Submit
                var id_cay_thanh_pham = $('#idCayThanhPham').val();
                var url = "{{ url('/') }}/he_thong_quan_ly/kho/cap_nhat_cay_vai_thanh_pham/" + id_cay_thanh_pham;
                $('#frm_cap_nhat_cay_thanh_pham').attr('action', url);
                $('#frm_cap_nhat_cay_thanh_pham').submit();
            }
        </script>
    </body>
</html>
