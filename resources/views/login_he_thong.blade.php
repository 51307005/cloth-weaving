<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login hệ thống</title>

        <link href="{{ url('/') }}/resources/assets/css/bootstrap-3.3.7.css" type="text/css" rel="stylesheet">
        <script src="{{ url('/') }}/resources/assets/js/jquery-3.1.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/bootstrap-3.3.7.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="container" class="container">
            <h1>Đăng nhập hệ thống quản lý thông tin của doanh nghiệp dệt vải ABC</h1>
            @if (isset($errorMessage))
                <script> alert({{ $errorMessage }}) </script>
            @endif
            {!! Form::open(array('route' => 'route_post_login_he_thong', 'method' => 'post', 'id' => 'frm_login_admin')) !!}
                <table id="tbl_login_admin">
                    <tr>
                        <td>Tên đăng nhập: </td>
                        <td>
                            <input type="text" id="username" name="username" value="{{ old('username') }}" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Mật khẩu: </td>
                        <td>
                            <input type="password" id="password" name="password" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" value="Login">
                            <input type="reset" value="Reset">
                        </td>
                    </tr>
                </table>
            {!! Form::close() !!}
        </div>
    </body>
</html>
