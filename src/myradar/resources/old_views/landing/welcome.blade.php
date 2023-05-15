<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
  <title>myRADAR</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="My Radar">
  <meta name="keywords" content="Radar, Car, Vehicle, Tracking">
  <meta name="author" content="HyperSystems">

  <!-- Mobile Specific Meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- Favicons -->
  <link rel="shortcut icon" href="{{ asset('images/favicon.ico', true) }}">
  <link rel="apple-touch-icon" href="{{ asset('landing/images/apple-touch-icon.png', true) }}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('landing/images/apple-touch-icon-72x72.png', true) }}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('landing/images/apple-touch-icon-114x114.png', true) }}">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,700" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Asap:400,400i,700" rel="stylesheet" type="text/css">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="{{ asset('landing/css/bootstrap.min.css', true) }}">
  <link rel="stylesheet" href="{{ asset('landing/css/ionicons.min.css', true) }}">
  <link rel="stylesheet" href="{{ asset('landing/css/slick.css', true) }}">
  <link rel="stylesheet" href="{{ asset('landing/css/slick-theme.css', true) }}">
  <link rel="stylesheet" href="{{ asset('landing/css/jquery.fancybox.css', true) }}">
  <link rel="stylesheet" href="{{ asset('landing/css/animate.min.css', true) }}">
  <link rel="stylesheet" href="{{ asset('landing/css/style.css', true) }}">
  {{-- owl.carousel --}}
  <link rel="stylesheet" href="{{ asset('vendors/owl.carousel/dist/assets/owl.carousel.min.css', true) }}">
  <link rel="stylesheet" href="{{ asset('vendors/owl.carousel/dist/assets/owl.theme.default.min.css', true) }}">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
    integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

  <noscript>
    <link rel="stylesheet" href="{{ asset('landing/css/no-js.css', true) }}"></noscript>
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <style type="text/css">
    @keyframes tada {
      from {
        transform: scale3d(1, 1, 1);
      }

      10%,
      20% {
        transform: scale3d(0.9, 0.9, 0.9) rotate3d(0, 0, 1, -3deg);
      }

      30%,
      50%,
      70%,
      90% {
        transform: scale3d(1.3, 1.3, 1.3) rotate3d(0, 0, 1, 3deg);
      }

      40%,
      60%,
      80% {
        transform: scale3d(1.3, 1.3, 1.3) rotate3d(0, 0, 1, -3deg);
      }

      to {
        transform: scale3d(1, 1, 1);
      }
    }

    .tada {
      animation: tada 1.5s infinite;
    }

    .product-banner {
      background-image: linear-gradient(to right, #92fe9d 0%, #00c9ff 100%);
    }
  </style>

  <!-- Facebook Pixel Code -->
  <script>
    !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '265998565115584');
  fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=265998565115584&ev=PageView&noscript=1" /></noscript>
  <!-- End Facebook Pixel Code -->
</head>

<body>

  <!-- #header -->
  <header id="header">

    @include('landing.nav')
    @include('landing.header')

  </header>
  <!-- #header end -->

  <!-- #features -->
  <div id="features" class="section-wrap padding-top20">

    @include('landing.about')
    @include('landing.device')

    @include('landing.tracking')
    @include('landing.remote_lock')
    {{-- @include('landing.money_save') --}}

    @include('landing.different')

  </div>
  <!-- #features end -->

  {{-- @include('landing.how_work') --}}

  <!-- #features2 -->
  @include('landing.service')
  <!-- #features2 end -->

  {{-- @include('landing.testimonial') --}}

  <!-- #screenshots -->
  @include('landing.screenshot')
  <!-- #screenshots end -->

  <!-- #pricing -->
  @include('landing.pricing')
  <!-- #pricing end -->

  <div class="container">
    <div class="sep-border"></div> <!-- separator -->
  </div>

  <!-- #counter -->
  {{-- @include('landing.counter') --}}
  <!-- #counter end -->

  <!-- #download -->
  @include('landing.download')
  <!-- #download end -->

  <!-- #clients -->
  @include('landing.partner')
  <!-- #clients end -->

  <div class="container">
    <div class="sep-border"></div> <!-- separator -->
  </div>

  <!-- #footer -->
  <footer id="footer">

    <!-- #contact -->
    @include('landing.contact')
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
          <p class="copyright-txt">&copy; 2017, by <a href="{{route('welcome')}}"
              target="_blank">HyperSystems.com.bd</a></p>
          <div class="socials">
            <a href="https://www.facebook.com/myradartracker/" title="Facebook" target="_blank"><i
                class="ion ion-social-facebook"></i></a>
            {{-- <a href="#" title="Twitter"><i class="ion ion-social-twitter"></i></a>
                  <a href="#" title="Youtube"><i class="ion ion-social-youtube"></i></a>
                  <a href="#" title="Dribbble"><i class="ion ion-social-dribbble"></i></a> --}}
          </div>
        </div>

      </div>
      <!-- .container end -->

    </div>
    <!-- .footer-txt end -->

    <a href="#" class="" title="Back to Top!"><i class="ion ion-ios-arrow-up"></i></a>

  </footer>
  <!-- #footer end -->

  <!-- JavaScripts -->
  <script type="text/javascript" src="{{ asset('landing/js/jquery-1.11.3.min.js', true) }}"></script>
  <script type="text/javascript" src="{{ asset('landing/js/jquery-migrate-1.2.1.min.js', true) }}"></script>
  <script type="text/javascript" src="{{ asset('landing/js/bootstrap.min.js', true) }}"></script>


  <script type="text/javascript" src="{{ asset('landing/js/jquery.placeholder.min.js', true) }}"></script>
  <script type="text/javascript" src="{{ asset('landing/js/jquery.fitvids.js', true) }}"></script>
  <script type="text/javascript" src="{{ asset('landing/js/jquery.imgpreload.min.js', true) }}"></script>
  <script type="text/javascript" src="{{ asset('landing/js/waypoints.min.js', true) }}"></script>
  <script type="text/javascript" src="{{ asset('landing/js/slick.min.js', true) }}"></script>
  <script type="text/javascript" src="{{ asset('landing/js/jquery.fancybox.pack.js', true) }}"></script>

  <script type="text/javascript" src="{{ asset('landing/js/jquery.counterup.min.js', true) }}"></script>
  <script type="text/javascript" src="{{ asset('landing/js/parallax.min.js', true) }}"></script>
  <script type="text/javascript" src="{{ asset('vendors/owl.carousel/dist/owl.carousel.min.js', true) }}"></script>
  <script type="text/javascript" src="{{ asset('landing/js/script.js', true) }}"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#btn-e-heater').click(function() {
        window.location.href = 'http://myradar.com.bd/eheater'
      })
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