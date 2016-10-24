<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Quản lý Kho</title>

        <link href="{{ url('/') }}/resources/assets/css/bootstrap-3.3.7.css" type="text/css" rel="stylesheet">
        <script src="{{ url('/') }}/resources/assets/js/jquery-3.1.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/bootstrap-3.3.7.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="container" class="container">
            <div id="content">
                <h2>QUẢN LÝ KHO</h2>
                <div id="chuc_nang" style="float:left;width:30%;">
                    <div style="font-weight:bold;text-align:center;">Chức năng</div>
                    <ul style="list-style-type:none;">
                        @foreach ($list_chuc_nang as $chuc_nang => $link)
                            <li>
                                <a href="{{ $link }}">{{ $chuc_nang }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div id="main_content" style="float:left;width:70%;">
                    {!! Form::open(array('route' => 'route_post_kho_moc', 'method' => 'post', 'id' => 'frm_chon_kho_moc')) !!}
                        <b>Chọn kho mộc: </b>
                        <select id="id_kho_moc" name="id_kho_moc">
                            @foreach ($list_kho_moc as $kho_moc)
                                <option value="{{ $kho_moc->id }}" {{ (isset($kho_moc_duoc_chon) && ($kho_moc->id == $kho_moc_duoc_chon->id))?'selected':'' }}>{{ $kho_moc->ten }}</option>
                            @endforeach
                        </select>
                        <input type="submit" value="Xem">
                        <input type="hidden" id="xem_tat_ca_cay_moc" name="xem_tat_ca_cay_moc" value="false">
                        <input type="hidden" id="loc_theo_loai_vai" name="loc_theo_loai_vai" value="false">
                        <input type="hidden" id="id_loai_vai" name="id_loai_vai" value="">
                        <input type="hidden" id="xoa" name="xoa" value="false">
                        <input type="hidden" id="list_id_cay_moc_muon_xoa" name="list_id_cay_moc_muon_xoa" value="">
                    {!! Form::close() !!}
                    @if (isset($list_cay_moc))
                        <div id="button_group" style="float:left;">
                            <input type="button" value="Xem tất cả cây mộc" onclick="xemTatCaCayMoc()">
                            <input type="button" value="Nhập mộc" onclick="nhapMoc()">
                            <input type="button" value="Cập nhật cây mộc" onclick="capNhatCayMoc()">
                        </div>
                        <div id="loc_cay_moc_ton_kho_theo_loai_vai" style="float:left;">
                            Lọc cây mộc tồn kho theo loại vải: 
                            <select id="idLoaiVai" name="idLoaiVai">
                                @foreach ($list_loai_vai as $loai_vai)
                                    <option value="{{ $loai_vai->id }}" {{ (isset($loai_vai_duoc_chon) && ($loai_vai->id == $loai_vai_duoc_chon->id))?'selected':'' }}>{{ $loai_vai->ten }}</option>
                                @endforeach
                            </select>
                            <input type="button" value="Lọc" onclick="loc()">
                        </div>
                        <div style="clear:both;"></div>
                        <div id="thong_ke_kho_moc">
                            <h2 style="text-align:center;">Danh sách cây mộc {{ isset($loai_vai_duoc_chon)?$loai_vai_duoc_chon->ten:'' }} {{ isset($tong_so_cay_moc)?'':'tồn kho' }}</h2>
                            <h3>{{ $kho_moc_duoc_chon->ten }}</h3>
                            @if (isset($message))
                                <div style="text-align:center;color:red;">{{ $message }}</div>
                            @else
                                <table id="tbl_thong_ke_kho_moc">
                                    <tr>
                                        <td>Tổng số cây mộc {{ isset($loai_vai_duoc_chon)?$loai_vai_duoc_chon->ten:'' }} {{ isset($tong_so_cay_moc)?'':'tồn kho' }}:</td>
                                        <td>{{ isset($tong_so_cay_moc)?$tong_so_cay_moc:$tong_so_cay_moc_ton_kho }} cây</td>
                                    </tr>
                                    @if (!isset($loai_vai_duoc_chon))
                                        @foreach ($soCayMocTheoLoaiVai as $element)
                                            <tr>
                                                <td>Loại vải {{ $element->ten_loai_vai }}:</td>
                                                <td>{{ $element->so_cay_moc }} cây</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            @endif
                        </div>
                        @if (!isset($message))
                            <div id="list_cay_moc">
                                <table id="tbl_list_cay_moc">
                                    <tr style="text-align:center;font-weight:bold;">
                                        <td>Mã cây mộc</td>
                                        @if (!isset($loai_vai_duoc_chon))
                                            <td>Loại vải</td>
                                        @endif
                                        <td>Số mét</td>
                                        <td>Nhân viên dệt</td>
                                        <td>Mã máy dệt</td>
                                        <td>Ngày giờ dệt</td>
                                        <td>Ngày giờ nhập kho</td>
                                        @if (isset($tong_so_cay_moc))
                                            <td>Mã phiếu xuất mộc</td>
                                            <td>Tình trạng</td>
                                            <td>Mã lô nhuộm</td>
                                        @endif
                                        @if ($showButtonXoa == true)
                                            <td>
                                                <input type="button" value="Xóa" onclick="xoa()">
                                            </td>
                                        @endif
                                    </tr>
                                    @foreach ($list_cay_moc as $cay_moc)
                                        <tr style="text-align:center;">
                                            <td>
                                                <a href="{{ route('route_get_cap_nhat_cay_moc_co_id', ['id_cay_moc' => $cay_moc->id]) }}">
                                                    {{ $cay_moc->id }}
                                                </a>
                                            </td>
                                            @if (!isset($loai_vai_duoc_chon))
                                                <td style="text-align:left;">{{ $cay_moc->ten_loai_vai }}</td>
                                            @endif
                                            <td style="text-align:right;">{{ $cay_moc->so_met }}</td>
                                            <td style="text-align:left;">{{ $cay_moc->ten_nhan_vien_det }}</td>
                                            <td>{{ $cay_moc->ma_may_det }}</td>
                                            <td>{{ $cay_moc->ngay_gio_det }}</td>
                                            <td>{{ $cay_moc->ngay_gio_nhap_kho }}</td>
                                            @if (isset($tong_so_cay_moc))
                                                <td>{{ $cay_moc->id_phieu_xuat_moc }}</td>
                                                <td style="text-align:left;">{{ $cay_moc->tinh_trang }}</td>
                                                <td>{{ $cay_moc->id_lo_nhuom }}</td>
                                            @endif
                                            @if ($showButtonXoa == true)
                                                <td>
                                                    <input type="checkbox" value="{{ $cay_moc->id }}">
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div id="phan_trang">{!! $list_cay_moc->render() !!}</div>
                        @endif
                    @endif
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
        <script>
            function xemTatCaCayMoc()
            {
                $('#xem_tat_ca_cay_moc').val('true');

                // Submit
                //var url = "{{ route('route_post_kho_moc') }}";
                //$('#frm_chon_kho_moc').attr('action', url);
                $('#frm_chon_kho_moc').submit();
            }

            function nhapMoc()
            {
                // Chuyển tới trang Nhập mộc
                var url = "{{ route('route_get_nhap_moc') }}";
                window.location.href = url;
            }

            function capNhatCayMoc()
            {
                // Chuyển tới trang Cập nhật cây mộc
                var url = "{{ route('route_get_cap_nhat_cay_moc_khong_id') }}";
                window.location.href = url;
            }

            function loc()
            {
                $('#loc_theo_loai_vai').val('true');
                var id_loai_vai = $('#idLoaiVai').val();
                $('#id_loai_vai').val(id_loai_vai);

                // Submit
                //var url = "{{ route('route_post_kho_moc') }}";
                //$('#frm_chon_kho_moc').attr('action', url);
                $('#frm_chon_kho_moc').submit();
            }

            function xoa()
            {
                // Không có cây mộc nào được chọn
                if ($('input[type=checkbox]:checked').length == 0)
                {
                    alert('Bạn chưa chọn cây mộc nào để xóa !');
                    return false;
                }
                else    // Có ít nhất 1 cây mộc được chọn
                {
                    var answer = confirm('Bạn chắc chắn muốn xóa ?');
                    if (answer == true)
                    {
                        var id_cay_moc_muon_xoa;
                        var list_id_cay_moc_muon_xoa = '';

                        // Thiết lập chuỗi danh sách id cây mộc muốn xóa
                        $('input[type=checkbox]:checked').each(function() {
                            id_cay_moc_muon_xoa = $(this).val();
                            list_id_cay_moc_muon_xoa += id_cay_moc_muon_xoa + ',';
                        });
                        list_id_cay_moc_muon_xoa = list_id_cay_moc_muon_xoa.substring(0, list_id_cay_moc_muon_xoa.length - 1);

                        // Submit
                        $('#xoa').val('true');
                        $('#list_id_cay_moc_muon_xoa').val(list_id_cay_moc_muon_xoa);
                        //var url = "{{ route('route_post_kho_moc') }}";
                        //$('#frm_chon_kho_moc').attr('action', url);
                        $('#frm_chon_kho_moc').submit();
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
