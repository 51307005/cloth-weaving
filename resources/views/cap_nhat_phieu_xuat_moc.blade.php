<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cập nhật phiếu xuất mộc</title>

        <link href="{{ url('/') }}/resources/assets/css/jquery-ui-1.11.4.css" type="text/css" rel="stylesheet">
        <link href="{{ url('/') }}/resources/assets/css/jquery-ui-timepicker.css" type="text/css" rel="stylesheet">
        <link href="{{ url('/') }}/resources/assets/css/bootstrap-3.3.7.css" type="text/css" rel="stylesheet">
        <script src="{{ url('/') }}/resources/assets/js/jquery-3.1.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/jquery-ui-1.11.4.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/jquery-ui-timepicker-1.6.3.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/jquery-numeric-1.4.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/bootstrap-3.3.7.js" type="text/javascript"></script>

        <style>
            #tbl_cap_nhat_phieu_xuat_moc input, #tbl_cap_nhat_phieu_xuat_moc select {
                width: 160px;
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
                            <h3 style="text-align:center;">CẬP NHẬT PHIẾU XUẤT MỘC</h3>
                            <!-- FORM CHỌN MÃ PHIẾU XUẤT MỘC -->
                            <div style="margin-top:20px;margin-left:30px;">
                                {!! Form::open(array('method' => 'post', 'id' => 'frm_chon_ma_phieu_xuat_moc')) !!}
                                    <b>Chọn mã phiếu xuất mộc:</b>
                                    <select id="IdPhieuXuatMoc" name="IdPhieuXuatMoc" style="margin-left:5px;margin-right:5px;width:121px;">
                                        @foreach ($list_id_phieu_xuat_moc as $phieu_xuat_moc)
                                            <option value="{{ $phieu_xuat_moc->id }}" {{ (isset($phieu_xuat_moc_duoc_chon) && ($phieu_xuat_moc->id == $phieu_xuat_moc_duoc_chon->id))?'selected':'' }}>
                                                {{ $phieu_xuat_moc->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input id="btn_chon" type="button" value="Chọn" onclick="chonPhieuXuatMoc()">
                                    <input type="hidden" name="frm_chon_ma_phieu_xuat_moc" value="true">
                                {!! Form::close() !!}
                            </div>
                            <!-- END FORM CHỌN MÃ PHIẾU XUẤT MỘC -->
                            @if (isset($errorMessage))
                                <!-- ERROR MESSAGES -->
                                <div id="error_messages" class="alert alert-info" style="text-align:center;color:red;margin-top:12px;margin-left:12px;">
                                    {{ $errorMessage }}
                                </div>
                                <!-- END ERROR MESSAGES -->
                            @endif
                            @if (isset($phieu_xuat_moc_duoc_chon))
                                <!-- FORM CẬP NHẬT PHIẾU XUẤT MỘC -->
                                <div style="margin-left:30px;margin-top:15px;margin-bottom:15px;float:left;width:50%;">
                                    {!! Form::open(array('method' => 'post', 'id' => 'frm_cap_nhat_phieu_xuat_moc')) !!}
                                        <table id="tbl_cap_nhat_phieu_xuat_moc" style="width:320px;height:210px;">
                                            <tr>
                                                <td style="font-weight:bold;">Mã phiếu xuất mộc:</td>
                                                <td>
                                                    <input type="text" id="idPhieuXuatMoc" name="idPhieuXuatMoc" value="{{ $phieu_xuat_moc_duoc_chon->id }}" readonly style="background-color:#cccccc;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Tổng số cây mộc:</td>
                                                <td>
                                                    <input type="text" id="tong_so_cay_moc" name="tong_so_cay_moc" value="{{ number_format($phieu_xuat_moc_duoc_chon->tong_so_cay_moc, 0, ',', '.') }}" readonly style="background-color:#cccccc;">
                                                    <input type="hidden" id="tongSoCayMoc" name="tongSoCayMoc" value="{{ $phieu_xuat_moc_duoc_chon->tong_so_cay_moc }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Tổng số mét:</td>
                                                <td>
                                                    <input type="text" id="tong_so_met" name="tong_so_met" value="{{ number_format($phieu_xuat_moc_duoc_chon->tong_so_met, 0, ',', '.') }}" readonly style="background-color:#cccccc;">
                                                    <input type="hidden" id="tongSoMet" name="tongSoMet" value="{{ $phieu_xuat_moc_duoc_chon->tong_so_met }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Kho:</td>
                                                <td>
                                                    <select id="id_kho" name="id_kho">
                                                        @foreach ($list_kho_moc as $kho_moc)
                                                            <option value="{{ $kho_moc->id }}" {{ ($kho_moc->id == $phieu_xuat_moc_duoc_chon->id_kho)?'selected':'' }}>
                                                                {{ $kho_moc->ten }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Nhân viên xuất:</td>
                                                <td>
                                                    <select id="id_nhan_vien_xuat" name="id_nhan_vien_xuat">
                                                        @foreach ($list_nhan_vien_kho_moc as $nhan_vien_kho_moc)
                                                            <option value="{{ $nhan_vien_kho_moc->id }}" {{ ($nhan_vien_kho_moc->id == $phieu_xuat_moc_duoc_chon->id_nhan_vien_xuat)?'selected':'' }}>
                                                                {{ $nhan_vien_kho_moc->ho_ten }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">Ngày giờ xuất kho:</td>
                                                <td>
                                                    <input type="text" id="ngay_gio_xuat_kho" name="ngay_gio_xuat_kho" value="{{ $phieu_xuat_moc_duoc_chon->ngay_gio_xuat_kho }}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <input id="btn_cap_nhat" type="button" value="Cập nhật" onclick="capNhatPhieuXuatMoc()">
                                                </td>
                                            </tr>
                                        </table>
                                    {!! Form::close() !!}
                                </div>
                                <script>
                                    $('#ngay_gio_xuat_kho').datetimepicker({
                                        dateFormat: 'yy-mm-dd',
                                        timeFormat: 'HH:mm:ss'
                                    });
                                </script>
                                <!-- END FORM CẬP NHẬT PHIẾU XUẤT MỘC -->
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
            function chonPhieuXuatMoc()
            {
                // Submit
                var id_phieu_xuat_moc = $('#IdPhieuXuatMoc').val();
                var url = "{{ url('/') }}/he_thong_quan_ly/kho/cap_nhat_phieu_xuat_moc/" + id_phieu_xuat_moc;
                $('#frm_chon_ma_phieu_xuat_moc').attr('action', url);
                $('#frm_chon_ma_phieu_xuat_moc').submit();
            }

            function capNhatPhieuXuatMoc()
            {
                // Validate Ngày giờ xuất kho
                var ngay_gio_xuat_kho = $('#ngay_gio_xuat_kho').val();
                if (ngay_gio_xuat_kho == '')
                {
                    alert('Bạn chưa nhập ngày giờ xuất kho !');
                    return false;
                }
                else
                {
                    var ngayGioXuatKho = new Date(ngay_gio_xuat_kho);
                    if (isNaN(ngayGioXuatKho))
                    {
                        alert('Ngày giờ xuất kho không hợp lệ !');
                        return false;
                    }
                }

                // Validate successful
                // Submit
                var id_phieu_xuat_moc = $('#idPhieuXuatMoc').val();
                var url = "{{ url('/') }}/he_thong_quan_ly/kho/cap_nhat_phieu_xuat_moc/" + id_phieu_xuat_moc;
                $('#frm_cap_nhat_phieu_xuat_moc').attr('action', url);
                $('#frm_cap_nhat_phieu_xuat_moc').submit();
            }
        </script>
    </body>
</html>
