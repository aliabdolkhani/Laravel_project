<meta name="description" content="Salon Begir">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="assets/css/normalize.css">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/fontello.css">
        <link href="assets/fonts/icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet">
        <link href="assets/fonts/icon-7-stroke/css/helper.css" rel="stylesheet">
        <link href="assets/css/animate.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="assets/css/bootstrap-select.min.css"> 
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/icheck.min_all.css">
        <link rel="stylesheet" href="assets/css/price-range.css">
        <link rel="stylesheet" href="assets/css/owl.carousel.css">
        <link rel="stylesheet" href="assets/css/owl.theme.css">
        <link rel="stylesheet" href="assets/css/owl.transitions.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/responsive.css">
        <link rel="stylesheet" href="fonts/yekan.css">
        <style>
            *
            {
                font-family: 'Yekan';
            }
        </style>
        <div id="preloader">
            <div id="status">&nbsp;</div>
        </div>
        <!-- Body content -->

        <div class="header-connect">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-sm-8  col-xs-12">
                        <div class="header-half header-call">
                            <p>
                                <span><i class="pe-7s-call"></i> 09386942030 </span>
                                <span><i class="pe-7s-mail"></i> salonbegir@gmail.com</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-2 col-md-offset-5  col-sm-3 col-sm-offset-1  col-xs-12">
                        <div class="header-half header-social">
                            <ul class="list-inline">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <!--End top header -->

        <nav class="navbar navbar-default ">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse yamm" id="navigation">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                    <div class="button navbar-right">
                        <a class="navbar-btn nav-button wow bounceInRight login" href="{{ url('/dashboard') }}" data-wow-delay="0.45s">میزکار</a>
                    </div>
                    @else
                        <div class="button navbar-right">
                            <a class="navbar-btn nav-button wow bounceInRight login" href="{{ url('/login') }}" data-wow-delay="0.45s">ورود به حساب</a>
                        </div>
                        @if (Route::has('register'))
                            <div class="button navbar-right">
                                <a class="navbar-btn nav-button wow bounceInRight login" href="{{ url('/register') }}" data-wow-delay="0.45s">ثبت نام</a>
                            </div>
                        @endif
                    @endauth
                </div>
            @endif
                    <ul class="main-nav nav navbar-nav navbar-right">
                        <li class="wow fadeInDown" data-wow-delay="0.2s"><a class="" href="{{ url('/my_complexes') }}">ورزشگاه‌های شما</a></li>
                        <li class="wow fadeInDown" data-wow-delay="0.2s"><a class="" href="{{ url('/my_salon_reserves') }}">رزروهای شما</a></li>
                        @if(Auth::id() == 1)
                        <li class="wow fadeInDown" data-wow-delay="0.2s"><a class="" href="{{ url('/complexes_verify') }}">ورزشگاه های تایید نشده</a></li>
                        @endif
                        <li class="wow fadeInDown" data-wow-delay="0.2s"><a class="" href="{{ url('/') }}">خانه</a></li>
<?php /* ?>
                        <li class="dropdown yamm-fw" data-wow-delay="0.4s">
                        </li>
                        <li class="dropdown ymm-sw " data-wow-delay="0.1s">
                            <a href="index.html" class="dropdown-toggle active" data-toggle="dropdown" data-hover="dropdown" data-delay="200">خانه </a>
                        </li>
<?php */ ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End of nav bar -->
