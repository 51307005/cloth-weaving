<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Nhập mộc</title>

        <link href="{{ url('/') }}/resources/assets/css/jquery-ui-1.11.4.css" type="text/css" rel="stylesheet">
        <link href="{{ url('/') }}/resources/assets/css/jquery-ui-timepicker.css" type="text/css" rel="stylesheet">
        <link href="{{ url('/') }}/resources/assets/css/bootstrap-3.3.7.css" type="text/css" rel="stylesheet">
        <script src="{{ url('/') }}/resources/assets/js/jquery-3.1.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/jquery-ui-1.11.4.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/jquery-ui-timepicker-1.6.3.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/jquery-numeric-1.4.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/bootstrap-3.3.7.js" type="text/javascript"></script>

        <style>
            
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
                            <h3 style="text-align:center;">NHẬP MỘC</h3>
                            <!-- FORM NHẬP MỘC -->
                            <div id="div_nhap_moc" style="margin-top:20px;margin-left:30px;">
                                {!! Form::open(array('route' => 'route_post_nhap_moc', 'method' => 'post', 'id' => 'frm_nhap_moc')) !!}
                                    <table id="tbl_nhap_moc">
                                        <tr>
                                            <td>Loại vải:</td>
                                            <td>
                                                <select id="id_loai_vai" name="id_loai_vai">
                                                    @foreach ($list_loai_vai as $loai_vai)
                                                        <option value="{{ $loai_vai->id }}">{{ $loai_vai->ten }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Loại sợi:</td>
                                            <td>
                                                <select id="id_loai_soi" name="id_loai_soi">
                                                    @foreach ($list_loai_soi as $loai_soi)
                                                        <option value="{{ $loai_soi->id }}">{{ $loai_soi->ten }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Kho:</td>
                                            <td>
                                                <select id="id_kho" name="id_kho">
                                                    @foreach ($list_kho_moc as $kho_moc)
                                                        <option value="{{ $kho_moc->id }}">{{ $kho_moc->ten }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ngày giờ nhập kho:</td>
                                            <td>
                                                <input type="text" id="ngay_gio_nhap_kho" class="datetime" name="ngay_gio_nhap_kho" value="" required>
                                            </td>
                                        </tr>
                                    </table>
                                    <input type="hidden" id="data" name="data" value="">
                                {!! Form::close() !!}
                            </div>
                            <!-- END FORM NHẬP MỘC -->
                            <!-- LIST CÂY MỘC NHẬP KHO -->
                            <div id="div_list_cay_moc_nhap_kho">
                                <div id="thong_ke">
                                    Tổng số cây mộc: <span id="tong_so_cay_moc_nhap_kho" style="color:red;">1</span> cây &nbsp;&nbsp;
                                    Tổng số mét: <span id="tong_so_met" style="color:red;">0</span> m
                                </div>
                                <table id="tbl_list_cay_moc_nhap_kho">
                                    <tr style="text-align:center;font-weight:bold;">
                                        <td>Mã cây mộc</td>
                                        <td>Số mét</td>
                                        <td>Nhân viên dệt</td>
                                        <td>Mã máy dệt</td>
                                        <td>Ngày giờ dệt</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr id="cay_moc_1" class="cay_moc">
                                        <td id="id_cay_moc_1" class="id_cay_moc" style="text-align:right;">
                                            {{ $id_cay_moc_cuoi_cung + 1 }}
                                        </td>
                                        <td>
                                            <input type="text" id="so_met_1" class="so_met" required>
                                        </td>
                                        <td>
                                            <select id="id_nhan_vien_det_1">
                                                @foreach ($list_nhan_vien_det as $nhan_vien_det)
                                                    <option value="{{ $nhan_vien_det->id }}">{{ $nhan_vien_det->ho_ten }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select id="id_may_det_1">
                                                @foreach ($list_ma_may_det as $idMayDet)
                                                    <option value="{{ $idMayDet }}">{{ $idMayDet }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" id="ngay_gio_det_1" class="datetime ngay_gio_det" value="" required>
                                        </td>
                                        <td>
                                            
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!-- END LIST CÂY MỘC NHẬP KHO -->
                        </div>
                        <!-- END MAIN CONTENT -->
                    </div>
                    <div style="clear:both;"></div>
                </div>
                <!-- END NỘI DUNG -->
            </div>
        </div>
        <script>
            $('.datetime').each(function() {
                $(this).datetimepicker({
                    dateFormat: 'yy-mm-dd',
                    timeFormat: 'HH:mm:ss'
                });
            });

            
        </script>
    </body>
</html>
