<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->

    <link rel="stylesheet" href="{{ mix('css/backend_all.css') }}">

</head>
<body class="hold-transition login-page">

{{--<a href="{{ route('register') }}">Register</a>--}}

@yield('content')


<!-- /.admin-box -->

<!-- jQuery 3 -->
<script src="{{ mix('js/backend_all.js') }}">
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
</script>
</body>
</html>
