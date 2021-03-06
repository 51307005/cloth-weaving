<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kho thành phẩm</title>

        <link href="{{ url('/') }}/resources/assets/css/bootstrap-3.3.7.css" type="text/css" rel="stylesheet">
        <script src="{{ url('/') }}/resources/assets/js/jquery-3.1.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/bootstrap-3.3.7.js" type="text/javascript"></script>

        <style>
            ul.pagination {
                margin: 0px;
            }

            #tbl_loc_cay_thanh_pham_ton_kho select {
                width: 130px;
            }

            #tbl_thong_ke_kho_thanh_pham td {
                padding-left: 5px;
            }

            #tbl_list_cay_thanh_pham td {
                padding-left: 5px;
                padding-right: 5px;
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
                            <!-- FORM SUBMIT -->
                            <div style="margin-top:18px;margin-left:20px;">
                                {!! Form::open(array('route' => 'route_post_kho_thanh_pham', 'method' => 'post', 'id' => 'frm_chon_kho_thanh_pham')) !!}
                                    <b>Chọn kho thành phẩm:</b>
                                    <select id="id_kho_thanh_pham" name="id_kho_thanh_pham" style="margin-left:5px;margin-right:5px;">
                                        @foreach ($list_kho_thanh_pham as $kho_thanh_pham)
                                            <option value="{{ $kho_thanh_pham->id }}" {{ (isset($kho_thanh_pham_duoc_chon) && ($kho_thanh_pham->id == $kho_thanh_pham_duoc_chon->id))?'selected':'' }}>
                                                {{ $kho_thanh_pham->ten }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="submit" value="Xem">
                                    <input type="hidden" id="xem_tat_ca_cay_thanh_pham" name="xem_tat_ca_cay_thanh_pham" value="false">
                                    <input type="hidden" id="loc" name="loc" value="false">
                                    <input type="hidden" id="id_loai_vai" name="id_loai_vai" value="">
                                    <input type="hidden" id="id_mau" name="id_mau" value="">
                                    <input type="hidden" id="kho" name="kho" value="">
                                    <input type="hidden" id="xoa" name="xoa" value="false">
                                    <input type="hidden" id="list_id_cay_thanh_pham_muon_xoa" name="list_id_cay_thanh_pham_muon_xoa" value="">
                                {!! Form::close() !!}
                            </div>
                            <!-- END FORM SUBMIT -->
                            @if (isset($list_cay_thanh_pham))
                                <div style="margin-left:20px;margin-top:16px;">
                                    <div id="button_group" style="float:left;width:57%;">
                                        <input type="button" value="Xem tất cả cây thành phẩm" onclick="xemTatCaCayThanhPham()">
                                        <input type="button" value="Nhập vải thành phẩm" onclick="nhapVaiThanhPham()" style="margin-left:5px;margin-right:5px;">
                                        <input type="button" value="Cập nhật cây thành phẩm" onclick="capNhatCayThanhPham()">
                                    </div>
                                    <div id="div_loc_cay_thanh_pham_ton_kho" style="float:right;width:40%;">
                                        Lọc cây thành phẩm tồn kho theo:
                                        <table id="tbl_loc_cay_thanh_pham_ton_kho" style="height:100px;">
                                            <tr>
                                                <td>+ Loại vải:</td>
                                                <td style="padding-left:5px;">
                                                    <select id="idLoaiVai" name="idLoaiVai">
                                                        @foreach ($list_loai_vai as $loai_vai)
                                                            <option value="{{ $loai_vai->id }}" {{ (isset($loai_vai_duoc_chon) && ($loai_vai->id == $loai_vai_duoc_chon->id))?'selected':'' }}>
                                                                {{ $loai_vai->ten }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>+ Màu:</td>
                                                <td style="padding-left:5px;">
                                                    <select id="idMau" name="idMau">
                                                        @foreach ($list_mau as $mau)
                                                            <option value="{{ $mau->id }}" {{ (isset($mau_duoc_chon) && ($mau->id == $mau_duoc_chon->id))?'selected':'' }}>
                                                                {{ $mau->ten }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>+ Khổ (m):</td>
                                                <td style="padding-left:5px;">
                                                    <select id="Kho" name="Kho">
                                                        @foreach ($list_kho as $kho)
                                                            <option value="{{ $kho }}" {{ (isset($kho_duoc_chon) && ($kho == $kho_duoc_chon))?'selected':'' }}>
                                                                {{ number_format($kho, 1, ',', '.') }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td style="padding-left:5px;">
                                                    <input type="button" value="Lọc" onclick="loc()">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div style="clear:both;"></div>
                                    <div id="thong_ke_kho_thanh_pham">
                                        <h2 style="text-align:center;margin-bottom:0px;">Danh sách cây vải thành phẩm{{ isset($tong_so_cay_thanh_pham)?'':' tồn kho' }}</h2>
                                        <h3 style="margin-top:0px;margin-bottom:5px;">{{ $kho_thanh_pham_duoc_chon->ten }}</h3>
                                        @if (isset($message))
                                            <div style="text-align:center;color:red;margin-top:25px;">{{ $message }}</div>
                                        @else
                                            <table id="tbl_thong_ke_kho_thanh_pham">
                                                @if (isset($loai_vai_duoc_chon))
                                                    <tr>
                                                        <td style="padding-left:0px;">Loại vải:</td>
                                                        <td>{{ $loai_vai_duoc_chon->ten }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left:0px;">Màu:</td>
                                                        <td>{{ $mau_duoc_chon->ten }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left:0px;">Khổ:</td>
                                                        <td>{{ number_format($kho_duoc_chon, 1, ',', '.') }} m</td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td style="padding-left:0px;">
                                                        Tổng số cây thành phẩm{{ isset($tong_so_cay_thanh_pham)?'':' tồn kho' }}:
                                                    </td>
                                                    <td>
                                                        {{ isset($tong_so_cay_thanh_pham)?number_format($tong_so_cay_thanh_pham, 0, ',', '.'):number_format($tong_so_cay_thanh_pham_ton_kho, 0, ',', '.') }} cây
                                                    </td>
                                                </tr>
                                                @if (!isset($loai_vai_duoc_chon))
                                                    @foreach ($soCayThanhPhamTheoLoaiVai as $element)
                                                        <tr>
                                                            <td style="padding-left:0px;">Loại vải {{ $element->ten_loai_vai }}:</td>
                                                            <td>{{ number_format($element->so_cay_thanh_pham, 0, ',', '.') }} cây</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </table>
                                        @endif
                                    </div>
                                    @if (!isset($message))
                                        <!-- PHÂN TRANG -->
                                        <div id="phan_trang" style="margin-top:5px;">
                                            {!! $list_cay_thanh_pham->render() !!}
                                        </div>
                                        <!-- END PHÂN TRANG -->
                                        <!-- LIST CÂY THÀNH PHẨM -->
                                        <div id="list_cay_thanh_pham" style="margin-top:5px;margin-bottom:15px;">
                                            <table id="tbl_list_cay_thanh_pham" border="1px solid black" style="border-collapse:collapse;">
                                                <tr style="text-align:center;font-weight:bold;">
                                                    <td style="width:59px;">Mã cây thành phẩm</td>
                                                    <td style="width:59px;">Mã cây mộc</td>
                                                    @if (!isset($loai_vai_duoc_chon))
                                                        <td style="width:111px;">Loại vải</td>
                                                        <td style="width:0px;">Màu</td>
                                                        <td style="width:0px;">Khổ (m)</td>
                                                    @endif
                                                    <td style="width:0px;">Số mét</td>
                                                    <td style="width:110px;">Đơn giá (VNĐ/m)</td>
                                                    <td style="width:63px;">Thành tiền (VNĐ)</td>
                                                    <td style="width:0px;">Mã lô nhuộm</td>
                                                    <td style="width:143px;">Ngày giờ nhập kho</td>
                                                    @if (isset($tong_so_cay_thanh_pham))
                                                        <td style="width:76px;">Mã hóa đơn xuất</td>
                                                        <td style="width:76px;">Tình trạng</td>
                                                    @endif
                                                    @if ($showButtonXoa == true)
                                                        <td>
                                                            <input type="button" value="Xóa" onclick="xoa()">
                                                        </td>
                                                    @endif
                                                </tr>
                                                @foreach ($list_cay_thanh_pham as $cay_thanh_pham)
                                                    <tr style="text-align:center;">
                                                        <td style="text-align:right;">
                                                            <a href="{{ route('route_get_cap_nhat_cay_vai_thanh_pham', ['id_cay_vai_thanh_pham' => $cay_thanh_pham->id]) }}">
                                                                {{ $cay_thanh_pham->id }}
                                                            </a>
                                                        </td>
                                                        <td style="text-align:right;">{{ $cay_thanh_pham->id_cay_vai_moc }}</td>
                                                        @if (!isset($loai_vai_duoc_chon))
                                                            <td style="text-align:left;">{{ $cay_thanh_pham->ten_loai_vai }}</td>
                                                            <td style="text-align:left;">{{ $cay_thanh_pham->ten_mau }}</td>
                                                            <td style="text-align:right;">{{ number_format($cay_thanh_pham->kho, 1, ',', '.') }}</td>
                                                        @endif
                                                        <td style="text-align:right;">{{ number_format($cay_thanh_pham->so_met, 0, ',', '.') }}</td>
                                                        <td style="text-align:right;">{{ ($cay_thanh_pham->don_gia == null)?'':number_format($cay_thanh_pham->don_gia, 0, ',', '.') }}</td>
                                                        <td style="text-align:right;">{{ ($cay_thanh_pham->thanh_tien == null)?'':number_format($cay_thanh_pham->thanh_tien, 0, ',', '.') }}</td>
                                                        <td style="text-align:right;">{{ $cay_thanh_pham->id_lo_nhuom }}</td>
                                                        <td>{{ $cay_thanh_pham->ngay_gio_nhap_kho }}</td>
                                                        @if (isset($tong_so_cay_thanh_pham))
                                                            <td style="text-align:right;">{{ $cay_thanh_pham->id_hoa_don_xuat }}</td>
                                                            <td>{{ $cay_thanh_pham->tinh_trang }}</td>
                                                        @endif
                                                        @if ($showButtonXoa == true)
                                                            <td>
                                                                <input type="checkbox" value="{{ $cay_thanh_pham->id }}">
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        <!-- END LIST CÂY THÀNH PHẨM -->
                                    @endif
                                </div>
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
            // Đổi ký hiệu "<<" thành "Previous" và ">>" thành "Next" trong chuỗi button phân trang
            $('ul.pagination > li:first > span').text('Previous');
            $('ul.pagination > li:first > a').text('Previous');
            $('ul.pagination > li:last > span').text('Next');
            $('ul.pagination > li:last > a').text('Next');

            function xemTatCaCayThanhPham()
            {
                $('#xem_tat_ca_cay_thanh_pham').val('true');

                // Submit
                //var url = "{{ route('route_post_kho_thanh_pham') }}";
                //$('#frm_chon_kho_thanh_pham').attr('action', url);
                $('#frm_chon_kho_thanh_pham').submit();
            }

            function nhapVaiThanhPham()
            {
                // Chuyển tới trang Nhập vải thành phẩm
                var url = "{{ route('route_get_nhap_vai_thanh_pham') }}";
                window.location.href = url;
            }

            function capNhatCayThanhPham()
            {
                // Chuyển tới trang Cập nhật cây vải thành phẩm
                var url = "{{ route('route_get_cap_nhat_cay_vai_thanh_pham') }}";
                window.location.href = url;
            }

            function loc()
            {
                $('#loc').val('true');
                var id_loai_vai = $('#idLoaiVai').val();
                var id_mau = $('#idMau').val();
                var kho = $('#Kho').val();
                $('#id_loai_vai').val(id_loai_vai);
                $('#id_mau').val(id_mau);
                $('#kho').val(kho);

                // Submit
                //var url = "{{ route('route_post_kho_thanh_pham') }}";
                //$('#frm_chon_kho_thanh_pham').attr('action', url);
                $('#frm_chon_kho_thanh_pham').submit();
            }

            function xoa()
            {
                // Không có cây thành phẩm nào được chọn
                if ($('input[type=checkbox]:checked').length == 0)
                {
                    alert('Bạn chưa chọn cây thành phẩm nào để xóa !');
                    return false;
                }
                else    // Có ít nhất 1 cây thành phẩm được chọn
                {
                    var answer = confirm('Bạn chắc chắn muốn xóa ?');
                    if (answer == true)
                    {
                        var id_cay_thanh_pham_muon_xoa;
                        var list_id_cay_thanh_pham_muon_xoa = '';

                        // Thiết lập chuỗi danh sách id cây thành phẩm muốn xóa
                        $('input[type=checkbox]:checked').each(function() {
                            id_cay_thanh_pham_muon_xoa = $(this).val();
                            list_id_cay_thanh_pham_muon_xoa += id_cay_thanh_pham_muon_xoa + ',';
                        });
                        list_id_cay_thanh_pham_muon_xoa = list_id_cay_thanh_pham_muon_xoa.substring(0, list_id_cay_thanh_pham_muon_xoa.length - 1);

                        // Submit
                        $('#xoa').val('true');
                        $('#list_id_cay_thanh_pham_muon_xoa').val(list_id_cay_thanh_pham_muon_xoa);
                        //var url = "{{ route('route_post_kho_thanh_pham') }}";
                        //$('#frm_chon_kho_thanh_pham').attr('action', url);
                        $('#frm_chon_kho_thanh_pham').submit();
                    }
                    else
                    {
                        return false;
                    }
                }
            }
        </script>
    </body>
</html>
