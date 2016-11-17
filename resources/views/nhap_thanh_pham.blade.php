<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Nhập vải thành phẩm</title>

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
            #div_nhap_thanh_pham {
                margin-top: 20px;
                margin-left: 30px;
            }

            #tbl_nhap_thanh_pham {
                width: 300px;
                height: 110px;
            }

            #tbl_nhap_thanh_pham input, #tbl_nhap_thanh_pham select {
                width: 160px;
            }

            #ngay_gio_nhap_kho {
                padding-left: 4px;
            }

            #div_list_cay_thanh_pham_nhap_kho {
                margin-top: 15px;
                margin-left: 30px;
            }

            #thong_ke {
                margin-bottom: 10px;
            }

            #tbl_list_cay_thanh_pham_nhap_kho td {
                border: 1px solid black;
                padding-left: 5px;
            }

            .id_cay_thanh_pham {
                text-align: right;
                padding-left: 5px;
                padding-right: 5px;
            }

            .id_cay_moc, .kho {
                text-align: right;
                width: 98%;
                padding-left: 5px;
                padding-right: 5px;
                border: none;
            }

            .loai_vai, .so_met, .don_gia, .thanh_tien {
                text-align: right;
                width: 100%;
                padding-left: 5px;
                padding-right: 5px;
                border: none;
            }

            .loai_vai {
                text-align: left !important;
                padding-left: 0px !important;
            }

            .them_xoa {
                border: none !important;
                padding-left: 5px;
            }

            .img {
                width: 25px;
            }

            .highlight {
                //border-color: red !important;
                background-color: yellow !important;
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
                            <h3 style="text-align:center;">NHẬP VẢI THÀNH PHẨM</h3>
                            <!-- FORM NHẬP VẢI THÀNH PHẨM -->
                            <div id="div_nhap_thanh_pham">
                                <h4>A. Thông tin chung</h4>
                                {!! Form::open(array('route' => 'route_post_nhap_vai_thanh_pham', 'method' => 'post', 'id' => 'frm_nhap_thanh_pham')) !!}
                                    <table id="tbl_nhap_thanh_pham">
                                        <tr>
                                            <td>Mã lô nhuộm:</td>
                                            <td>
                                                <select id="id_lo_nhuom" name="id_lo_nhuom" onchange="showMau($(this).val())">
                                                    @foreach ($list_id_lo_nhuom as $lo_nhuom)
                                                        <option value="{{ $lo_nhuom->id }}">{{ $lo_nhuom->id }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Màu:</td>
                                            <td>
                                                <input type="text" id="mau" name="mau" value="{{ $lo_nhuom_dau_tien->ten_mau }}" readonly style="background-color:#cccccc;padding-left:4px;">
                                                <input type="hidden" id="id_mau" name="id_mau" value="{{ $lo_nhuom_dau_tien->id_mau }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Kho:</td>
                                            <td>
                                                <select id="id_kho" name="id_kho">
                                                    @foreach ($list_kho_thanh_pham as $kho_thanh_pham)
                                                        <option value="{{ $kho_thanh_pham->id }}">{{ $kho_thanh_pham->ten }}</option>
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
                            <!-- END FORM NHẬP VẢI THÀNH PHẨM -->
                            <!-- LIST CÂY THÀNH PHẨM NHẬP KHO -->
                            <div id="div_list_cay_thanh_pham_nhap_kho">
                                <h4>B. Danh sách cây thành phẩm nhập kho</h4>
                                <div id="thong_ke">
                                    Tổng số cây thành phẩm: <span id="tong_so_cay_thanh_pham_nhap_kho" style="color:red;">1</span> cây &nbsp;&nbsp;&nbsp;
                                    Tổng số mét: <span id="tong_so_met" style="color:red;">0</span> m &nbsp;&nbsp;&nbsp;
                                    <input class="btn btn-primary btn-md" type="button" value="Nhập thành phẩm" onclick="nhapThanhPham()">
                                </div>
                                <div style="margin-bottom:20px;">
                                    <table id="tbl_list_cay_thanh_pham_nhap_kho">
                                        <tr style="text-align:center;font-weight:bold;">
                                            <td style="padding-right:5px;width:96px;">Mã cây thành phẩm</td>
                                            <td style="padding-right:5px;width:96px;">Mã cây mộc</td>
                                            <td style="width:126px;">Loại vải</td>
                                            <td style="width:75px;">Khổ (m)</td>
                                            <td style="width:75px;">Số mét</td>
                                            <td style="width:75px;">Đơn giá (VNĐ/m)</td>
                                            <td style="width:96px;">Thành tiền (VNĐ)</td>
                                            <td class="them_xoa"></td>
                                        </tr>
                                        <tr id="cay_thanh_pham_1" class="cay_thanh_pham">
                                            <td id="id_cay_thanh_pham_1" class="id_cay_thanh_pham">
                                                {{ $id_cay_thanh_pham_cuoi_cung + 1 }}
                                            </td>
                                            <td style="padding-right:2px;">
                                                <select id="id_cay_moc_1" class="id_cay_moc" onclick="getValue($(this).val())" onchange="showLoaiVai($(this).attr('id'))">
                                                    <option value="null"></option>
                                                    @foreach ($list_id_cay_moc as $cay_moc)
                                                        <option value="{{ $cay_moc->id }}">{{ $cay_moc->id }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td style="background-color:#cccccc;">
                                                <input type="text" id="loai_vai_1" class="loai_vai" value="" readonly style="background-color:#cccccc;">
                                                <input type="hidden" id="id_loai_vai_1" class="id_loai_vai" value="">
                                            </td>
                                            <td style="padding-right:2px;">
                                                <select id="kho_1" class="kho">
                                                    @foreach ($list_kho as $kho)
                                                        <option value="{{ $kho }}">{{ number_format($kho, 1, ',', '.') }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td style="padding-left:0px;">
                                                <input type="text" id="so_met_1" class="so_met" value="" required onchange="tinhTongSoMet_ThanhTien($(this).attr('id'))">
                                            </td>
                                            <td>
                                                <input type="text" id="don_gia_1" class="don_gia" value="" onchange="tinhThanhTien($(this).attr('id'))">
                                            </td>
                                            <td style="background-color:#cccccc;">
                                                <input type="text" id="thanh_tien_1" class="thanh_tien" value="" readonly style="background-color:#cccccc;">
                                                <input type="hidden" id="thanhTien_1" class="thanhTien" value="">
                                            </td>
                                            <td class="them_xoa">
                                                <img src="{{ url('/') }}/resources/images/add_32x32.png" id="img_add_1" class="img" alt="add_32x32.png" title="Thêm" onclick="them()">
                                                <img src="{{ url('/') }}/resources/images/delete_32x32.png" id="img_delete_1" class="img" alt="delete_32x32.png" title="Xóa" onclick="xoa($(this).attr('id'))">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- END LIST CÂY THÀNH PHẨM NHẬP KHO -->
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

            $('.so_met, .don_gia').each(function() {
                $(this).numeric({
                    decimal: false,
                    negative: false
                });
            });

            id_cay_thanh_pham_cuoi_cung = {{ $id_cay_thanh_pham_cuoi_cung }};
            bien_dem = 1;
            id_cay_moc_previous = 0;

            function getValue(id_cay_moc)
            {
                id_cay_moc_previous = id_cay_moc;
            }

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

            function tinhThanhTien(id)
            {
                id = id.split('_')[2];
                var so_met = $('#so_met_' + id).val();
                var don_gia = $('#don_gia_' + id).val();
                var thanh_tien;

                if (so_met == '' || don_gia == '' || parseInt(so_met) == 0 || parseInt(don_gia) == 0)
                {
                    thanh_tien = '';
                }
                else
                {
                    thanh_tien = parseInt(so_met) * parseInt(don_gia);
                }

                if (thanh_tien == '')
                {
                    $('#thanh_tien_' + id).val(thanh_tien);
                }
                else
                {
                    $('#thanh_tien_' + id).val($.number(thanh_tien, 0, ',', '.'));
                }
                $('#thanhTien_' + id).val(thanh_tien);
            }

            function tinhTongSoMet_ThanhTien(id)
            {
                tinhTongSoMet();
                tinhThanhTien(id);
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

            function showLoaiVai(id)
            {
                // Remove class "highlight" (nếu có) của tag <td>
                if ($('#' + id).parent().hasClass('highlight'))
                {
                    $('#' + id).parent().removeClass('highlight')
                }

                id = id.split('_')[3];
                var id_cay_moc = $('#id_cay_moc_' + id).val();

                // Trường hợp: id_cay_moc = null
                if (id_cay_moc == 'null')
                {
                    // Xóa thông tin loại vải trước đó
                    $('#loai_vai_' + id).val('');
                    $('#id_loai_vai_' + id).val('');
                }
                else
                {
                    // Kiểm tra xem id_cay_moc đã được chọn hay chưa (Kiểm tra duplicate)
                    var count = 0;
                    $('.id_cay_moc').each(function() {
                        if (id_cay_moc == $(this).val())
                        {
                            count++;
                        }
                    });
                    if (count > 1)  // id_cay_moc đã được chọn rồi (bị duplicate)
                    {
                        $('#id_cay_moc_' + id + ' > option[value="' + id_cay_moc_previous + '"]').prop('selected', true);
                        alert('Bạn đã chọn cây mộc này rồi !');
                        return false;
                    }

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
                            $('#loai_vai_' + id).val(cay_moc_duoc_chon.ten_loai_vai);
                            $('#id_loai_vai_' + id).val(cay_moc_duoc_chon.id_loai_vai);
                       })
                      .fail(function(jqXHR, textStatus) {
                            alert('Request failed: ' + textStatus);
                       });
                }
            }

            function them()
            {
                bien_dem++;
                var id = bien_dem;
                var id_cay_thanh_pham = $('.id_cay_thanh_pham:last').text();
                id_cay_thanh_pham = parseInt(id_cay_thanh_pham) + 1;

                // Thêm
                $('#tbl_list_cay_thanh_pham_nhap_kho').append(
                    '<tr id="cay_thanh_pham_' + id + '" class="cay_thanh_pham">' + 
                    '<td id="id_cay_thanh_pham_' + id + '" class="id_cay_thanh_pham">' + id_cay_thanh_pham + '</td>' + 
                    '<td style="padding-right:2px;">' + 
                    '<select id="id_cay_moc_' + id + '" class="id_cay_moc" onclick="getValue($(this).val())" onchange="' + "showLoaiVai($(this).attr('id'))" + '">' + 
                    '<option value="null"></option>' + 
                    '@foreach ($list_id_cay_moc as $cay_moc)' + 
                    '<option value="{{ $cay_moc->id }}">{{ $cay_moc->id }}</option>' + 
                    '@endforeach' + 
                    '</select></td>' + 
                    '<td style="background-color:#cccccc;">' + 
                    '<input type="text" id="loai_vai_' + id + '" class="loai_vai" value="" readonly style="background-color:#cccccc;">' + 
                    '<input type="hidden" id="id_loai_vai_' + id + '" class="id_loai_vai" value="">' + 
                    '</td>' + 
                    '<td style="padding-right:2px;">' + 
                    '<select id="kho_' + id + '" class="kho">' + 
                    '@foreach ($list_kho as $kho)' + 
                    '<option value="{{ $kho }}">' + "{{ number_format($kho, 1, ',', '.') }}" + '</option>' + 
                    '@endforeach' + 
                    '</select></td>' + 
                    '<td style="padding-left:0px;">' + 
                    '<input type="text" id="so_met_' + id + '" class="so_met" value="" required onchange="' + "tinhTongSoMet_ThanhTien($(this).attr('id'))" + '">' + 
                    '</td>' + 
                    '<td>' + 
                    '<input type="text" id="don_gia_' + id + '" class="don_gia" value="" onchange="' + "tinhThanhTien($(this).attr('id'))" + '">' + 
                    '</td>' + 
                    '<td style="background-color:#cccccc;">' + 
                    '<input type="text" id="thanh_tien_' + id + '" class="thanh_tien" value="" readonly style="background-color:#cccccc;">' + 
                    '<input type="hidden" id="thanhTien_' + id + '" class="thanhTien" value="">' + 
                    '</td>' + 
                    '<td class="them_xoa">' + 
                    '<img src="' + "{{ url('/') }}/resources/images/add_32x32.png" + '" id="img_add_' + id + '" class="img" alt="add_32x32.png" title="Thêm" onclick="them()"> ' + 
                    '<img src="' + "{{ url('/') }}/resources/images/delete_32x32.png" + '" id="img_delete_' + id + '" class="img" alt="delete_32x32.png" title="Xóa" onclick="' + "xoa($(this).attr('id'))" + '">' + 
                    '</td>' + 
                    '</tr>'
                );

                $('.so_met, .don_gia').each(function() {
                    $(this).numeric({
                        decimal: false,
                        negative: false
                    });
                });

                // Tính lại tổng số cây thành phẩm nhập kho
                var tong_so_cay_thanh_pham_nhap_kho = $('.cay_thanh_pham').length;

                // Format tong_so_cay_thanh_pham_nhap_kho
                tong_so_cay_thanh_pham_nhap_kho = $.number(tong_so_cay_thanh_pham_nhap_kho, 0, ',', '.');

                $('#tong_so_cay_thanh_pham_nhap_kho').text(tong_so_cay_thanh_pham_nhap_kho);
            }

            function xoa(id_img_delete)
            {
                var tong_so_cay_thanh_pham_nhap_kho = $('.cay_thanh_pham').length;
                if (tong_so_cay_thanh_pham_nhap_kho == 1)
                {
                    alert('Phải có ít nhất 1 cây thành phẩm để nhập !');
                    return false;
                }

                var id = id_img_delete.split('_')[2];

                // Xóa
                $('#cay_thanh_pham_' + id).remove();

                // Thiết lập lại id_cay_thanh_pham cho cột "Mã cây thành phẩm"
                var id_cay_thanh_pham = id_cay_thanh_pham_cuoi_cung;
                $('.id_cay_thanh_pham').each(function() {
                    id_cay_thanh_pham++;
                    $(this).text(id_cay_thanh_pham);
                });

                // Tính lại Tổng số cây thành phẩm nhập kho và Tổng số mét
                // Tổng số cây thành phẩm nhập kho
                tong_so_cay_thanh_pham_nhap_kho = tong_so_cay_thanh_pham_nhap_kho - 1;
                // Format tong_so_cay_thanh_pham_nhap_kho
                tong_so_cay_thanh_pham_nhap_kho = $.number(tong_so_cay_thanh_pham_nhap_kho, 0, ',', '.');
                $('#tong_so_cay_thanh_pham_nhap_kho').text(tong_so_cay_thanh_pham_nhap_kho);
                // Tổng số mét
                tinhTongSoMet();
            }

            function nhapThanhPham()
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

                // Validate Mã cây mộc
                $('.id_cay_moc').each(function() {
                    if ($(this).val() == 'null')
                    {
                        alert('Có ít nhất 1 mã cây mộc không hợp lệ !');
                        $(this).parent().addClass('highlight');
                        hopLe = false;
                        return false;
                    }
                });
                if (hopLe == false)
                {
                    return false;
                }

                // Validate Số mét
                $('.so_met').each(function() {
                    var so_met = $(this).val();
                    if (so_met == '')
                    {
                        alert('Bạn chưa nhập số mét cây thành phẩm !');
                        $(this).focus();
                        hopLe = false;
                        return false;
                    }
                    else if (parseInt(so_met) == 0)
                    {
                        alert('Số mét cây thành phẩm ít nhất phải là 1 !');
                        $(this).focus();
                        hopLe = false;
                        return false;
                    }
                });
                if (hopLe == false)
                {
                    return false;
                }

                // Validate Đơn giá
                $('.don_gia').each(function() {
                    var don_gia = $(this).val();
                    if (don_gia != '' && parseInt(don_gia) == 0)    // Đơn giá là 1 chuỗi gồm 1 hoặc nhiều số 0
                    {
                        alert('Đơn giá cây thành phẩm ít nhất phải là 1 !');
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
                // Lấy danh sách cây thành phẩm nhập kho, chuyển về dạng chuỗi JSON để submit
                var data = [];
                // Cấu trúc của data
                /*data = [
                    {
                        id_cay_moc: 25,
                        id_loai_vai: 7,
                        kho: 0.5,
                        so_met: 100,
                        don_gia: 32000,
                        thanh_tien: 3200000
                    },
                    {
                        id_cay_moc: 28,
                        id_loai_vai: 6,
                        kho: 1,
                        so_met: 50,
                        don_gia: 28000,
                        thanh_tien: 1400000
                    }
                ];*/

                // Tạo các đối tượng rỗng trong data, mỗi đối tượng rỗng tương ứng với 1 cây thành phẩm
                $('.cay_thanh_pham').each(function() {
                    // Tạo 1 đối tượng rỗng trong data, tương ứng với 1 cây thành phẩm
                    data.push({});
                });

                // Thiết lập dữ liệu cho các đối tượng rỗng trong data, mỗi đối tượng rỗng tương ứng với 1 cây thành phẩm
                var i = 0;
                $('.cay_thanh_pham').each(function() {
                    var id = $(this).attr('id');
                    id = id.split('_')[3];

                    // Lấy Mã cây mộc
                    var idCayMoc = $('#id_cay_moc_' + id).val();
                    idCayMoc = parseInt(idCayMoc);

                    // Lấy Mã loại vải
                    var idLoaiVai = $('#id_loai_vai_' + id).val();
                    idLoaiVai = parseInt(idLoaiVai);

                    // Lấy Khổ
                    var kho = $('#kho_' + id).val();
                    kho = parseFloat(kho);

                    // Lấy Số mét
                    var soMet = $('#so_met_' + id).val();
                    soMet = parseInt(soMet);

                    // Lấy Đơn giá
                    var donGia = $('#don_gia_' + id).val();
                    if (donGia == '')
                    {
                        donGia = null;
                    }
                    else
                    {
                        donGia = parseInt(donGia);
                    }

                    // Lấy Thành tiền
                    var thanhTien = $('#thanhTien_' + id).val();
                    if (thanhTien == '')
                    {
                        thanhTien = null;
                    }
                    else
                    {
                        thanhTien = parseInt(thanhTien);
                    }

                    // Đưa dữ liệu vào đối tượng rỗng trong data
                    data[i].id_cay_moc = idCayMoc;
                    data[i].id_loai_vai = idLoaiVai;
                    data[i].kho = kho;
                    data[i].so_met = soMet;
                    data[i].don_gia = donGia;
                    data[i].thanh_tien = thanhTien;

                    i++;
                });

                // Chuyển data thành chuỗi JSON
                //alert(data);
                data = JSON.stringify(data);
                //alert(data);

                // Submit
                $('#data').val(data);
                //var url = "{{ route('route_post_nhap_vai_thanh_pham') }}";
                //$('#frm_nhap_thanh_pham').attr('action', url);
                $('#frm_nhap_thanh_pham').submit();
            }
        </script>
    </body>
</html>
