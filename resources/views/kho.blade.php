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
                    Chọn chức năng mà bạn muốn sử dụng.
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
    </body>
</html>
