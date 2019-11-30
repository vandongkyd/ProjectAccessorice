<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('pager title')</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Electro Store Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design"
    />
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- //Meta tag Keywords -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('/img/logo_project.png')}}">
    <!-- Custom-Files -->
    <link href="{{asset("shop/css/bootstrap.css")}}" rel="stylesheet" type="text/css" media="all" />
    <!-- Bootstrap css -->
    <link href="{{asset("shop/css/style.css")}}" rel="stylesheet" type="text/css" media="all" />
    <!-- Main css -->
    <link rel="stylesheet" href="{{asset("shop/css/fontawesome-all.css")}}">
    <!-- Font-Awesome-Icons-CSS -->
    <link href="{{asset("shop/css/popuo-box.css")}}" rel="stylesheet" type="text/css" media="all" />
    <!-- pop-up-box -->
    <link href="{{asset("shop/css/menu.css")}}" rel="stylesheet" type="text/css" media="all" />
    <!-- menu style -->
    <!-- //Custom-Files -->

    <!-- web fonts -->
    <link href="//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&amp;subset=latin-ext" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
          rel="stylesheet">
    <!-- //web fonts -->
    <link href="{{asset('shop/css/customstyle.css')}}" rel="stylesheet">

</head>

<body>
<!-- top-header -->
@include('shop.layout.header')

<!-- banner -->
@yield('block banner')
<!-- //banner -->


{{--content--}}
@yield('block content')

<!-- top Products -->
@yield('block product')

<!-- middle section -->
<div class="join-storesl1 py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">
        <div class="row">
            <div class="col-lg-6">
                <div class="join-electronics text-left p-4">
                    <div class="row">
                        <div class="col-sm-7 offer-name">
                            <h6>Smooth, Rich & Loud Audio</h6>
                            <h4 class="mt-2 mb-3">Branded Headphones</h4>
                            <p>Sale up to 25% off all in store</p>
                        </div>
                        <div class="col-sm-5 offerimg-storesl">
                            <img src="images/off1.png" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-lg-0 mt-5">
                <div class="join-electronics text-left p-4">
                    <div class="row ">
                        <div class="col-sm-7 offer-name">
                            <h6>A Bigger Phone</h6>
                            <h4 class="mt-2 mb-3">Smart Phones 5</h4>
                            <p>Free shipping order over $100</p>
                        </div>
                        <div class="col-sm-5 offerimg-storesl">
                            <img src="images/off2.png" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- middle section -->

<!-- footer -->
@include('shop.layout.footer')

<!-- //footer -->

<!-- js-files -->
<!-- jquery -->
<script src="{{asset("shop/js/jquery-2.2.3.min.js")}}"></script>
<!-- //jquery -->

<!-- nav smooth scroll -->
<script>
    $(document).ready(function () {
        $(".dropdown").hover(
            function () {
                $('.dropdown-menu', this).stop(true, true).slideDown("fast");
                $(this).toggleClass('open');
            },
            function () {
                $('.dropdown-menu', this).stop(true, true).slideUp("fast");
                $(this).toggleClass('open');
            }
        );
    });
</script>
<!-- //nav smooth scroll -->

<!-- popup modal (for location)-->
<script src="{{asset("shop/js/jquery.magnific-popup.js")}}"></script>
<script>
    $(document).ready(function () {
        $('.popup-with-zoom-anim').magnificPopup({
            type: 'inline',
            fixedContentPos: false,
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: true,
            preloader: false,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in'
        });

    });
</script>
<!-- //popup modal (for location)-->

<!-- cart-js -->
<script src="{{asset("shop/js/minicart.js")}}"></script>
<script>
    paypals.minicarts.render(); //use only unique class names other than paypals.minicarts.Also Replace same class name in css and minicart.min.js

    paypals.minicarts.cart.on('checkout', function (evt) {
        var items = this.items(),
            len = items.length,
            total = 0,
            i;

        // Count the number of each item in the cart
        for (i = 0; i < len; i++) {
            total += items[i].get('quantity');
        }

        if (total < 3) {
            alert('The minimum order quantity is 3. Please add more to your shopping cart before checking out');
            evt.preventDefault();
        }
    });
</script>
<!-- //cart-js -->

<!-- password-script -->
<script>
    window.onload = function () {
        document.getElementById("password1").onchange = validatePassword;
        document.getElementById("password2").onchange = validatePassword;
    }

    function validatePassword() {
        var pass2 = document.getElementById("password2").value;
        var pass1 = document.getElementById("password1").value;
        if (pass1 != pass2)
            document.getElementById("password2").setCustomValidity("Passwords Don't Match");
        else
            document.getElementById("password2").setCustomValidity('');
        //empty string means no validation error
    }
</script>
<!-- //password-script -->

<!-- scroll seller -->
<script src="{{asset("shop/js/scroll.js")}}"></script>
<!-- //scroll seller -->

<!-- smoothscroll -->
<script src="{{asset("shop/js/SmoothScroll.min.js")}}"></script>
<!-- //smoothscroll -->

<!-- start-smooth-scrolling -->
<script src="{{asset("shop/js/move-top.js")}}"></script>
<script src="{{asset("shop/js/easing.js")}}"></script>
<script>
    jQuery(document).ready(function ($) {
        $(".scroll").click(function (event) {
            event.preventDefault();

            $('html,body').animate({
                scrollTop: $(this.hash).offset().top
            }, 1000);
        });
    });
</script>
<!-- //end-smooth-scrolling -->

<!-- smooth-scrolling-of-move-up -->
<script>
    $(document).ready(function () {
        /*
        var defaults = {
            containerID: 'toTop', // fading element id
            containerHoverID: 'toTopHover', // fading element hover id
            scrollSpeed: 1200,
            easingType: 'linear'
        };
        */
        $().UItoTop({
            easingType: 'easeOutQuart'
        });

    });
</script>
<!-- //smooth-scrolling-of-move-up -->

<!-- for bootstrap working -->
<script src="{{asset("shop/js/bootstrap.js")}}"></script>
<!-- //for bootstrap working -->
<!-- //js-files -->
</body>

</html>