<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cập nhật cây mộc</title>

        <link href="{{ url('/') }}/resources/assets/css/jquery-ui-1.11.4.css" type="text/css" rel="stylesheet">
        <link href="{{ url('/') }}/resources/assets/css/jquery-ui-timepicker.css" type="text/css" rel="stylesheet">
        <link href="{{ url('/') }}/resources/assets/css/bootstrap-3.3.7.css" type="text/css" rel="stylesheet">
        <script src="{{ url('/') }}/resources/assets/js/jquery-3.1.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/jquery-ui-1.11.4.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/jquery-ui-timepicker-1.6.3.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/jquery-numeric-1.4.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/bootstrap-3.3.7.js" type="text/javascript"></script>

        <style>
            #tbl_cap_nhat_cay_moc input, select {
                width: 250px;
            }

            #btn_cap_nhat {
                width: 76px !important;
            }
        </style>
    </head>
    <body>
        <div id="container" class="container" style="margin-bottom:20px;">
            <div id="content">
                <!-- HEADER -->
                <div style="margin-top:15px;border:1px solid black;">
                    <div style="float:left;width:93%;text-align:center;color:red;">
                        <h2>QUẢN LÝ KHO</h2>
                    </div>
                    <div style="float:left;width:7%;margin-top:28px;">
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
                            <h3 style="text-align:center;">CẬP NHẬT CÂY MỘC</h3>
                            <!-- FORM CHỌN MÃ CÂY MỘC -->
                            <div style="margin-top:20px;margin-left:30px;">
                                {!! Form::open(array('method' => 'post', 'id' => 'frm_chon_ma_cay_moc')) !!}
                                    <b>Chọn mã cây mộc:</b>
                                    <select id="IdCayMoc" name="IdCayMoc" style="margin-left:16px;margin-right:5px;">
                                        @foreach ($list_id_cay_moc as $cay_moc)
                                            <option value="{{ $cay_moc->id }}" {{ (isset($cay_moc_duoc_chon) && ($cay_moc->id == $cay_moc_duoc_chon->id))?'selected':'' }}>{{ $cay_moc->id }}</option>
                                        @endforeach
                                    </select>
                                    <input id="btn_chon" type="button" value="Chọn" onclick="chonCayMoc()">
                                    <input type="hidden" name="frm_chon_ma_cay_moc" value="true">
                                {!! Form::close() !!}
                            </div>
                            <!-- END FORM CHỌN MÃ CÂY MỘC -->
                            @if (isset($errorMessage))
                                <!-- ERROR MESSAGES -->
                                <div id="error_messages" class="alert alert-info" style="text-align:center;color:red;margin-top:12px;margin-left:12px;">
                                    {{ $errorMessage }}
                                </div>
                                <!-- END ERROR MESSAGES -->
                            @endif
                            @if (isset($cay_moc_duoc_chon))
                                <!-- FORM CẬP NHẬT CÂY MỘC -->
                                <div style="margin-left:30px;margin-top:15px;margin-bottom:15px;float:left;width:50%;">
                                    {!! Form::open(array('method' => 'post', 'id' => 'frm_cap_nhat_cay_moc')) !!}
                                    <table id="tbl_cap_nhat_cay_moc" style="width:410px;height:360px;">
                                            <tr>
                                                <td style="font-weight:bold;">Mã cây mộc:</td>
                                                <td>
                                                    <input type="text" id="idCayMoc" name="idCayMoc" value="{{ $cay_moc_duoc_chon->id }}" readonly style="background-color:#cccccc;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Loại vải:</td>
                                                <td>
                                                    <select id="id_loai_vai" name="id_loai_vai">
                                                        @foreach ($list_loai_vai as $loai_vai)
                                                            <option value="{{ $loai_vai->id }}" {{ ($loai_vai->id == $cay_moc_duoc_chon->id_loai_vai)?'selected':'' }}>
                                                                {{ $loai_vai->ten }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Loại sợi:</td>
                                                <td>
                                                    <select id="id_loai_soi" name="id_loai_soi">
                                                        @foreach ($list_loai_soi as $loai_soi)
                                                            <option value="{{ $loai_soi->id }}" {{ ($loai_soi->id == $cay_moc_duoc_chon->id_loai_soi)?'selected':'' }}>
                                                                {{ $loai_soi->ten }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Số mét:</td>
                                                <td>
                                                    <input type="text" id="so_met" name="so_met" value="{{ $cay_moc_duoc_chon->so_met }}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Nhân viên dệt:</td>
                                                <td>
                                                    <select id="id_nhan_vien_det" name="id_nhan_vien_det">
                                                        @foreach ($list_nhan_vien_det as $nhan_vien_det)
                                                            <option value="{{ $nhan_vien_det->id }}" {{ ($nhan_vien_det->id == $cay_moc_duoc_chon->id_nhan_vien_det)?'selected':'' }}>
                                                                {{ $nhan_vien_det->ho_ten }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Mã máy dệt:</td>
                                                <td>
                                                    <select id="id_may_det" name="id_may_det">
                                                        @foreach ($list_ma_may_det as $idMayDet)
                                                            <option value="{{ $idMayDet }}" {{ ($idMayDet == $cay_moc_duoc_chon->ma_may_det)?'selected':'' }}>
                                                                {{ $idMayDet }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Ngày giờ dệt:</td>
                                                <td>
                                                    <input type="text" id="ngay_gio_det" name="ngay_gio_det" value="{{ $cay_moc_duoc_chon->ngay_gio_det }}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Kho:</td>
                                                <td>
                                                    <select id="id_kho" name="id_kho">
                                                        @foreach ($list_kho_moc as $kho_moc)
                                                            <option value="{{ $kho_moc->id }}" {{ ($kho_moc->id == $cay_moc_duoc_chon->id_kho)?'selected':'' }}>
                                                                {{ $kho_moc->ten }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Ngày giờ nhập kho:</td>
                                                <td>
                                                    <input type="text" id="ngay_gio_nhap_kho" name="ngay_gio_nhap_kho" value="{{ $cay_moc_duoc_chon->ngay_gio_nhap_kho }}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Mã phiếu xuất mộc:</td>
                                                <td>
                                                    <select id="id_phieu_xuat_moc" name="id_phieu_xuat_moc">
                                                        <option value="null">null</option>
                                                        @foreach ($list_id_phieu_xuat_moc as $phieu_xuat_moc)
                                                            <option value="{{ $phieu_xuat_moc->id }}" {{ ($phieu_xuat_moc->id == $cay_moc_duoc_chon->id_phieu_xuat_moc)?'selected':'' }}>
                                                                {{ $phieu_xuat_moc->id }}
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
                                                            <option value="{{ $tinh_trang }}" {{ ($tinh_trang == $cay_moc_duoc_chon->tinh_trang)?'selected':'' }}>
                                                                {{ $tinh_trang }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Mã lô nhuộm:</td>
                                                <td>
                                                    <select id="id_lo_nhuom" name="id_lo_nhuom">
                                                        <option value="null">null</option>
                                                        @foreach ($list_id_lo_nhuom as $lo_nhuom)
                                                            <option value="{{ $lo_nhuom->id }}" {{ ($lo_nhuom->id == $cay_moc_duoc_chon->id_lo_nhuom)?'selected':'' }}>
                                                                {{ $lo_nhuom->id }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <input id="btn_cap_nhat" type="button" value="Cập nhật" onclick="capNhatCayMoc()">
                                                </td>
                                            </tr>
                                        </table>
                                    {!! Form::close() !!}
                                </div>
                                <script>
                                    $('#ngay_gio_det, #ngay_gio_nhap_kho').datetimepicker({
                                        dateFormat: 'yy-mm-dd',
                                        timeFormat: 'HH:mm:ss'
                                    });

                                    $('#so_met').numeric({
                                        decimal: false,
                                        negative: false
                                    });
                                </script>
                                <!-- END FORM CẬP NHẬT CÂY MỘC -->
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
            function chonCayMoc()
            {
                // Submit
                var id_cay_moc = $('#IdCayMoc').val();
                var url = "{{ url('/') }}/he_thong_quan_ly/kho/cap_nhat_cay_moc/" + id_cay_moc;
                $('#frm_chon_ma_cay_moc').attr('action', url);
                $('#frm_chon_ma_cay_moc').submit();
            }

            function capNhatCayMoc()
            {
                // Validate Số mét
                var so_met = $('#so_met').val();
                if (so_met == '')
                {
                    alert('Bạn chưa nhập số mét cây mộc !');
                    return false;
                }
                else if (parseInt(so_met) == 0)
                {
                    alert('Số mét cây mộc ít nhất phải là 1 !');
                    return false;
                }

                // Validate Ngày giờ dệt
                var ngay_gio_det = $('#ngay_gio_det').val();
                if (ngay_gio_det == '')
                {
                    alert('Bạn chưa nhập ngày giờ dệt !');
                    return false;
                }
                else
                {
                    var ngayGioDet = new Date(ngay_gio_det);
                    if (isNaN(ngayGioDet))
                    {
                        alert('Ngày giờ dệt không hợp lệ !');
                        return false;
                    }
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

                // Validate trường hợp: Ngày giờ dệt >= Ngày giờ nhập kho
                var ngaygiodet = new Date(ngay_gio_det);
                var ngaygionhapkho = new Date(ngay_gio_nhap_kho);
                if (ngaygiodet.getTime() >= ngaygionhapkho.getTime())
                {
                    alert('Ngày giờ dệt phải trước ngày giờ nhập kho !');
                    return false;
                }

                // Validate mối liên hệ logic giữa: Mã phiếu xuất mộc, Tình trạng và Mã lô nhuộm
                var id_phieu_xuat_moc = $('#id_phieu_xuat_moc').val();
                if (id_phieu_xuat_moc == 'null')    // Cây mộc chưa được xuất, còn tồn kho
                {
                    // Kiểm tra tình trạng
                    var tinh_trang = $('#tinh_trang').val();
                    if (tinh_trang == 'Đã xuất')
                    {
                        alert('Mã phiếu xuất mộc là null thì tình trạng phải là chưa xuất !');
                        return false;
                    }

                    // Kiểm tra mã lô nhuộm
                    var id_lo_nhuom = $('#id_lo_nhuom').val();
                    if (id_lo_nhuom != 'null')
                    {
                        alert('Mã phiếu xuất mộc là null thì mã lô nhuộm phải là null !');
                        return false;
                    }
                }
                else    // Cây mộc đã được xuất
                {
                    // Kiểm tra tình trạng
                    var tinh_trang = $('#tinh_trang').val();
                    if (tinh_trang == 'Chưa xuất')
                    {
                        alert('Mã phiếu xuất mộc có tồn tại thì tình trạng phải là đã xuất !');
                        return false;
                    }
                }

                // Validate successful
                // Submit
                var id_cay_moc = $('#idCayMoc').val();
                var url = "{{ url('/') }}/he_thong_quan_ly/kho/cap_nhat_cay_moc/" + id_cay_moc;
                $('#frm_cap_nhat_cay_moc').attr('action', url);
                $('#frm_cap_nhat_cay_moc').submit();
            }
        </script>
    </body>
</html>
