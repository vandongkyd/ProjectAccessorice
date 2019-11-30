<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('/img/logo_project.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/main_login.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/materialFormStyles.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .header-login{
            min-height: 60px;
            background-color: #006DF0;
        }
        .footer-login{
            width: 100%;
            min-height: 60px;
            background-color: #006DF0;
        }
        .img_logo{
            width: 200px !important;
            min-width: 0;
            height: 70px !important;
        }
        .bg-header{
            text-align: center;
            background-color: white;
            width: 200px !important;
            min-width: 0;
            height: 70px !important;
        }
        body {
            width: 560px;
            height: auto;
            z-index: -9999;
            margin-left: auto;
            margin-right: auto;
            margin-top: 50px;
            margin-bottom: auto;
        }

        canvas {
            background-color: #202334;
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            z-index: -9999;
        }
        #text_note{
            text-align: center;
            width: 100%;
            color: white;
        }
    </style>
</head>
<body>
@yield('block content')
<p id="text_note">Copyright &copy; 2019. Mr.Dong</p>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<script src="{{asset('admin/js/jquery.preloaders.js')}}"></script>
<script src="{{asset('admin/js/materialForm.js')}}"></script>
<script src="{{asset('admin/js/canvasdot.js')}}"></script>
@yield('after_script')
</body>
</html>