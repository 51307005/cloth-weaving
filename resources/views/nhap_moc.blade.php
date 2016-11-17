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
        <script src="{{ url('/') }}/resources/assets/js/jquery-number-2.1.6.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/bootstrap-3.3.7.js" type="text/javascript"></script>

        <style>
            #div_nhap_moc {
                margin-top: 20px;
                margin-left: 30px;
            }

            #tbl_nhap_moc {
                width: 400px;
                height: 110px;
            }

            #tbl_nhap_moc input, #tbl_nhap_moc select {
                width: 250px;
            }

            #ngay_gio_nhap_kho {
                padding-left: 4px;
            }

            #div_list_cay_moc_nhap_kho {
                margin-top: 15px;
                margin-left: 30px;
            }

            #thong_ke {
                margin-bottom: 10px;
            }

            #tbl_list_cay_moc_nhap_kho td {
                border: 1px solid black;
            }

            .id_cay_moc {
                text-align: right;
                padding-left: 5px;
                padding-right: 5px;
            }

            .id_nhan_vien_det {
                width: 98.5%;
                border: none;
            }

            .id_may_det {
                text-align: right;
                width: 98%;
                padding-left: 5px;
                padding-right: 5px;
                border: none;
            }

            .so_met {
                text-align: right;
                width: 100%;
                padding-left: 5px;
                padding-right: 5px;
                border: none;
            }

            .ngay_gio_det {
                text-align: center;
                width: 100%;
                padding-left: 5px;
                padding-right: 5px;
                border: none;
            }

            .them_xoa {
                border: none !important;
                padding-left: 5px;
            }

            .img {
                width: 25px;
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
                            <h3 style="text-align:center;">NHẬP MỘC</h3>
                            <!-- FORM NHẬP MỘC -->
                            <div id="div_nhap_moc">
                                <h4>A. Thông tin chung</h4>
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
                                <h4>B. Danh sách cây mộc nhập kho</h4>
                                <div id="thong_ke">
                                    Tổng số cây mộc: <span id="tong_so_cay_moc_nhap_kho" style="color:red;">1</span> cây &nbsp;&nbsp;&nbsp;
                                    Tổng số mét: <span id="tong_so_met" style="color:red;">0</span> m &nbsp;&nbsp;&nbsp;
                                    <input class="btn btn-primary btn-md" type="button" value="Nhập mộc" onclick="nhapMoc()">
                                </div>
                                <div style="margin-bottom:20px;">
                                    <table id="tbl_list_cay_moc_nhap_kho">
                                        <tr style="text-align:center;font-weight:bold;">
                                            <td style="padding-left:5px;padding-right:5px;">Mã cây mộc</td>
                                            <td>Số mét</td>
                                            <td>Nhân viên dệt</td>
                                            <td>Mã máy dệt</td>
                                            <td>Ngày giờ dệt</td>
                                            <td class="them_xoa"></td>
                                        </tr>
                                        <tr id="cay_moc_1" class="cay_moc">
                                            <td id="id_cay_moc_1" class="id_cay_moc">
                                                {{ $id_cay_moc_cuoi_cung + 1 }}
                                            </td>
                                            <td style="width:70px;">
                                                <input type="text" id="so_met_1" class="so_met" required onchange="tinhTongSoMet()">
                                            </td>
                                            <td style="width:160px;">
                                                <select id="id_nhan_vien_det_1" class="id_nhan_vien_det">
                                                    @foreach ($list_nhan_vien_det as $nhan_vien_det)
                                                        <option value="{{ $nhan_vien_det->id }}">{{ $nhan_vien_det->ho_ten }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td style="width:100px;">
                                                <select id="id_may_det_1" class="id_may_det">
                                                    @foreach ($list_ma_may_det as $idMayDet)
                                                        <option value="{{ $idMayDet }}">{{ $idMayDet }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td style="width:150px;">
                                                <input type="text" id="ngay_gio_det_1" class="datetime ngay_gio_det" value="" required>
                                            </td>
                                            <td class="them_xoa">
                                                <img src="{{ url('/') }}/resources/images/add_32x32.png" id="img_add_1" class="img" alt="add_32x32.png" title="Thêm" onclick="them()">
                                                <img src="{{ url('/') }}/resources/images/delete_32x32.png" id="img_delete_1" class="img" alt="delete_32x32.png" title="Xóa" onclick="xoa($(this).attr('id'))">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
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

            $('.so_met').each(function() {
                $(this).numeric({
                    decimal: false,
                    negative: false
                });
            });

            function tinhTongSoMet()
            {
                var tong_so_met = 0;
                $('.so_met').each(function() {
                    var so_met = $(this).val();
                    if (so_met != '' && parseInt(so_met) != 0)
                    {
                        tong_so_met += parseInt(so_met);
                    }
                });

                // Format tong_so_met
                tong_so_met = $.number(tong_so_met, 0, ',', '.');

                $('#tong_so_met').text(tong_so_met);
            }

            id_cay_moc_cuoi_cung = {{ $id_cay_moc_cuoi_cung }};
            bien_dem = 1;

            function them()
            {
                bien_dem++;
                var id = bien_dem;
                var id_cay_moc = $('.id_cay_moc:last').text();
                id_cay_moc = parseInt(id_cay_moc) + 1;

                // Thêm
                $('#tbl_list_cay_moc_nhap_kho').append(
                    '<tr id="cay_moc_' + id + '" class="cay_moc">' + 
                    '<td id="id_cay_moc_' + id + '" class="id_cay_moc">' + id_cay_moc + '</td>' + 
                    '<td style="width:70px;">' + 
                    '<input type="text" id="so_met_' + id + '" class="so_met" required onchange="tinhTongSoMet()">' + 
                    '</td>' + 
                    '<td style="width:160px;">' + 
                    '<select id="id_nhan_vien_det_' + id + '" class="id_nhan_vien_det">' + 
                    '@foreach ($list_nhan_vien_det as $nhan_vien_det)' + 
                    '<option value="{{ $nhan_vien_det->id }}">{{ $nhan_vien_det->ho_ten }}</option>' + 
                    '@endforeach' + 
                    '</select></td>' + 
                    '<td style="width:100px;">' + 
                    '<select id="id_may_det_' + id + '" class="id_may_det">' + 
                    '@foreach ($list_ma_may_det as $idMayDet)' + 
                    '<option value="{{ $idMayDet }}">{{ $idMayDet }}</option>' + 
                    '@endforeach' + 
                    '</select></td>' + 
                    '<td style="width:150px;">' + 
                    '<input type="text" id="ngay_gio_det_' + id + '" class="datetime ngay_gio_det" value="" required>' + 
                    '</td>' + 
                    '<td class="them_xoa">' + 
                    '<img src="' + "{{ url('/') }}/resources/images/add_32x32.png" + '" id="img_add_' + id + '" class="img" alt="add_32x32.png" title="Thêm" onclick="them()"> ' + 
                    '<img src="' + "{{ url('/') }}/resources/images/delete_32x32.png" + '" id="img_delete_' + id + '" class="img" alt="delete_32x32.png" title="Xóa" onclick="' + "xoa($(this).attr('id'))" + '">' + 
                    '</td></tr>'
                );

                $('.datetime').each(function() {
                    $(this).datetimepicker({
                        dateFormat: 'yy-mm-dd',
                        timeFormat: 'HH:mm:ss'
                    });
                });

                $('.so_met').each(function() {
                    $(this).numeric({
                        decimal: false,
                        negative: false
                    });
                });

                // Tính lại tổng số cây mộc nhập kho
                var tong_so_cay_moc_nhap_kho = $('.cay_moc').length;

                // Format tong_so_cay_moc_nhap_kho
                tong_so_cay_moc_nhap_kho = $.number(tong_so_cay_moc_nhap_kho, 0, ',', '.');

                $('#tong_so_cay_moc_nhap_kho').text(tong_so_cay_moc_nhap_kho);
            }

            function xoa(id_img_delete)
            {
                var tong_so_cay_moc_nhap_kho = $('.cay_moc').length;
                if (tong_so_cay_moc_nhap_kho == 1)
                {
                    alert('Phải có ít nhất 1 cây mộc để nhập !');
                    return false;
                }

                var id = id_img_delete.split('_')[2];

                // Xóa
                $('#cay_moc_' + id).remove();

                // Thiết lập lại id_cay_moc cho cột "Mã cây mộc"
                var id_cay_moc = id_cay_moc_cuoi_cung;
                $('.id_cay_moc').each(function() {
                    id_cay_moc++;
                    $(this).text(id_cay_moc);
                });

                // Tính lại Tổng số cây mộc nhập kho và Tổng số mét
                // Tổng số cây mộc nhập kho
                tong_so_cay_moc_nhap_kho = tong_so_cay_moc_nhap_kho - 1;
                // Format tong_so_cay_moc_nhap_kho
                tong_so_cay_moc_nhap_kho = $.number(tong_so_cay_moc_nhap_kho, 0, ',', '.');
                $('#tong_so_cay_moc_nhap_kho').text(tong_so_cay_moc_nhap_kho);
                // Tổng số mét
                tinhTongSoMet();
            }

            function nhapMoc()
            {
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

                var hopLe = true;

                // Validate Số mét
                $('.so_met').each(function() {
                    var so_met = $(this).val();
                    if (so_met == '')
                    {
                        alert('Bạn chưa nhập số mét cây mộc !');
                        $(this).focus();
                        hopLe = false;
                        return false;
                    }
                    else if (parseInt(so_met) == 0)
                    {
                        alert('Số mét cây mộc ít nhất phải là 1 !');
                        $(this).focus();
                        hopLe = false;
                        return false;
                    }
                });
                if (hopLe == false)
                {
                    return false;
                }

                // Validate Ngày giờ dệt và Validate trường hợp: Ngày giờ dệt >= Ngày giờ nhập kho
                $('.ngay_gio_det').each(function() {
                    // Validate Ngày giờ dệt
                    var ngay_gio_det = $(this).val();
                    if (ngay_gio_det == '')
                    {
                        alert('Bạn chưa nhập ngày giờ dệt !');
                        $(this).focus();
                        hopLe = false;
                        return false;
                    }
                    else
                    {
                        var ngayGioDet = new Date(ngay_gio_det);
                        if (isNaN(ngayGioDet))
                        {
                            alert('Ngày giờ dệt không hợp lệ !');
                            $(this).focus();
                            hopLe = false;
                            return false;
                        }
                    }

                    // Validate trường hợp: Ngày giờ dệt >= Ngày giờ nhập kho
                    var ngaygionhapkho = new Date(ngay_gio_nhap_kho);
                    var ngaygiodet = new Date(ngay_gio_det);
                    if (ngaygiodet.getTime() >= ngaygionhapkho.getTime())
                    {
                        alert('Ngày giờ dệt phải trước ngày giờ nhập kho !');
                        $(this).focus();
                        hopLe = false;
                        return false;
                    }
                });
                if (hopLe == false)
                {
                    return false;
                }

                // Validate successful
                // Lấy danh sách cây mộc nhập kho, chuyển về dạng chuỗi JSON để submit
                var data = [];
                // Cấu trúc của data
                /*data = [
                    {
                        so_met: 72,
                        id_nhan_vien_det: 4,
                        id_may_det: 2,
                        ngay_gio_det: '2016-10-31 14:05:30'
                    },
                    {
                        so_met: 53,
                        id_nhan_vien_det: 4,
                        id_may_det: 5,
                        ngay_gio_det: '2016-11-01 09:47:28'
                    }
                ];*/

                // Tạo các đối tượng rỗng trong data, mỗi đối tượng rỗng tương ứng với 1 cây mộc
                $('.cay_moc').each(function() {
                    // Tạo 1 đối tượng rỗng trong data, tương ứng với 1 cây mộc
                    data.push({});
                });

                // Thiết lập dữ liệu cho các đối tượng rỗng trong data, mỗi đối tượng rỗng tương ứng với 1 cây mộc
                var i = 0;
                $('.cay_moc').each(function() {
                    var id = $(this).attr('id');
                    id = id.split('_')[2];

                    // Lấy Số mét
                    var soMet = $('#so_met_' + id).val();
                    soMet = parseInt(soMet);

                    // Lấy Id nhân viên dệt
                    var idNhanVienDet = $('#id_nhan_vien_det_' + id).val();
                    idNhanVienDet = parseInt(idNhanVienDet);

                    // Lấy Id máy dệt
                    var idMayDet = $('#id_may_det_' + id).val();
                    idMayDet = parseInt(idMayDet);

                    // Lấy Ngày giờ dệt
                    var ngayGioDet = $('#ngay_gio_det_' + id).val();

                    // Đưa dữ liệu vào đối tượng rỗng trong data
                    data[i].so_met = soMet;
                    data[i].id_nhan_vien_det = idNhanVienDet;
                    data[i].id_may_det = idMayDet;
                    data[i].ngay_gio_det = ngayGioDet;

                    i++;
                });

                // Chuyển data thành chuỗi JSON
                //alert(data);
                data = JSON.stringify(data);
                //alert(data);

                // Submit
                $('#data').val(data);
                //var url = "{{ route('route_post_nhap_moc') }}";
                //$('#frm_nhap_moc').attr('action', url);
                $('#frm_nhap_moc').submit();
            }
        </script>
    </body>
</html>
