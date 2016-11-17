<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Xuất vải thành phẩm</title>

        <link href="{{ url('/') }}/resources/assets/css/bootstrap-3.3.7.css" type="text/css" rel="stylesheet">
        <script src="{{ url('/') }}/resources/assets/js/jquery-3.1.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/jquery-number-2.1.6.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/bootstrap-3.3.7.js" type="text/javascript"></script>

        <style>
            #id_hoa_don_xuat {
                width: 100px;
            }

            #thong_ke {
                margin-top: 5px;
                margin-bottom: 10px;
            }

            #div_xuat_thanh_pham {
                margin-top: 20px;
                margin-left: 30px;
            }

            #div_list_cay_thanh_pham_muon_xuat {
                margin-top: 15px;
                margin-left: 30px;
            }

            #tbl_list_cay_thanh_pham_muon_xuat td {
                border: 1px solid black;
                padding-left: 5px;
                padding-right: 5px;
            }

            .id_cay_thanh_pham {
                text-align: right;
                padding-right: 5px;
                border: none;
                width: 100%;
            }

            .loai_vai, .mau {
                text-align: left;
            }

            .kho, .so_met, .don_gia, .thanh_tien, .lo_nhuom {
                text-align: right;
            }

            .them_xoa {
                border: none !important;
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
                            <h3 style="text-align:center;">XUẤT VẢI THÀNH PHẨM</h3>
                            <!-- FORM XUẤT VẢI THÀNH PHẨM -->
                            <div id="div_xuat_thanh_pham">
                                {!! Form::open(array('route' => 'route_post_xuat_vai_thanh_pham', 'method' => 'post', 'id' => 'frm_xuat_thanh_pham')) !!}
                                    <b>Mã hóa đơn xuất:</b>&nbsp;
                                    <select id="id_hoa_don_xuat" name="id_hoa_don_xuat" onchange="showLaiDanhSachMaCayThanhPham($(this).val())">
                                        @foreach ($list_id_hoa_don_xuat as $hoa_don_xuat)
                                            <option value="{{ $hoa_don_xuat->id }}">{{ $hoa_don_xuat->id }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="list_id_cay_thanh_pham_muon_xuat" name="list_id_cay_thanh_pham_muon_xuat" value="">
                                {!! Form::close() !!}
                            </div>
                            <!-- END FORM XUẤT VẢI THÀNH PHẨM -->
                            <!-- LIST CÂY THÀNH PHẨM MUỐN XUẤT -->
                            <div id="div_list_cay_thanh_pham_muon_xuat">
                                <b>Chọn mã cây thành phẩm bạn muốn xuất</b>
                                <div id="thong_ke">
                                    Tổng số cây thành phẩm: <span id="tong_so_cay_thanh_pham_muon_xuat" style="color:red;">1</span> cây &nbsp;&nbsp;&nbsp;
                                    Tổng số mét: <span id="tong_so_met" style="color:red;">0</span> m &nbsp;&nbsp;&nbsp;
                                    Tổng tiền: <span id="tong_tien" style="color:red;">0</span> VNĐ &nbsp;&nbsp;&nbsp;
                                    <input class="btn btn-primary btn-md" type="button" value="Xuất vải thành phẩm" onclick="xuatThanhPham()">
                                </div>
                                <div style="margin-bottom:20px;">
                                    <table id="tbl_list_cay_thanh_pham_muon_xuat">
                                        <tr style="text-align:center;font-weight:bold;">
                                            <td>Mã cây thành phẩm</td>
                                            <td>Loại vải</td>
                                            <td>Màu</td>
                                            <td>Khổ (m)</td>
                                            <td>Số mét</td>
                                            <td>Đơn giá (VNĐ/m)</td>
                                            <td>Thành tiền (VNĐ)</td>
                                            <td>Mã lô nhuộm</td>
                                            <td style="border:none;"></td>
                                        </tr>
                                        <tr id="cay_thanh_pham_1" class="cay_thanh_pham">
                                            <td style="padding-right:2px;">
                                                <select id="id_cay_thanh_pham_1" class="id_cay_thanh_pham" onclick="getValue($(this).val())" onchange="showThongTinCayThanhPham($(this).val(), $(this).attr('id'))">
                                                    <option value="null"></option>
                                                    @foreach ($list_id_cay_thanh_pham_ton_kho as $cay_thanh_pham_ton_kho)
                                                        <option value="{{ $cay_thanh_pham_ton_kho->id }}">{{ $cay_thanh_pham_ton_kho->id }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td id="loai_vai_1" class="loai_vai"></td>
                                            <td id="mau_1" class="mau"></td>
                                            <td id="kho_1" class="kho"></td>
                                            <td id="so_met_1" class="so_met"></td>
                                            <input type="hidden" id="soMet_1" class="soMet" value="">
                                            <td id="don_gia_1" class="don_gia"></td>
                                            <input type="hidden" id="donGia_1" class="donGia" value="">
                                            <td id="thanh_tien_1" class="thanh_tien"></td>
                                            <input type="hidden" id="thanhTien_1" class="thanhTien" value="">
                                            <td id="lo_nhuom_1" class="lo_nhuom"></td>
                                            <td class="them_xoa">
                                                <img src="{{ url('/') }}/resources/images/add_32x32.png" id="img_add_1" class="img" alt="add_32x32.png" title="Thêm" onclick="them()">
                                                <img src="{{ url('/') }}/resources/images/delete_32x32.png" id="img_delete_1" class="img" alt="delete_32x32.png" title="Xóa" onclick="xoa($(this).attr('id'))">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- END LIST CÂY THÀNH PHẨM MUỐN XUẤT -->
                        </div>
                        <!-- END MAIN CONTENT -->
                    </div>
                    <div style="clear:both;"></div>
                </div>
                <!-- END NỘI DUNG -->
            </div>
        </div>
        <script>
            function tinhTongSoMet()
            {
                var tong_so_met = 0;
                $('.soMet').each(function() {
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

            function tinhTongTien()
            {
                var tong_tien = 0;
                $('.thanhTien').each(function() {
                    var thanh_tien = $(this).val();
                    if (thanh_tien != '' && parseInt(thanh_tien) != 0)
                    {
                        tong_tien += parseInt(thanh_tien);
                    }
                });

                // Format tong_tien
                tong_tien = $.number(tong_tien, 0, ',', '.');

                $('#tong_tien').text(tong_tien);
            }

            bien_dem = 1;
            id_cay_thanh_pham_muon_xuat_previous = 0;

            list_option = '';
            @foreach ($list_id_cay_thanh_pham_ton_kho as $cay_thanh_pham_ton_kho)
                list_option += '<option value="' + {{ $cay_thanh_pham_ton_kho->id }} + '">' + {{ $cay_thanh_pham_ton_kho->id }} + '</option>';
            @endforeach
            //alert(list_option);

            function getValue(id_cay_thanh_pham_muon_xuat)
            {
                id_cay_thanh_pham_muon_xuat_previous = id_cay_thanh_pham_muon_xuat;
            }

            function them()
            {
                bien_dem++;
                var id = bien_dem;

                // Thêm
                $('#tbl_list_cay_thanh_pham_muon_xuat').append(
                    '<tr id="cay_thanh_pham_' + id + '" class="cay_thanh_pham">' + 
                    '<td style="padding-right:2px;">' + 
                    '<select id="id_cay_thanh_pham_' + id + '" class="id_cay_thanh_pham" onclick="getValue($(this).val())" onchange="' + "showThongTinCayThanhPham($(this).val(), $(this).attr('id'))" + '">' + 
                    '<option value="null"></option>' + list_option + 
                    '</select></td>' + 
                    '<td id="loai_vai_' + id + '" class="loai_vai"></td>' + 
                    '<td id="mau_' + id + '" class="mau"></td>' + 
                    '<td id="kho_' + id + '" class="kho"></td>' + 
                    '<td id="so_met_' + id + '" class="so_met"></td>' + 
                    '<input type="hidden" id="soMet_' + id + '" class="soMet" value="">' + 
                    '<td id="don_gia_' + id + '" class="don_gia"></td>' + 
                    '<input type="hidden" id="donGia_' + id + '" class="donGia" value="">' + 
                    '<td id="thanh_tien_' + id + '" class="thanh_tien"></td>' + 
                    '<input type="hidden" id="thanhTien_' + id + '" class="thanhTien" value="">' + 
                    '<td id="lo_nhuom_' + id + '" class="lo_nhuom"></td>' + 
                    '<td class="them_xoa">' + 
                    '<img src="' + "{{ url('/') }}/resources/images/add_32x32.png" + '" id="img_add_' + id + '" class="img" alt="add_32x32.png" title="Thêm" onclick="them()"> ' + 
                    '<img src="' + "{{ url('/') }}/resources/images/delete_32x32.png" + '" id="img_delete_' + id + '" class="img" alt="delete_32x32.png" title="Xóa" onclick="' + "xoa($(this).attr('id'))" + '">' + 
                    '</td></tr>'
                );

                // Tính lại tổng số cây thành phẩm muốn xuất
                var tong_so_cay_thanh_pham_muon_xuat = $('.cay_thanh_pham').length;

                // Format tong_so_cay_thanh_pham_muon_xuat
                tong_so_cay_thanh_pham_muon_xuat = $.number(tong_so_cay_thanh_pham_muon_xuat, 0, ',', '.');

                $('#tong_so_cay_thanh_pham_muon_xuat').text(tong_so_cay_thanh_pham_muon_xuat);
            }

            function xoa(id_img_delete)
            {
                var tong_so_cay_thanh_pham_muon_xuat = $('.cay_thanh_pham').length;
                if (tong_so_cay_thanh_pham_muon_xuat == 1)
                {
                    alert('Phải có ít nhất 1 cây thành phẩm để xuất !');
                    return false;
                }

                var id = id_img_delete.split('_')[2];

                // Xóa
                $('#cay_thanh_pham_' + id).remove();

                // Tính lại Tổng số cây thành phẩm muốn xuất, Tổng số mét và Tổng tiền
                // Tổng số cây thành phẩm muốn xuất
                tong_so_cay_thanh_pham_muon_xuat = tong_so_cay_thanh_pham_muon_xuat - 1;
                // Format tong_so_cay_thanh_pham_muon_xuat
                tong_so_cay_thanh_pham_muon_xuat = $.number(tong_so_cay_thanh_pham_muon_xuat, 0, ',', '.');
                $('#tong_so_cay_thanh_pham_muon_xuat').text(tong_so_cay_thanh_pham_muon_xuat);
                // Tổng số mét
                tinhTongSoMet();
                // Tổng tiền
                tinhTongTien();
            }

            function showThongTinCayThanhPham(id_cay_thanh_pham_muon_xuat, id)
            {
                // Remove class "highlight" (nếu có) của tag <td>
                if ($('#' + id).parent().hasClass('highlight'))
                {
                    $('#' + id).parent().removeClass('highlight')
                }

                id = id.split('_')[4];

                // Trường hợp: id_cay_thanh_pham_muon_xuat = null
                if (id_cay_thanh_pham_muon_xuat == 'null')
                {
                    // Xóa thông tin cây thành phẩm muốn xuất trước đó
                    $('#loai_vai_' + id).text('');
                    $('#mau_' + id).text('');
                    $('#kho_' + id).text('');
                    $('#so_met_' + id).text('');
                    $('#soMet_' + id).val('');
                    $('#don_gia_' + id).text('');
                    $('#donGia_' + id).val('');
                    $('#thanh_tien_' + id).text('');
                    $('#thanhTien_' + id).val('');
                    $('#lo_nhuom_' + id).text('');

                    // Tính lại Tổng số mét
                    tinhTongSoMet();

                    // Tính lại Tổng tiền
                    tinhTongTien();
                }
                else
                {
                    // Kiểm tra xem id_cay_thanh_pham_muon_xuat đã được chọn hay chưa (Kiểm tra duplicate)
                    var count = 0;
                    $('.id_cay_thanh_pham').each(function() {
                        if (id_cay_thanh_pham_muon_xuat == $(this).val())
                        {
                            count++;
                        }
                    });
                    if (count > 1)  // id_cay_thanh_pham_muon_xuat đã được chọn rồi (bị duplicate)
                    {
                        $('#id_cay_thanh_pham_' + id + ' > option[value="' + id_cay_thanh_pham_muon_xuat_previous + '"]').prop('selected', true);
                        alert('Bạn đã chọn cây thành phẩm này rồi !');
                        return false;
                    }

                    // Thiết lập Ajax
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // Lấy thông tin cây thành phẩm mà user muốn xuất từ database
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('route_post_show_thong_tin_cay_thanh_pham') }}",
                        data: {id_cay_thanh_pham_muon_xuat: id_cay_thanh_pham_muon_xuat},
                        dataType: 'json'
                    }).done(function(cay_thanh_pham_muon_xuat) {
                            // Show thông tin cây thành phẩm mà user muốn xuất
                            $('#loai_vai_' + id).text(cay_thanh_pham_muon_xuat.ten_loai_vai);
                            $('#mau_' + id).text(cay_thanh_pham_muon_xuat.ten_mau);
                            $('#kho_' + id).text($.number(cay_thanh_pham_muon_xuat.kho, 1, ',', '.'));
                            $('#so_met_' + id).text($.number(cay_thanh_pham_muon_xuat.so_met, 0, ',', '.'));
                            $('#soMet_' + id).val(cay_thanh_pham_muon_xuat.so_met);
                            if (cay_thanh_pham_muon_xuat.don_gia == null)
                            {
                                $('#don_gia_' + id).text(cay_thanh_pham_muon_xuat.don_gia);
                            }
                            else
                            {
                                $('#don_gia_' + id).text($.number(cay_thanh_pham_muon_xuat.don_gia, 0, ',', '.'));
                            }
                            $('#donGia_' + id).val(cay_thanh_pham_muon_xuat.don_gia);
                            if (cay_thanh_pham_muon_xuat.thanh_tien == null)
                            {
                                $('#thanh_tien_' + id).text(cay_thanh_pham_muon_xuat.thanh_tien);
                            }
                            else
                            {
                                $('#thanh_tien_' + id).text($.number(cay_thanh_pham_muon_xuat.thanh_tien, 0, ',', '.'));
                            }
                            $('#thanhTien_' + id).val(cay_thanh_pham_muon_xuat.thanh_tien);
                            $('#lo_nhuom_' + id).text(cay_thanh_pham_muon_xuat.id_lo_nhuom);

                            // Tính lại Tổng số mét
                            tinhTongSoMet();

                            // Tính lại Tổng tiền
                            tinhTongTien();
                       })
                      .fail(function(jqXHR, textStatus) {
                            alert('Request failed: ' + textStatus);
                       });
                }
            }

            function xuatThanhPham()
            {
                // Validate các cây thành phẩm muốn xuất
                var hopLe = true;
                $('.id_cay_thanh_pham').each(function() {
                    if ($(this).val() == 'null')
                    {
                        alert('Có ít nhất 1 cây thành phẩm muốn xuất không hợp lệ !');
                        $(this).parent().addClass('highlight');
                        hopLe = false;
                        return false;
                    }
                });
                if (hopLe == false)
                {
                    return false;
                }

                // Validate successful
                // Lấy danh sách id cây thành phẩm muốn xuất
                var list_id_cay_thanh_pham_muon_xuat = '';
                $('.id_cay_thanh_pham').each(function() {
                    var id_cay_thanh_pham_muon_xuat = $(this).val();
                    list_id_cay_thanh_pham_muon_xuat += id_cay_thanh_pham_muon_xuat + ',';
                });
                list_id_cay_thanh_pham_muon_xuat = list_id_cay_thanh_pham_muon_xuat.substring(0, list_id_cay_thanh_pham_muon_xuat.length - 1);

                // Submit
                $('#list_id_cay_thanh_pham_muon_xuat').val(list_id_cay_thanh_pham_muon_xuat);
                //var url = "{{ route('route_post_xuat_vai_thanh_pham') }}";
                //$('#frm_xuat_thanh_pham').attr('action', url);
                $('#frm_xuat_thanh_pham').submit();
            }

            function showLaiDanhSachMaCayThanhPham(id_hoa_don_xuat)
            {
                // Thiết lập Ajax
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Lấy thông tin danh sách id cây thành phẩm tồn kho mà nằm trong kho mà ứng với id_hoa_don_xuat vừa được chọn
                $.ajax({
                    method: 'POST',
                    url: "{{ route('route_post_show_lai_danh_sach_ma_cay_thanh_pham') }}",
                    data: {id_hoa_don_xuat: id_hoa_don_xuat},
                    dataType: 'json'
                }).done(function(list_id_cay_thanh_pham_ton_kho) {
                        // Show lại "danh sách id cây thành phẩm có thể xuất" mới
                        // 1. Xóa tất cả dữ liệu: loại vải, màu, khổ, số mét, đơn giá, thành tiền, mã lô nhuộm và "danh sách id cây thành phẩm có thể xuất" hiện hành
                        $('.loai_vai').text('');
                        $('.mau').text('');
                        $('.kho').text('');
                        $('.so_met').text('');
                        $('.soMet').val('');
                        $('.don_gia').text('');
                        $('.donGia').val('');
                        $('.thanh_tien').text('');
                        $('.thanhTien').val('');
                        $('.lo_nhuom').text('');
                        $('.id_cay_thanh_pham option').remove();

                        // 2. Tính lại Tổng số mét và Tổng tiền
                        $('#tong_so_met').text(0);
                        $('#tong_tien').text(0);

                        // 3. Show lại "danh sách id cây thành phẩm có thể xuất" mới
                        list_option = '';
                        var id_cay_thanh_pham = 0;
                        for (var i = 0 ; i < list_id_cay_thanh_pham_ton_kho.length ; i++)
                        {
                            id_cay_thanh_pham = list_id_cay_thanh_pham_ton_kho[i].id;
                            list_option += '<option value="' + id_cay_thanh_pham + '">' + id_cay_thanh_pham + '</option>';
                        }
                        //alert(list_option);
                        $('.id_cay_thanh_pham').each(function() {
                            $(this).append(
                                '<option value="null"></option>' + list_option
                            );
                        });
                   })
                  .fail(function(jqXHR, textStatus) {
                        alert('Request failed: ' + textStatus);
                   });
            }
        </script>
    </body>
</html>
