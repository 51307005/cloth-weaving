<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Đăng nhập hệ thống</title>

        <link href="{{ url('/') }}/resources/assets/css/bootstrap-3.3.7.css" type="text/css" rel="stylesheet">
        <script src="{{ url('/') }}/resources/assets/js/jquery-3.1.1.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/resources/assets/js/bootstrap-3.3.7.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="container" class="container">
            <h1>Đăng nhập hệ thống quản lý thông tin của doanh nghiệp dệt vải ABC</h1>
            <!-- FORM LOGIN -->
            {!! Form::open(array('route' => 'route_post_login_he_thong', 'method' => 'post', 'id' => 'frm_login_admin')) !!}
                <table id="tbl_login_admin" style="width:320px;height:120px;">
                    <tr>
                        <td>Tên đăng nhập: </td>
                        <td>
                            <input class="form-control" type="text" id="username" name="username" value="{{ old('username') }}" required style="width:200px;">
                        </td>
                    </tr>
                    <tr>
                        <td>Mật khẩu: </td>
                        <td>
                            <input class="form-control" type="password" id="password" name="password" required style="width:200px;">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input class="btn btn-primary btn-md" type="submit" value="Login">
                            <input class="btn btn-success btn-md" type="reset" value="Reset">
                        </td>
                    </tr>
                </table>
            {!! Form::close() !!}
            <!-- END FORM LOGIN -->
            @if (count($errors) > 0 || isset($errorMessage))
                <!-- ERROR MESSAGES -->
                <div id="error_messages" class="alert alert-info" style="margin-top:5px;">
                    <ul style="padding-left:0px;color:red;">
                        @if (count($errors) > 0)
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @endif  
                        @if (isset($errorMessage))
                            <li>{{ $errorMessage }}</li>
                        @endif
                    </ul>
                </div>
                <!-- END ERROR MESSAGES -->
            @endif
        </div>
    </body>
</html>
