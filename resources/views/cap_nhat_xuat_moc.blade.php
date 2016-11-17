<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Cập nhật xuất mộc</title>

        <link href="{{ url('/') }}/resources/assets/css/bootstrap-3.3.7.css" type="text/css" rel="stylesheet">
        <script src="{{ url('/') }}/resources/assets/js/jquery-3.1.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/jquery-number-2.1.6.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/bootstrap-3.3.7.js" type="text/javascript"></script>

        <style>
            #id_phieu_xuat_moc {
                width: 100px;
                margin-right: 5px;
            }

            #thong_ke {
                margin-top: 5px;
                margin-bottom: 10px;
            }

            #div_cap_nhat_xuat_moc {
                margin-top: 20px;
                margin-left: 30px;
            }

            #div_list_cay_moc_muon_xuat {
                margin-top: 15px;
                margin-left: 30px;
            }

            #tbl_list_cay_moc_muon_xuat td {
                border: 1px solid black;
                padding-left: 5px;
                padding-right: 5px;
            }

            .id_cay_moc {
                text-align: right;
                padding-right: 5px;
                border: none;
                width: 100%;
            }

            .loai_vai {
                text-align: left;
            }

            .so_met {
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
        </script>
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
                            <h3 style="text-align:center;">CẬP NHẬT XUẤT MỘC</h3>
                            <!-- FORM CẬP NHẬT XUẤT MỘC -->
                            <div id="div_cap_nhat_xuat_moc">
                                {!! Form::open(array('method' => 'post', 'id' => 'frm_cap_nhat_xuat_moc')) !!}
                                    <b>Chọn mã phiếu xuất mộc:</b>&nbsp;
                                    <select id="id_phieu_xuat_moc" name="id_phieu_xuat_moc">
                                        @foreach ($list_id_phieu_xuat_moc as $phieu_xuat_moc)
                                            <option value="{{ $phieu_xuat_moc->id }}" {{ (isset($phieu_xuat_moc_duoc_chon) && ($phieu_xuat_moc->id == $phieu_xuat_moc_duoc_chon->id))?'selected':'' }}>
                                                {{ $phieu_xuat_moc->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="button" id="btn_chon" value="Chọn" onclick="chonPhieuXuatMoc()">
                                    <input type="hidden" id="chon_ma_phieu_xuat_moc" name="chon_ma_phieu_xuat_moc" value="">
                                    <input type="hidden" id="list_id_cay_moc_muon_xuat" name="list_id_cay_moc_muon_xuat" value="">
                                    <input type="hidden" id="tongSoCayMoc" name="tongSoCayMoc" value="">
                                    <input type="hidden" id="tongSoMet" name="tongSoMet" value="">
                                {!! Form::close() !!}
                            </div>
                            <!-- END FORM CẬP NHẬT XUẤT MỘC -->
                            @if (isset($errorMessage))
                                <!-- ERROR MESSAGES -->
                                <div id="error_messages" class="alert alert-info" style="text-align:center;color:red;margin-top:12px;margin-left:12px;">
                                    {{ $errorMessage }}
                                </div>
                                <!-- END ERROR MESSAGES -->
                            @endif
                            @if (isset($phieu_xuat_moc_duoc_chon))
                                <!-- LIST CÂY MỘC MUỐN XUẤT -->
                                <div id="div_list_cay_moc_muon_xuat">
                                    <b>Chọn mã cây mộc bạn muốn xuất</b>
                                    <div id="thong_ke">
                                        Tổng số cây mộc: <span id="tong_so_cay_moc_muon_xuat" style="color:red;">
                                            @if (count($list_cay_moc_trong_phieu_xuat_moc) != 0)
                                                {{ number_format(count($list_cay_moc_trong_phieu_xuat_moc), 0, ',', '.') }}
                                            @else
                                                {{ 1 }}
                                            @endif
                                        </span> cây &nbsp;&nbsp;&nbsp;
                                        Tổng số mét: <span id="tong_so_met" style="color:red;">
                                            @if (count($list_cay_moc_trong_phieu_xuat_moc) == 0)
                                                {{ 0 }}
                                            @endif
                                        </span> m &nbsp;&nbsp;&nbsp;
                                        <input class="btn btn-primary btn-md" type="button" value="Cập nhật xuất mộc" onclick="capNhatXuatMoc()">
                                    </div>
                                    <div style="margin-bottom:20px;">
                                        <table id="tbl_list_cay_moc_muon_xuat">
                                            <tr style="text-align:center;font-weight:bold;">
                                                <td>Mã cây mộc</td>
                                                <td>Loại vải</td>
                                                <td>Số mét</td>
                                                <td style="border:none;"></td>
                                            </tr>
                                            @if (count($list_cay_moc_trong_phieu_xuat_moc) == 0)
                                                <tr id="cay_moc_1" class="cay_moc">
                                                    <td style="padding-right:2px;">
                                                        <select id="id_cay_moc_1" class="id_cay_moc" onclick="getValue($(this).val())" onchange="showThongTinCayMoc($(this).val(), $(this).attr('id'))">
                                                            <option value="null"></option>
                                                            @foreach ($list_id_cay_moc_ton_kho_hoac_trong_phieu_xuat_moc_duoc_chon as $cay_moc)
                                                                <option value="{{ $cay_moc->id }}">{{ $cay_moc->id }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td id="loai_vai_1" class="loai_vai"></td>
                                                    <td id="so_met_1" class="so_met"></td>
                                                    <input type="hidden" id="soMet_1" class="soMet" value="">
                                                    <td class="them_xoa">
                                                        <img src="{{ url('/') }}/resources/images/add_32x32.png" id="img_add_1" class="img" alt="add_32x32.png" title="Thêm" onclick="them()">
                                                        <img src="{{ url('/') }}/resources/images/delete_32x32.png" id="img_delete_1" class="img" alt="delete_32x32.png" title="Xóa" onclick="xoa($(this).attr('id'))">
                                                    </td>
                                                </tr>
                                            @else
                                                @for ($i = 0 ; $i < count($list_cay_moc_trong_phieu_xuat_moc) ; $i++)
                                                    <tr id="cay_moc_{{ $i + 1 }}" class="cay_moc">
                                                        <td style="padding-right:2px;">
                                                            <select id="id_cay_moc_{{ $i + 1 }}" class="id_cay_moc" onclick="getValue($(this).val())" onchange="showThongTinCayMoc($(this).val(), $(this).attr('id'))">
                                                                <option value="null"></option>
                                                                @foreach ($list_id_cay_moc_ton_kho_hoac_trong_phieu_xuat_moc_duoc_chon as $cay_moc)
                                                                    <option value="{{ $cay_moc->id }}" {{ ($cay_moc->id == $list_cay_moc_trong_phieu_xuat_moc[$i]->id)?'selected':'' }}>
                                                                        {{ $cay_moc->id }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td id="loai_vai_{{ $i + 1 }}" class="loai_vai">{{ $list_cay_moc_trong_phieu_xuat_moc[$i]->ten_loai_vai }}</td>
                                                        <td id="so_met_{{ $i + 1 }}" class="so_met">{{ number_format($list_cay_moc_trong_phieu_xuat_moc[$i]->so_met, 0, ',', '.') }}</td>
                                                        <input type="hidden" id="soMet_{{ $i + 1 }}" class="soMet" value="{{ $list_cay_moc_trong_phieu_xuat_moc[$i]->so_met }}">
                                                        <td class="them_xoa">
                                                            <img src="{{ url('/') }}/resources/images/add_32x32.png" id="img_add_{{ $i + 1 }}" class="img" alt="add_32x32.png" title="Thêm" onclick="them()">
                                                            <img src="{{ url('/') }}/resources/images/delete_32x32.png" id="img_delete_{{ $i + 1 }}" class="img" alt="delete_32x32.png" title="Xóa" onclick="xoa($(this).attr('id'))">
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @endif
                                        </table>
                                    </div>
                                    <script>
                                        tinhTongSoMet();
                                    </script>
                                </div>
                                <!-- END LIST CÂY MỘC MUỐN XUẤT -->
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
            bien_dem = {{ (isset($list_cay_moc_trong_phieu_xuat_moc) && count($list_cay_moc_trong_phieu_xuat_moc) != 0)?count($list_cay_moc_trong_phieu_xuat_moc):1 }};
            id_cay_moc_muon_xuat_previous = 0;

            function getValue(id_cay_moc_muon_xuat)
            {
                id_cay_moc_muon_xuat_previous = id_cay_moc_muon_xuat;
            }

            function them()
            {
                bien_dem++;
                var id = bien_dem;

                // Thêm
                @if (isset($list_id_cay_moc_ton_kho_hoac_trong_phieu_xuat_moc_duoc_chon))
                    $('#tbl_list_cay_moc_muon_xuat').append(
                        '<tr id="cay_moc_' + id + '" class="cay_moc">' + 
                        '<td style="padding-right:2px;">' + 
                        '<select id="id_cay_moc_' + id + '" class="id_cay_moc" onclick="getValue($(this).val())" onchange="' + "showThongTinCayMoc($(this).val(), $(this).attr('id'))" + '">' + 
                        '<option value="null"></option>' + 
                        '@foreach ($list_id_cay_moc_ton_kho_hoac_trong_phieu_xuat_moc_duoc_chon as $cay_moc)' + 
                        '<option value="{{ $cay_moc->id }}">{{ $cay_moc->id }}</option>' + 
                        '@endforeach' + 
                        '</select></td>' + 
                        '<td id="loai_vai_' + id + '" class="loai_vai"></td>' + 
                        '<td id="so_met_' + id + '" class="so_met"></td>' + 
                        '<input type="hidden" id="soMet_' + id + '" class="soMet" value="">' + 
                        '<td class="them_xoa">' + 
                        '<img src="' + "{{ url('/') }}/resources/images/add_32x32.png" + '" id="img_add_' + id + '" class="img" alt="add_32x32.png" title="Thêm" onclick="them()"> ' + 
                        '<img src="' + "{{ url('/') }}/resources/images/delete_32x32.png" + '" id="img_delete_' + id + '" class="img" alt="delete_32x32.png" title="Xóa" onclick="' + "xoa($(this).attr('id'))" + '">' + 
                        '</td></tr>'
                    );
                @endif

                // Tính lại tổng số cây mộc muốn xuất
                var tong_so_cay_moc_muon_xuat = $('.cay_moc').length;

                // Format tong_so_cay_moc_muon_xuat
                tong_so_cay_moc_muon_xuat = $.number(tong_so_cay_moc_muon_xuat, 0, ',', '.');

                $('#tong_so_cay_moc_muon_xuat').text(tong_so_cay_moc_muon_xuat);
            }

            function xoa(id_img_delete)
            {
                var tong_so_cay_moc_muon_xuat = $('.cay_moc').length;
                if (tong_so_cay_moc_muon_xuat == 1)
                {
                    alert('Phải có ít nhất 1 cây mộc để xuất !');
                    return false;
                }

                var id = id_img_delete.split('_')[2];

                // Xóa
                $('#cay_moc_' + id).remove();

                // Tính lại Tổng số cây mộc muốn xuất và Tổng số mét
                // Tổng số cây mộc muốn xuất
                tong_so_cay_moc_muon_xuat = tong_so_cay_moc_muon_xuat - 1;
                // Format tong_so_cay_moc_muon_xuat
                tong_so_cay_moc_muon_xuat = $.number(tong_so_cay_moc_muon_xuat, 0, ',', '.');
                $('#tong_so_cay_moc_muon_xuat').text(tong_so_cay_moc_muon_xuat);
                // Tổng số mét
                tinhTongSoMet();
            }

            function showThongTinCayMoc(id_cay_moc_muon_xuat, id)
            {
                // Remove class "highlight" (nếu có) của tag <td>
                if ($('#' + id).parent().hasClass('highlight'))
                {
                    $('#' + id).parent().removeClass('highlight')
                }

                id = id.split('_')[3];

                // Trường hợp: id_cay_moc_muon_xuat = null
                if (id_cay_moc_muon_xuat == 'null')
                {
                    // Xóa thông tin cây mộc muốn xuất trước đó
                    $('#loai_vai_' + id).text('');
                    $('#so_met_' + id).text('');
                    $('#soMet_' + id).val('');

                    // Tính lại Tổng số mét
                    tinhTongSoMet();
                }
                else
                {
                    // Kiểm tra xem id_cay_moc_muon_xuat đã được chọn hay chưa (Kiểm tra duplicate)
                    var count = 0;
                    $('.id_cay_moc').each(function() {
                        if (id_cay_moc_muon_xuat == $(this).val())
                        {
                            count++;
                        }
                    });
                    if (count > 1)  // id_cay_moc_muon_xuat đã được chọn rồi (bị duplicate)
                    {
                        $('#id_cay_moc_' + id + ' > option[value="' + id_cay_moc_muon_xuat_previous + '"]').prop('selected', true);
                        alert('Bạn đã chọn cây mộc này rồi !');
                        return false;
                    }

                    // Thiết lập Ajax
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // Lấy thông tin cây mộc mà user muốn xuất từ database
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('route_post_show_thong_tin_cay_moc') }}",
                        data: {id_cay_moc_muon_xuat: id_cay_moc_muon_xuat},
                        dataType: 'json'
                    }).done(function(cay_moc_muon_xuat) {
                            // Show thông tin cây mộc mà user muốn xuất
                            $('#loai_vai_' + id).text(cay_moc_muon_xuat.ten_loai_vai);
                            $('#so_met_' + id).text($.number(cay_moc_muon_xuat.so_met, 0, ',', '.'));
                            $('#soMet_' + id).val(cay_moc_muon_xuat.so_met);

                            // Tính lại Tổng số mét
                            tinhTongSoMet();
                       })
                      .fail(function(jqXHR, textStatus) {
                            alert('Request failed: ' + textStatus);
                       });
                }
            }

            function capNhatXuatMoc()
            {
                // Validate các cây mộc muốn xuất
                var hopLe = true;
                $('.id_cay_moc').each(function() {
                    if ($(this).val() == 'null')
                    {
                        alert('Có ít nhất 1 cây mộc muốn xuất không hợp lệ !');
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
                // Lấy danh sách id cây mộc muốn xuất
                var list_id_cay_moc_muon_xuat = '';
                $('.id_cay_moc').each(function() {
                    var id_cay_moc_muon_xuat = $(this).val();
                    list_id_cay_moc_muon_xuat += id_cay_moc_muon_xuat + ',';
                });
                list_id_cay_moc_muon_xuat = list_id_cay_moc_muon_xuat.substring(0, list_id_cay_moc_muon_xuat.length - 1);

                // Tính Tổng số cây mộc muốn xuất
                var tong_so_cay_moc_muon_xuat = $('.cay_moc').length;

                // Tính Tổng số mét
                var tong_so_met = 0;
                $('.soMet').each(function() {
                    var so_met = $(this).val();
                    tong_so_met += parseInt(so_met);
                });

                // Submit
                $('#list_id_cay_moc_muon_xuat').val(list_id_cay_moc_muon_xuat);
                $('#tongSoCayMoc').val(tong_so_cay_moc_muon_xuat);
                $('#tongSoMet').val(tong_so_met);
                $('#chon_ma_phieu_xuat_moc').val('false');
                var id_phieu_xuat_moc = $('#id_phieu_xuat_moc').val();
                var url = "{{ url('/') }}/he_thong_quan_ly/kho/cap_nhat_xuat_moc/" + id_phieu_xuat_moc;
                $('#frm_cap_nhat_xuat_moc').attr('action', url);
                $('#frm_cap_nhat_xuat_moc').submit();
            }

            function chonPhieuXuatMoc()
            {
                // Submit
                $('#chon_ma_phieu_xuat_moc').val('true');
                var id_phieu_xuat_moc = $('#id_phieu_xuat_moc').val();
                var url = "{{ url('/') }}/he_thong_quan_ly/kho/cap_nhat_xuat_moc/" + id_phieu_xuat_moc;
                $('#frm_cap_nhat_xuat_moc').attr('action', url);
                $('#frm_cap_nhat_xuat_moc').submit();
            }
        </script>
    </body>
</html>
