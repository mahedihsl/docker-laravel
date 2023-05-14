<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
	<title>My Radar</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="My Radar">
    <meta name="keywords" content="Radar, Car, Vehicle, Tracking">
    <meta name="author" content="HyperSystems">

    <!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Favicons -->
	<link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
	<link rel="apple-touch-icon" href="{{ asset('landing/images/apple-touch-icon.png') }}">
	<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('landing/images/apple-touch-icon-72x72.png') }}">
	<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('landing/images/apple-touch-icon-114x114.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Asap:400,400i,700" rel="stylesheet" type="text/css">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('landing/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/jquery.fancybox.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/style.css') }}">

	{{-- owl.carousel --}}
	<link rel="stylesheet" href="{{ asset('vendors/owl.carousel/dist/assets/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="{{ asset('vendors/owl.carousel/dist/assets/owl.theme.default.min.css') }}">

    <noscript><link rel="stylesheet" href="{{ asset('landing/css/no-js.css') }}"></noscript>

</head>
<body>

    <!-- #header -->
    <header id="header">

        <!-- #navigation -->
        <nav id="navigation" class="navbar scrollspy">

            <!-- .container -->
            <div class="container">

                <div class="navbar-brand">
                	<a href="{{ route('welcome') }}"><img src="{{ asset('images/web_logo.png') }}" alt="Logo"></a> <!-- site logo -->
					myRADAR
                </div>

                <ul class="nav navbar-nav">
                	<li><a href="#header" class="smooth-scroll">Home</a></li>
                    <li><a href="#features" class="smooth-scroll">Features</a></li>
                    <li><a href="#testimonials" class="smooth-scroll">Testimonials</a></li>
                    <li><a href="#screenshots" class="smooth-scroll">Screenshots</a></li>
                    <li><a href="#pricing" class="smooth-scroll">Pricing</a></li>
                    <li class="menu-btn"><a href="{{ route('login') }}">Login</a></li>
                </ul>

            </div>
            <!-- .container end -->

        </nav>
        <!-- #navigation end -->

        <!-- .header-content -->
        <div class="header-content bg-color">

            <!-- .container -->
            <div class="container">

				<div class="owl-carousel" style="margin-top: -100px; width: 800px; height: 600px; margin-left: 120px;">
					<div>
						<img src="{{ asset('images/features/3.png') }}" alt="" class="img-rounded">
						<h4 class="text-center">Track &amp; Relax</h4>
					</div>
					<div>
						<img src="{{ asset('images/features/2.png') }}" alt="" class="img-rounded">
						<h4 class="text-center">Fuel &amp; Gas Monitor</h4>
					</div>
					<div>
						<img src="{{ asset('images/features/1.png') }}" alt="" class="img-rounded">
						<h4 class="text-center">Remote Lock</h4>
					</div>
				</div>

                {{-- <div class="header-txt">
                	<h1>Meet Bestapp for mobile chat</h1>
                </div> --}}

                {{-- <div class="header-btn">
                	<a href="#download" class="btn-custom btn-icon smooth-scroll"><i class="ion ion-ios-cloud-download-outline"></i> Download App</a>
                </div> --}}

                {{-- <figure class="header-img">
                    <div class="img-left">
                        <img src="{{ asset('landing/images/content/landing/header-img-left.png') }}" alt="Image Left" class="animation" data-animation="animation-fade-in-left">
                    </div>
                    <div class="img-center">
                        <img src="{{ asset('landing/images/content/landing/header-img-center.png') }}" alt="Image Center" class="animation" data-animation="animation-fade-in-down" data-delay="400">
                    </div>
                    <div class="img-right">
                        <img src="{{ asset('landing/images/content/landing/header-img-right.png') }}" alt="Image Right" class="animation" data-animation="animation-fade-in-right">
                    </div>
                </figure> --}}

            </div>
            <!-- .container end -->

        </div>
        <!-- .header-content end -->

    </header>
    <!-- #header end -->

    <!-- #features -->
    <div id="features" class="section-wrap padding-top100">

        <!-- .container -->
        <div class="container">

            <div class="post-heading-center">
            	<p><strong>About myRADAR</strong></p>
                <h2>Vehicle Tracking System++</h2>
            </div>

            <!-- .row -->
            <div class="row padding-bottom20">

                <div class="col-sm-4"> <!-- 1 -->
                	<div class="affa-feature-icon">
                    	<i class="ion ion-android-chat"></i>
                        <h4>Enhanced Tracking</h4>
                        <p>Vivamus interdum hendrerit eleifend metus pharetrae enim interdum dolor lacinia eget felis.</p>
                        <a href="#feature1" class="link-more">Learn More</a>
                    </div>
                </div>

                <div class="col-sm-4"> <!-- 2 -->
                	<div class="affa-feature-icon">
                    	<i class="ion ion-ios-locked-outline"></i>
                        <h4>Remote Lock</h4>
                        <p>Vivamus interdum hendrerit eleifend metus pharetrae enim interdum dolor lacinia eget felis.</p>
                        <a href="#feature2" class="link-more">Learn More</a>
                    </div>
                </div>

                <div class="col-sm-4"> <!-- 3 -->
                	<div class="affa-feature-icon">
                    	<i class="ion ion-ios-cloud-outline"></i>
                        <h4>Money Saving</h4>
                        <p>Vivamus interdum hendrerit eleifend metus pharetrae enim interdum dolor lacinia eget felis.</p>
                        <a href="#feature3" class="link-more">Learn More</a>
                    </div>
                </div>

            </div>
            <!-- .row end -->

            {{-- <div class="text-center">
            	<a href="#feature1" class="btn-custom btn-border">Details</a>
            </div> --}}

		</div>
        <!-- .container end -->

        <!-- .container-wrap -->
        <div class="container-wrap container-padding100">

            <div class="container">
            	<div class="row">
                	<div class="col-md-6 col-lg-5 col-txt text-center-sm text-center-xs margin-bottom40-sm margin-bottom40-xs">
                        <div class="post-heading-left">
                        	<h2><strong>Track By Any Device</strong></h2>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Duis aute irure dolor in reprehenderit.</p>
                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                </div>
            </div>

            <div class="col-pull-right">
                <figure class="img-layers3 img-pull-left">
                    <div class="img-layer-lg">
                        <img src="{{ asset('images/devices/laptop.png') }}" alt="Image Large" class="animation" data-animation="animation-fade-in-right">
                    </div>
                    <div class="img-layer-md">
                        <img src="{{ asset('images/devices/ipad.png') }}" alt="Image Mediun" class="animation" data-animation="animation-fade-in-left" data-delay="300">
                    </div>
                    <div class="img-layer-sm">
                        <img src="{{ asset('images/devices/iphone.png') }}" alt="Image Small" class="animation" data-animation="animation-fade-in-down" data-delay="600">
                    </div>
                </figure>
            </div>

        </div>
        <!-- .container-wrap end -->

        <!-- .container-padding -->
        <div class="container-padding10060 bg-color" id="feature1">

            <!-- .container -->
            <div class="container">

                <!-- .row -->
                <div class="row">

                    <div class="col-sm-8 col-md-5 col-sm-offset-2 col-md-offset-0 margin-bottom20">
                        <figure class="img-layers img-layer-right-front">
                            <div class="img-layer-left">
                                <img src="{{ asset('images/features/live-tracking.gif') }}" alt="Live Tracking" class="animation" data-animation="animation-fade-in-left">
                            </div>
                            {{-- <div class="img-layer-right">
                                <img src="{{ asset('landing/images/content/landing/feature-5.png') }}" alt="Image Right" class="animation" data-animation="animation-fade-in-right" data-delay="400">
                            </div> --}}
                        </figure>
                    </div>

                    <div class="col-sm-10 col-md-7 col-lg-6 col-sm-offset-1 col-md-offset-0 col-lg-offset-1">
                        <div class="text-wrap40 text-center-sm text-center-xs">
                            <div class="post-heading-left">
                                <h2>Enhanced Tracking</h2>
                            </div>

                            <p class="margin-bottom30">Lorem ipsum dolor sit amet, consectetur adipiscing elit posuere diam facilisis metus ultricies tristique. Vestibulum feugiat imperdiet arcu gravida suspendisse auctor duis ornare dapibus metus ac accumsan.</p>

                            <div class="affa-feature-icon-left margin-bottom30"> <!-- 1 -->
                                <i class="ion ion-happy-outline"></i>
                                <h4>More Icon Smile</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>

                            <div class="affa-feature-icon-left margin-bottom30"> <!-- 2 -->
                                <i class="ion ion-images"></i>
                                <h4>Coloring Background</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>

                            <div class="affa-feature-icon-left"> <!-- 3 -->
                                <i class="ion ion-ios-bookmarks"></i>
                                <h4>Easy to Use</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- .row end -->

            </div>
            <!-- .container end -->

        </div>
        <!-- .container-padding end -->

        <!-- .container-padding -->
        <div class="container-padding10060 bg-grey" id="feature2">

            <!-- .container -->
            <div class="container">

                <!-- .row -->
                <div class="row">

                    <div class="col-sm-6 col-md-5 margin-bottom40">
                        <div class="text-wrap100">
                            <div class="post-heading-left text-center-xs">
                                <h2>Remote Lock</h2>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit posuere diam facilisis metus ultricies tristique. Vestibulum feugiat imperdiet arcu gravida suspendisse auctor duis ornare dapibus metus ac accumsan.</p>
                            <div class="list-icon margin-bottom0">
                                <ul>
                                    <li><i class="ion ion-android-done"></i> Reliable and secure platform</li>
                                    <li><i class="ion ion-android-done"></i> Everything is perfectly orgainized for future</li>
                                    <li><i class="ion ion-android-done"></i> Attach large files easily</li>
                                    <li><i class="ion ion-android-done"></i> Forwarding email accounts for free</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-7 margin-bottom40">
                        <figure class="img-layers2 img-layer-left-front">
                            <div class="" style="margin-top: 100px;">
                                <img src="{{ asset('images/features/remote-lock-geo-fence.png') }}" alt="Image Left" class="animation" data-animation="animation-fade-in-right" data-delay="400">
                            </div>
                            {{-- <div class="img-layer-right">
                                <img src="{{ asset('landing/images/content/landing/feature-7.jpg') }}" alt="Image Right" class="animation" data-animation="animation-fade-in-right">
                            </div> --}}
                        </figure>
                    </div>

                </div>
                <!-- .row end -->

            </div>
            <!-- .container end -->

        </div>
        <!-- .container-padding end -->

		<!-- .container-padding -->
        <div class="container-padding10060 bg-color" id="feature3">

            <!-- .container -->
            <div class="container">

                <!-- .row -->
                <div class="row">

                    <div class="col-sm-8 col-md-7 col-sm-offset-2 col-md-offset-0 margin-bottom20">
                        <figure class="img-layers img-layer-right-front">
                            <div class="" style="margin-top: 50px;">
                                <img src="{{ asset('images/features/money-saving.png') }}" alt="Money Saving" class="animation" data-animation="animation-fade-in-left">
                            </div>
                            {{-- <div class="img-layer-right">
                                <img src="{{ asset('landing/images/content/landing/feature-5.png') }}" alt="Image Right" class="animation" data-animation="animation-fade-in-right" data-delay="400">
                            </div> --}}
                        </figure>
                    </div>

                    <div class="col-sm-10 col-md-5 col-lg-5 col-sm-offset-1 col-md-offset-0 col-lg-offset-0">
                        <div class="text-wrap40 text-center-sm text-center-xs">
                            <div class="post-heading-left">
                                <h2>Money Saving</h2>
                            </div>

                            <p class="margin-bottom30">Lorem ipsum dolor sit amet, consectetur adipiscing elit posuere diam facilisis metus ultricies tristique. Vestibulum feugiat imperdiet arcu gravida suspendisse auctor duis ornare dapibus metus ac accumsan.</p>

                            <div class="affa-feature-icon-left margin-bottom30"> <!-- 1 -->
                                <i class="ion ion-happy-outline"></i>
                                <h4>More Icon Smile</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>

                            <div class="affa-feature-icon-left margin-bottom30"> <!-- 2 -->
                                <i class="ion ion-images"></i>
                                <h4>Coloring Background</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>

                            <div class="affa-feature-icon-left"> <!-- 3 -->
                                <i class="ion ion-ios-bookmarks"></i>
                                <h4>Easy to Use</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- .row end -->

            </div>
            <!-- .container end -->

        </div>
        <!-- .container-padding end -->

		<!-- .container-padding -->
        <div class="container-padding10060 bg-color">

            <!-- .container -->
            <div class="container">

                <!-- .row -->
                <div class="row">

                    <div class="col-sm-6 col-md-5 margin-bottom40">
                        <div class="text-wrap100">
                            <div class="post-heading-left text-center-xs">
                                <h2>Why We Are Different</h2>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit posuere diam facilisis metus ultricies tristique. Vestibulum feugiat imperdiet arcu gravida suspendisse auctor duis ornare dapibus metus ac accumsan.</p>
                            <div class="list-icon margin-bottom0">
                                <ul>
                                    <li><i class="ion ion-android-done"></i> Reliable and secure platform</li>
                                    <li><i class="ion ion-android-done"></i> Everything is perfectly orgainized for future</li>
                                    <li><i class="ion ion-android-done"></i> Attach large files easily</li>
                                    <li><i class="ion ion-android-done"></i> Forwarding email accounts for free</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-7 margin-bottom40">
                        <figure class="img-layers2 img-layer-left-front">
                            <div class="" style="margin-top: 100px;">
                                <img src="{{ asset('images/features/why-different.png') }}" alt="Image Left" class="animation" data-animation="animation-fade-in-right" data-delay="400">
                            </div>
                            {{-- <div class="img-layer-right">
                                <img src="{{ asset('landing/images/content/landing/feature-7.jpg') }}" alt="Image Right" class="animation" data-animation="animation-fade-in-right">
                            </div> --}}
                        </figure>
                    </div>

                </div>
                <!-- .row end -->

            </div>
            <!-- .container end -->

        </div>
        <!-- .container-padding end -->

    </div>
    <!-- #features end -->

    <!-- #works -->
    {{-- <div id="works" class="container-padding10080">

        <!-- .container -->
        <div class="container">

            <div class="post-heading-center no-border margin-bottom40">
                <h2>How It Works?</h2>
            </div>

            <!-- .row -->
            <div class="row">

                <div class="col-sm-4"> <!-- 1 -->
                    <div class="affa-video-img">
                    	<a href="https://www.youtube.com/embed/4ZawV1mXlS8?autoplay=1" class="fancybox-media" title="Play Video" data-fancybox-group="videos_gallery">
                        	<figure>
                            	<img src="{{ asset('landing/images/content/works/1.jpg') }}" alt="Image">
                                <div class="video-img-masked"></div>
                            </figure>
                        </a>
                        <div class="video-img-txt">
                            <h4>How to sent the chat?</h4>
                            <p>03:40</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4"> <!-- 2 -->
                    <div class="affa-video-img">
                        <a href="https://www.youtube.com/embed/4ZawV1mXlS8?autoplay=1" class="fancybox-media" title="Play Video" data-fancybox-group="videos_gallery">
                        	<figure>
                            	<img src="{{ asset('landing/images/content/works/2.jpg') }}" alt="Image">
                                <div class="video-img-masked"></div>
                            </figure>
                        </a>
                        <div class="video-img-txt">
                            <h4>Block user and download list</h4>
                            <p>02:30</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4"> <!-- 3 -->
                	<div class="affa-video-img">
                    	<a href="https://www.youtube.com/embed/4ZawV1mXlS8?autoplay=1" class="fancybox-media" title="Play Video" data-fancybox-group="videos_gallery">
                        	<figure>
                            	<img src="{{ asset('landing/images/content/works/3.jpg') }}" alt="Image">
                                <div class="video-img-masked"></div>
                            </figure>
                        </a>
                        <div class="video-img-txt">
                            <h4>Booking ticket from chat</h4>
                            <p>01:48</p>
                        </div>
                    </div>
                </div>

            </div>
            <!-- .row end -->

        </div>
        <!-- .container end -->

    </div> --}}
    <!-- #works end -->

    <!-- #features2 -->
    <div id="features2">

        <!-- .container -->
        <div class="container">

            <div class="post-heading-center">
                <p>For You</p>
                <h2>Services make best Conversation</h2>
            </div>

            <!-- .row -->
            <div class="row padding-bottom40">

                <div class="col-sm-4"> <!-- 1 -->
                    <div class="affa-feature-icon-left2">
                        <i class="ion ion-android-alarm-clock"></i>
                        <h4>24/7 Support</h4>
                        <p>Lorem ipsum dolor sit amet timpor, consectetur adipisicing elit, lorem elit ipsum dolor sit metus amet.</p>
                    </div>
                </div>

                <div class="col-sm-4"> <!-- 2 -->
                    <div class="affa-feature-icon-left2">
                        <i class="ion ion-android-call"></i>
                        <h4>Call Support</h4>
                        <p>Lorem ipsum dolor sit amet timpor, consectetur adipisicing elit, lorem elit ipsum dolor sit metus amet.</p>
                    </div>
                </div>

                <div class="col-sm-4"> <!-- 3 -->
                    <div class="affa-feature-icon-left2">
                        <i class="ion ion-lock-combination"></i>
                        <h4>Secure</h4>
                        <p>Lorem ipsum dolor sit amet timpor, consectetur adipisicing elit, lorem elit ipsum dolor sit metus amet.</p>
                    </div>
                </div>

            </div>
            <!-- .row end -->

            <!-- .row -->
            <div class="row">

                <div class="col-md-10 col-md-offset-1">
                	<div class="img-layers-wrap">
                    	<figure class="img-layers4 img-md-left">
                        	<div class="img-layer-lg">
                            	<img src="{{ asset('landing/images/content/landing/feature-1.png') }}" alt="Image Large" class="animation" data-animation="animation-fade-in-up">
                            </div>
                            <div class="img-layer-md">
                                <img src="{{ asset('landing/images/content/landing/feature-8.png') }}" alt="Image Medium" class="animation" data-animation="animation-fade-in-up" data-delay="300">
                            </div>
                            <div class="img-layer-sm">
                            	<img src="{{ asset('landing/images/content/landing/feature-3.png') }}" alt="Image Small" class="animation" data-animation="animation-fade-in-up" data-delay="600">
                            </div>
                        </figure>
                    </div>
                </div>

            </div>
            <!-- .row end -->

        </div>
        <!-- .container end -->

    </div>
    <!-- #features2 end -->

    <!-- #testimonials -->
    {{-- <div id="testimonials" class="bg-color bg-dark container-padding100" style="background-image:url(landing/images/bg-testimonials-carousel.png);">

        <!-- .container -->
        <div class="container">

            <div class="post-heading-center no-border">
                <p>What They Says</p>
                <h2>They Said this is So Cool</h2>
            </div>

            <!-- .affa-testimonials-carousel -->
            <div class="affa-testimonials-carousel">
                <div class="carousel-slider">

                    <div class="slick-slide"> <!-- 1 -->
                        <div class="affa-testimonial">
                            <div class="testimonial-name">
                                <img src="{{ asset('landing/images/content/avatars/1.jpg') }}" alt="Avatar">
                                <h4>Amah Holland</h4>
                                <p>Social Media Manager of MG</p>
                            </div>
                            <div class="testimonial-txt">
                                <p>"Lorem ipsum dolor consectetur adipiscing elit, sed do eiusmod tempor incididunt labore et dolore magna aliqua. Enim id minim veniam exercitation laboris consequat. Duis aute dolor reprehende ritin voluptate reprehenderit labore et dolore cillum fugiatos."</p>
                            </div>
                            <div class="testimonial-rate">
                                <span class="testimonial-rate-val" style="width:100%;">5</span>
                            </div>
                        </div>
                    </div>

                    <div class="slick-slide"> <!-- 2 -->
                        <div class="affa-testimonial">
                            <div class="testimonial-name">
                                <img src="{{ asset('landing/images/content/avatars/2.jpg') }}" alt="Avatar">
                                <h4>Mugiwara Kiwolen</h4>
                                <p>CEO & Founder of AffaGroup</p>
                            </div>
                            <div class="testimonial-txt">
                                <p>"Lorem ipsum dolor consectetur adipiscing elit, sed do eiusmod tempor incididunt labore et dolore magna aliqua. Enim id minim veniam exercitation laboris consequat. Duis aute dolor reprehende ritin voluptate reprehenderit labore et dolore cillum fugiatos."</p>
                            </div>
                            <div class="testimonial-rate">
                                <span class="testimonial-rate-val" style="width:100%;">5</span>
                            </div>
                        </div>
                    </div>

                    <div class="slick-slide"> <!-- 3 -->
                        <div class="affa-testimonial">
                            <div class="testimonial-name">
                                <img src="{{ asset('landing/images/content/avatars/3.jpg') }}" alt="Avatar">
                                <h4>Bebbh Cwan</h4>
                                <p>Comunity Manager of Avelie</p>
                            </div>
                            <div class="testimonial-txt">
                                <p>"Lorem ipsum dolor consectetur adipiscing elit, sed do eiusmod tempor incididunt labore et dolore magna aliqua. Enim id minim veniam exercitation laboris consequat. Duis aute dolor reprehende ritin voluptate reprehenderit labore et dolore cillum fugiatos."</p>
                            </div>
                            <div class="testimonial-rate">
                                <span class="testimonial-rate-val" style="width:100%;">5</span>
                            </div>
                        </div>
                    </div>

                    <div class="slick-slide"> <!-- 4 -->
                        <div class="affa-testimonial">
                            <div class="testimonial-name">
                                <img src="{{ asset('landing/images/content/avatars/4.jpg') }}" alt="Avatar">
                                <h4>Rendy Jagerjack</h4>
                                <p>Marketing Leader of MochiHijab</p>
                            </div>
                            <div class="testimonial-txt">
                                <p>"Lorem ipsum dolor consectetur adipiscing elit, sed do eiusmod tempor incididunt labore et dolore magna aliqua. Enim id minim veniam exercitation laboris consequat. Duis aute dolor reprehende ritin voluptate reprehenderit labore et dolore cillum fugiatos."</p>
                            </div>
                            <div class="testimonial-rate">
                                <span class="testimonial-rate-val" style="width:100%;">5</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- .affa-testimonials-carousel end -->

        </div>
        <!-- .container end -->

    </div> --}}
    <!-- #testimonials end -->

    <!-- #screenshots -->
    <div id="screenshots" class="container-padding100">

        <!-- .container -->
    	<div class="container">

            <div class="post-heading-center">
            	{{-- <p>Awesome Screenshots</p> --}}
                <h2>App Screenshots</h2>
            </div>

            <div class="carousel-slider gallery-slider">
            	<div class="slick-slide"> <!-- 1 -->
                	<div class="img-hover">
                    	{{-- <h4>Account Login Form</h4> --}}
                        <a href="{{ asset('images/screenshots/1.jpg') }}" class="fancybox" data-fancybox-group="images_gallery" title="">
                            <figure>
                                <img src="{{ asset('images/screenshots/1.jpg') }}" alt="Account Login Form">
                                <div class="hover-masked"></div>
                            </figure>
                        </a>
                    </div>
                </div>

                <div class="slick-slide"> <!-- 2 -->
                	<div class="img-hover">
                    	{{-- <h4>Installation Guide</h4> --}}
                        <a href="{{ asset('images/screenshots/2.jpg') }}" class="fancybox" data-fancybox-group="images_gallery" title="">
                            <figure>
                                <img src="{{ asset('images/screenshots/2.jpg') }}" alt="Installation Guide">
                                <div class="hover-masked"></div>
                            </figure>
                        </a>
                    </div>
                </div>

                <div class="slick-slide"> <!-- 3 -->
                	<div class="img-hover">
                    	{{-- <h4>Profile Dashboard</h4> --}}
                        <a href="{{ asset('images/screenshots/3.jpg') }}" class="fancybox" data-fancybox-group="images_gallery" title="">
                            <figure>
                                <img src="{{ asset('images/screenshots/3.jpg') }}" alt="Profile Dashboard">
                                <div class="hover-masked"></div>
                            </figure>
                        </a>
                    </div>
                </div>

                <div class="slick-slide"> <!-- 4 -->
                	<div class="img-hover">
                    	{{-- <h4>Music Background</h4> --}}
                        <a href="{{ asset('images/screenshots/4.jpg') }}" class="fancybox" data-fancybox-group="images_gallery" title="">
                            <figure>
                                <img src="{{ asset('images/screenshots/4.jpg') }}" alt="Music Background">
                                <div class="hover-masked"></div>
                            </figure>
                        </a>
                    </div>
                </div>

                <div class="slick-slide"> <!-- 6 -->
                    <div class="img-hover">
                    	{{-- <h4>Minimalize Player</h4> --}}
                        <a href="{{ asset('images/screenshots/5.jpg') }}" class="fancybox" data-fancybox-group="images_gallery" title="">
                            <figure>
                                <img src="{{ asset('images/screenshots/5.jpg') }}" alt="Minimalize Player">
                                <div class="hover-masked"></div>
                            </figure>
                        </a>
                    </div>
                </div>

            </div>

        </div>
        <!-- .container end -->

    </div>
    <!-- #screenshots end -->

    <!-- #pricing -->
    <div id="pricing" class="bg-color container-padding100">

        <!-- .container -->
    	<div class="container">

            <div class="post-heading-center">
            	<p>Pricing</p>
                <h2>Choose Your Package</h2>
            </div>

            <!-- .affa-tbl-pricing -->
            <div class="affa-tbl-pricing">
                <div class="row">

                    <div class="col-sm-3 tbl-prc-col"> <!-- 1 -->
                        <div class="tbl-prc-wrap">
                            <div class="tbl-prc-header">
                                <i class="ion ion-ios-chatboxes-outline"></i>
                                <h4>Basic</h4>
                                <p>Live &amp; Record Tracking</p>
                                <p>Lock Engine Remotely</p>
                                <p>5 Geofences</p>

                            </div>
                            <div class="tbl-prc-price">
                                <h4>BDT 6000</h4>
                            </div>
                            <div class="tbl-prc-footer">
                                <a href="#contact" class="btn-custom">Book Now</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 tbl-prc-col current"> <!-- 2 -->
                        <div class="tbl-prc-wrap">
                            <div class="tbl-prc-header">
                                <i class="ion ion-ios-briefcase-outline"></i>
                                <h4>Pro</h4>
								<p>All Basic Features</p>
                                <p>10 Geofences</p>
                                <p>Fuel &amp; Gas Monitoring</p>
                            </div>
                            <div class="tbl-prc-price">
                                <h4>BDT 8000</h4>
                            </div>
                            <div class="tbl-prc-footer">
                                <a href="#contact" class="btn-custom">Book Now</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 tbl-prc-col"> <!-- 3 -->
                        <div class="tbl-prc-wrap">
                            <div class="tbl-prc-header">
                                <i class="ion ion-ios-color-filter-outline"></i>
                                <h4>Advance</h4>
								<p>All Pro Features</p>
                                <p>Unlimited Geofence</p>
                                <p>Camera Surveillance</p>
                            </div>
                            <div class="tbl-prc-price">
                                <h4>BDT 12000</h4>
                            </div>
                            <div class="tbl-prc-footer">
                                <a href="#contact" class="btn-custom">Book Now</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 tbl-prc-col"> <!-- 4 -->
                        <div class="tbl-prc-wrap">
                            <div class="tbl-prc-header">
                                <i class="ion ion-ios-world-outline"></i>
                                <h4>Business</h4>
								<p>Fleet Management</p>
                                <p>Energy Optimization</p>
                                <p>+ And Many More</p>
                            </div>
                            <div class="tbl-prc-price">
                                <h4>Custom</h4>
                            </div>
                            <div class="tbl-prc-footer">
                                <a href="#contact" class="btn-custom">Book Now</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- .affa-tbl-pricing end -->

        </div>
        <!-- .container end -->

    </div>
    <!-- #pricing end -->

    <div class="container">
    	<div class="sep-border"></div> <!-- separator -->
    </div>

    <!-- #counter -->
    {{-- <div id="counter" class="container-padding12080">

        <!-- .container -->
        <div class="container">

            <!-- .row -->
            <div class="row">

                <div class="col-sm-4"> <!-- 1 -->
                    <div class="affa-counter-txt">
                        <h4><span>128</span>K</h4>
                        <i class="ion ion-ios-cloud-download-outline"></i>
                        <p>Downloads</p>
                    </div>
                </div>

                <div class="col-sm-4"> <!-- 2 -->
                    <div class="affa-counter-txt">
                        <h4><span>3280</span></h4>
                        <i class="ion ion-ios-heart-outline"></i>
                        <p>Happy Users</p>
                    </div>
                </div>

                <div class="col-sm-4"> <!-- 3 -->
                    <div class="affa-counter-txt">
                        <h4><span>25</span>K</h4>
                        <i class="ion ion-ios-pulse"></i>
                        <p>App Likes</p>
                    </div>
                </div>

            </div>
            <!-- .row end -->

        </div>
        <!-- .container end -->

    </div> --}}
    <!-- #counter end -->

    <!-- #download -->
    <div id="download" class="bg-color bg-parallax" data-parallax="scroll" data-speed="0.2" data-natural-width="1920" data-natural-height="1080" data-image-src="/landing/images/content/bg/1.jpg">

        <!-- .bg-overlay -->
        <div class="bg-overlay bg-overlay80 container-padding120 text-center">

            <!-- .container -->
            <div class="container">

                <div class="post-heading-center no-border margin-bottom30">
                	<h2>Download MyRadar</h2>
                </div>

                <p class="text-big text-padding margin-bottom0">Morbi eu elit viverra lacus aliquet pulvinar nullam at arcu a augue ornare congue. Quis mattis nislim integer posuere neque pretium, pulvinar lectus eget, facilisis magna proin nec sem rutrum.</p>

                <div class="margin-top40">
                	<a href="https://itunes.apple.com/th/app/myradar-tracker/id1318152957?mt=8&ign-mpt=uo%3D2" title="Download from App Store" class="btn-appstore">App Store</a>
                    <a href="https://play.google.com/store/apps/details?id=com.mobile.hs.hyperware" title="Download from Play Store" class="btn-playstore">Play Store</a>
                </div>

            </div>
            <!-- .container end -->

        </div>
        <!-- .bg-overlay end -->

    </div>
    <!-- #download end -->

    <!-- #clients -->
    <div id="clients" class="container-padding10060">

        <!-- .container -->
        <div class="container">

            <div class="post-heading-center">
            	{{-- <p>Big Users?</p> --}}
                <h2>Our Partners</h2>
            </div>

            <!-- .row -->
            <div class="row row-clients">

                <div class="col-sm-4"> <!-- 1 -->
                    <div class="affa-client-logo" style="width: 200px;">
                        <img src="{{ asset('images/partners/banglalink.jpg') }}" alt="Logo">
                    </div>
                </div>

                <div class="col-sm-4"> <!-- 3 -->
                    <div class="affa-client-logo" style="width: 250px;">
                    	<img src="{{ asset('images/partners/robi.jpg') }}" alt="Logo">
                    </div>
                </div>

				<div class="col-sm-4"> <!-- 2 -->
                    <div class="affa-client-logo">
                        <img src="{{ asset('images/partners/jural.png') }}" alt="Logo">
                    </div>
                </div>

            </div>
            <!-- .row end -->

        </div>
        <!-- .container end -->

    </div>
    <!-- #clients end -->

    <div class="container">
    	<div class="sep-border"></div> <!-- separator -->
    </div>

    <!-- #footer -->
    <footer id="footer">

        <!-- #contact -->
        <div id="contact" class="container-padding10080">

            <!-- .container -->
            <div class="container">

                <div class="post-heading-center">
                    {{-- <p>Let’s Discussion with Us</p> --}}
                    <h2>Keep in touch</h2>
                </div>

                <!-- .row -->
                <div class="row padding-bottom20">

                    <div class="col-sm-4"> <!-- 1 -->
                        <div class="affa-contact-info">
                            <div class="contact-info-heading">
                                <p>+880 29820209</p>
                                <p>+880 29820393</p>
                            </div>
                            <i class="ion ion-ios-telephone-outline"></i>
                            <h4>Phone Number</h4>
                        </div>
                    </div>

                    <div class="col-sm-4"> <!-- 2 -->
                        <div class="affa-contact-info">
                            <div class="contact-info-heading">
                                <p><a href="mailto:support@affapress.com">hs@hypersystems.com.bd</a></p>
                                <p><a href="mailto:admin@affapress.com">hscare@hypersystems.com.bd</a></p>
                            </div>
                            <i class="ion ion-ios-email-outline"></i>
                            <h4>Email Address</h4>
                        </div>
                    </div>

                    <div class="col-sm-4"> <!-- 3 -->
                        <div class="affa-contact-info">
                            <div class="contact-info-heading">
                                <p>Tower Hamlet (5th Floor)<br>16 Kemal Ataturk Avenue, Banani C/A</p>
                            </div>
                            <i class="ion ion-map"></i>
                            <h4>Business Address</h4>
                        </div>
                    </div>

                </div>
                <!-- .row end -->

                <div class="row">
                    <div class="col-md-10 col-lg-8 col-md-offset-1 col-lg-offset-2">
                        <form action="#" method="post" class="affa-form-contact">
                        	<div class="submit-status"></div> <!-- submit status -->
                            <input type="text" name="name" placeholder="Your Name">
                            <input type="text" name="email" placeholder="Email Address *">
                            <textarea name="message" placeholder="Message *"></textarea>
                            <div class="form-contact-submit">
                            	{{-- <label for="send_copy"><input type="checkbox" name="send_copy" id="send_copy"> Send a copy to my email</label> --}}
                                <input type="submit" name="submit" value="Send Message" class="btn-border">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <!-- .container end -->

        </div>
        <!-- #contact end -->

        <!-- .footer-txt -->
        <div class="footer-txt">

            <!-- .container -->
            <div class="container">

                <div class="footer-logo">
					{{-- <img src="{{ asset('landing/images/logo_footer.png') }}" alt="Logo"> --}}
					<a href="{{ route('welcome') }}">
						<img src="{{ asset('images/web_logo.png') }}" alt="Logo">
					</a> <!-- site logo -->
					myRADAR
				</div> <!-- site logo -->

                <div class="footer-copyright">
                	<p class="copyright-txt">&copy; 2017, by <a href="../../../index.html" target="_blank">HyperSystems.com.bd</a></p>
                    <div class="socials">
                    	<a href="https://www.facebook.com/myradartracker/" title="Facebook"><i class="ion ion-social-facebook"></i></a>
                        <a href="#" title="Twitter"><i class="ion ion-social-twitter"></i></a>
                        <a href="#" title="Youtube"><i class="ion ion-social-youtube"></i></a>
                        <a href="#" title="Dribbble"><i class="ion ion-social-dribbble"></i></a>
                    </div>
                </div>

            </div>
            <!-- .container end -->

        </div>
        <!-- .footer-txt end -->

        <a href="#" class="scrollup" title="Back to Top!"><i class="ion ion-ios-arrow-up"></i></a>

    </footer>
    <!-- #footer end -->

    <!-- JavaScripts -->
	<script type="text/javascript" src="{{ asset('landing/js/jquery-1.11.3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('landing/js/jquery-migrate-1.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('landing/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('landing/js/jquery.easing.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('landing/js/smoothscroll.js') }}"></script>
	<script type="text/javascript" src="{{ asset('landing/js/response.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('landing/js/jquery.placeholder.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('landing/js/jquery.fitvids.js') }}"></script>
	<script type="text/javascript" src="{{ asset('landing/js/jquery.imgpreload.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('landing/js/waypoints.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('landing/js/slick.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('landing/js/jquery.fancybox.pack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('landing/js/jquery.fancybox-media.js') }}"></script>
    <script type="text/javascript" src="{{ asset('landing/js/jquery.counterup.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('landing/js/parallax.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendors/owl.carousel/dist/owl.carousel.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('landing/js/script.js') }}"></script>

	<script type="text/javascript">
	$(document).ready(function(){
		$('.owl-carousel').owlCarousel({
			items: 1,
			loop: true,
			margin: 20,
			autoplay: true,
			autoplaySpeed: 1000,
			autoplayTimeout: 5000,
			animateOut: 'fadeOut',
    		animateIn: 'fadeIn',
		});
	});
	</script>

</body>
</html>
