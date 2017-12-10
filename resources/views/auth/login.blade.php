<!DOCTYPE html>

<html>
    <head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="csrf-token" content= "{{csrf_token()}}">

        <title>Log in</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <link rel="stylesheet" type="text/css" href="{{asset('adminLTE/bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('adminLTE/dist/css/AdminLTE.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('adminLTE/plugins/iCheck/square/blue.css')}}">
    </head>

    <body class="hold-transition login-page">

        <div class="login-box">
            <div class="login-logo">
                <img src="{{asset('images/logo.png')}}" width="100">
            </div>

            <div class="login-box-body">
                <p class="login-box-msg">Login untuk menggunakan aplikasi</p>

               <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                    <div class="form-group has-feedback">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input id="password" type="password" class="form-control" name="password" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="row">
                        
                        <div class="col-xs-4">
                             <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script src="{{asset('adminLTE/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
        <script src="{{asset('adminLTE/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('adminLTE/plugins/iCheck/icheck.min.js')}}"></script>

        <script>
            $(function(){
                $('input').iCheck({
                    checkboxClass: 'icheckbox square-blue',
                    radioClass : 'iradio square-blue',
                    increaseArea: '20%'
                });
            });
        </script>

    </body>
    </html>