<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Quản lý Sản xuất</title>

        <link href="{{ url('/') }}/resources/assets/css/bootstrap-3.3.7.css" type="text/css" rel="stylesheet">
        <script src="{{ url('/') }}/resources/assets/js/jquery-3.1.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/bootstrap-3.3.7.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="container" class="container">
            <div id="content">
                <!-- HEADER -->
                <div style="margin-top:15px;border:1px solid black;">
                    <div style="float:left;width:80%;text-align:center;color:red;">
                        <h2>QUẢN LÝ SẢN XUẤT</h2>
                    </div>
                    <div style="float:left;width:20%;margin-top:16px;">
                        <span>Xin chào <b>{{ Session::get('username') }}</b></span><br>
                        <a href="{{ route('route_get_logout_he_thong') }}">Đăng xuất</a>
                    </div>
                    <div style="clear:both;"></div>
                </div>
                <!-- END HEADER -->
                <!-- NỘI DUNG -->
                <div style="border:1px solid black;border-top:none;height:530px;">
                    <!-- LIST CHỨC NĂNG -->
                    <div id="chuc_nang" style="float:left;width:19%;height:100%;border-right:1px solid black;">
                        <div style="font-weight:bold;text-align:center;border-bottom:1px solid black;">Chức năng</div>
                        <ul style="list-style-type:none;padding-left:0px;">
                            @foreach ($list_chuc_nang as $chuc_nang => $link)
                            <li style="border-bottom:1px solid black;padding-left:10px;">
                                    <a href="{{ $link }}">{{ $chuc_nang }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- END LIST CHỨC NĂNG -->
                    <!-- MAIN CONTENT -->
                    <div id="main_content" style="float:left;width:78%;height:100%;margin-top:20px;margin-left:28px;">
                        Chọn chức năng mà bạn muốn sử dụng.
                    </div>
                    <!-- END MAIN CONTENT -->
                    <div style="clear:both;"></div>
                </div>
                <!-- END NỘI DUNG -->
            </div>
        </div>
    </body>
</html>
