<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/img/logo_project.png')}}">

    <!-- CSS
	============================================ -->
    <link rel="stylesheet" href="{{asset("admin/css/animate.css")}}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset("admin/css/vendor/bootstrap.min.css")}}">

    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{asset("css/nprogress.css")}}"/>
    <link rel="stylesheet" href="{{asset("admin/css/notification/notifications.css")}}"/>
    <link rel="stylesheet" href="{{asset("admin/css/summernote/summernote-bs4.css")}}"/>
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{asset("admin/css/plugins.css")}}">

    <!-- Helper CSS -->
    <link rel="stylesheet" href="{{asset("admin/css/helper.css")}}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{asset("admin/css/style.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/main.css")}}">
    @yield('after_style')
    <style>
        body{
            font-family: "Times New Roman", serif !important;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body class="skin-dark">

<div class="main-wrapper">
    <!-- Header Section Start -->
    @include('admin.layout.header')
    <!-- Side Header Start -->
    @include('admin.layout.menu_nav')
    <!-- Side Header End -->

    <!-- Content Body Start -->
    <div class="content-body">
        <div class="row justify-content-between align-items-center mb-10">
            <div class="col-12 col-lg-auto mb-20">
                <div class="page-heading">
                    @yield('content-heading')
                </div>
            </div>
        </div>

        @yield('content-body')
    </div>


    @yield('modal')
    <!-- Footer Section Start -->
    <div class="footer-section">
        <div class="container-fluid">
            <div class="footer-copyright text-center">
                <p class="text-body-light">2020 &copy;</p>
            </div>
        </div>
    </div>
</div>

<!-- JS
============================================ -->

<!-- Global Vendor, plugins & Activation JS -->
<script src="{{asset("admin/js/vendor/modernizr-3.6.0.min.js")}}"></script>
<script src="{{asset("admin/js/vendor/jquery-3.3.1.min.js")}}"></script>
<script src="{{asset("admin/js/vendor/popper.min.js")}}"></script>
<script src="{{asset("admin/js/vendor/bootstrap.min.js")}}"></script>
<!--Plugins JS-->
<script src="{{asset("admin/js/vendor/perfect-scrollbar.min.js")}}"></script>
<script src="{{asset("admin/js/tippy4.min.js.js")}}"></script>
<script src="{{asset("admin/js/main.js")}}"></script>
<script src="{{asset("js/nprogress.js")}}"></script>
<script src="{{asset("admin/js/datatables/datatables.min.js")}}"></script>
<script src="{{asset("admin/js/datatables/datatables.active.js")}}"></script>
<script src="{{asset("admin/js/dropify/dropify.min.js")}}"></script>
<script src="{{asset("admin/js/dropify/dropify.active.js")}}"></script>
<script src="{{asset("admin/js/notification/notifications.js")}}"></script>
<script src="{{asset("admin/js/hullabaloo/hullabaloo.js")}}"></script>
<script src="{{asset("admin/js/select2/select2.full.min.js")}}"></script>
<script src="{{asset("admin/js/select2/select2.active.js")}}"></script>
<script src="{{asset("admin/js/summernote/summernote-bs4.min.js")}}"></script>
<script src="{{asset("admin/js/summernote/summernote.active.js")}}"></script>
<script src="{{asset("admin/js/daterangepicker/moment.min.js")}}"></script>
<script src="{{asset("admin/js/daterangepicker/daterangepicker.js")}}"></script>
<script src="{{asset("admin/js/daterangepicker/daterangepicker.active.js")}}"></script>
<script src="{{asset("admin/js/chartjs/Chart.min.js")}}"></script>
<script src="{{asset("admin/js/chartjs/chartjs.active.js")}}"></script>
@yield('after_script')
<script>
    $('body').show();
    NProgress.start();
    setTimeout(function() {
        NProgress.done(); $('.fade').removeClass('out');
        }, 500);
</script>
<script type="text/javascript">
    var hulla = new hullabaloo();

    @if(session('message'))
        hulla.send('{{session('message')}}', '{{session('status')}}');
    @endif

    $('form').submit(function () {
        //run spinner when submit form
        var btn = undefined;
        if($(this).find("button[type='submit']").length > 0){
            btn = $(this).find("button[type='submit']");
        } else if($(this).find("button.btn-submit").length > 0){
            btn = $(this).find("button.btn-submit");
        }
        if(btn != undefined){
            loadSpinnerForButton(btn,true);
        }

    });

    function loadSpinnerForButton(elem,isLoading = false){
        if(elem.find('.spinner-border').length === 0){
            elem.append('<span class="spinner-border spinner-border-sm ml-1 d-none"></span>');
        }
        if(isLoading){
            elem.attr('disabled', true).find('.spinner-border').removeClass('d-none');
            elem.attr('disabled', true).find('.fa').addClass('d-none');
        }else{
            elem.attr('disabled', false).find('.spinner-border').addClass('d-none');
            elem.attr('disabled', true).find('.fa').removeClass('d-none');
        }

    }
</script>
</body>

</html>
