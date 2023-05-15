<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Global site tag (gtag.js) - Google Analytics from BB -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-XHBSG0NL4Z"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }

    gtag("js", new Date());

    gtag("config", "G-XHBSG0NL4Z");
  </script>

  <meta charset="utf-8">
  <meta name="viewport"
        content="height=device-height, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, target-densitydpi=device-dpi">

  <title>Best Vehicle Tracking System in Bangladesh-myRADAR.com.bd</title>

  <meta name="title" content="Best Vehicle Tracking System in Bangladesh-myRADAR.com.bd">
  <meta name="description"
        content="myRadar offers Best Vehicle Tracking System in Bangladesh and the best GPS tracking service in Bangladesh with advanced IoT Devices.">
  <meta name="keywords"
        content="Vehicle Tracking System in Bangladesh, Smart GPS Tracker, vehicle tracker in bangladesh">
  <meta name="robots" content="index, follow">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="language" content="English">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <!-- Mobile Specific Meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- Favicons -->
  <link rel="shortcut icon" href="{{ asset('images/favicon.ico', true) }}">
  <link rel="apple-touch-icon" href="{{ asset('landing/images/apple-touch-icon.png', true) }}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('landing/images/apple-touch-icon-72x72.png', true) }}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('landing/images/apple-touch-icon-114x114.png', true) }}">

  <!-- Google Fonts -->
  <link
          href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
          rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('landing2/assets/vendor/bootstrap/css/bootstrap.min.css', true) }}" rel="stylesheet">
  <link href="{{ asset('landing2/assets/vendor/bootstrap-icons/bootstrap-icons.css', true) }}" rel="stylesheet">
  <link href="{{ asset('landing2/assets/vendor/aos/aos.css', true) }}" rel="stylesheet">
  <link href="{{ asset('landing2/assets/vendor/remixicon/remixicon.css', true) }}" rel="stylesheet">
  <link href="{{ asset('landing2/assets/vendor/swiper/swiper-bundle.min.css', true) }}" rel="stylesheet">
  <link href="{{ asset('landing2/assets/vendor/glightbox/css/glightbox.min.css', true) }}" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('vendors/fa5/css/all.css') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <!-- Template Main CSS File -->
  <link href="{{ asset('landing2/assets/css/style.css', true) }}" rel="stylesheet">
  <link href="{{ asset('css/tailwind.css?v='.config('cache.version'), true) }}" rel="stylesheet">
  <style>
    [x-cloak] {
      display: none;
    }
  </style>

  <!-- Facebook Pixel Code -->
  <script>
    !function(f, b, e, v, n, t, s) {
      if (f.fbq) return;
      n = f.fbq = function() {
        n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments);
      };
      if (!f._fbq) f._fbq = n;
      n.push = n;
      n.loaded = !0;
      n.version = "2.0";
      n.queue = [];
      t = b.createElement(e);
      t.async = !0;
      t.src = v;
      s = b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t, s);
    }(window, document, "script",
            "https://connect.facebook.net/en_US/fbevents.js");
    fbq("init", "3090022934604360");
    fbq("track", "PageView");
  </script>
  <noscript>
    <img height="1" width="1"
         src="https://www.facebook.com/tr?id=3090022934604360&ev=PageView
&noscript=1" />
  </noscript>
  <!-- End Facebook Pixel Code -->

  <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body x-data="{
  showOfferModal: false,
  interest: new URLSearchParams(location.search).get('interest'),
  offerForm: {
    phone: '',
    type: 'lucky_coupon_lead',
  },
  response: {
    available: false,
    success: false,
    message: '',
  },
  init() {
    console.log('interest', this.interest)
    setTimeout(() => {
      this.showOfferModal = true
    }, 2500)
    if (this.interest === 'offer') {

    }
  },
  registerToOffer() {
    fetch('/enroll/save', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
      },
      body: JSON.stringify(this.offerForm)
    })
    .then(response => response.json())
    .then(data => {
      this.response = {
        available: true,
        success: data.status === 1,
        message: data.data.message,
      }
    })
    .catch(error => console.log(error))
  }
}" @keydown.escape="showOfferModal = false">

@include('revamp.menu', ['base' => ''])

@include('revamp.fab-buttons')
@include('revamp.offer-modal2')
@include('revamp.hero')

<main id="main">
  @include('revamp.values')

  @include('revamp.features')

  <section id="mobile" class="features">
    <div class="container" data-aos="fade-up">
      <!-- Feature Icons -->
      <div class="row feature-icons" data-aos="fade-up">
        <h3 class="@lang('misc.font')">@lang('misc.mobile_app')</h3>

        <div class="row">
          <div class="col-xs-12 d-flex flex-column flex-lg-row">
            <div style="padding: 10px;">
              <img src="{{ asset('images/screenshots/1.jpg', true) }}" alt=""
                   style="width: 100%; border-radius: 4px;" />
            </div>
            <div style="padding: 10px;">
              <img src="{{ asset('images/screenshots/2.jpg', true) }}" alt=""
                   style="width: 100%; border-radius: 4px;" />
            </div>
            <div style="padding: 10px;">
              <img src="{{ asset('images/screenshots/3.jpg', true) }}" alt=""
                   style="width: 100%; border-radius: 4px;" />
            </div>
            <div style="padding: 10px;">
              <img src="{{ asset('images/screenshots/4.jpg', true) }}" alt=""
                   style="width: 100%; border-radius: 4px;" />
            </div>
            <div style="padding: 10px;">
              <img src="{{ asset('images/screenshots/5.jpg', true) }}" alt=""
                   style="width: 100%; border-radius: 4px;" />
            </div>
          </div>
        </div>

      </div>

      <div class="row" style="margin-top: 30px;">
        <div class="col-xs-12 d-flex flex-row justify-content-center align-items-center">
          <a target="_blank" href="{{ config('myradar.appstore') }}" title="Download from App Store"
             class="btn-appstore">App Store</a>
          <a target="_blank" href="{{ config('myradar.playstore') }}" title="Download from Play Store"
             class="btn-playstore">Play Store</a>
        </div>
      </div>
      <!-- End Feature Icons -->
    </div>
  </section>

@include('revamp.pricing')

@include('revamp.faq')

<!-- ======= Clients Section ======= -->
  <section id="clients" class="clients">

    <div class="container" data-aos="fade-up">

      <header class="section-header">
        <h2></h2>
        <p class="@lang('misc.font')">@lang('misc.corporate_partner')</p>
      </header>

      <div class="clients-wrapper">
        <img src="{{ asset('images/partners/banglalink.png', true) }}" alt="">
        <img src="{{ asset('images/partners/robi.png', true) }}" alt="" style="margin: 0 50px;">
        <img src="{{ asset('images/partners/jural.png', true) }}" alt="">
      </div>

    </div>
  </section>
  <!-- End Clients Section -->

  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact">

    <div class="container" data-aos="fade-up">

      <header class="section-header">
        <h2>Contact</h2>
        <p>Contact Us</p>
      </header>

      <div class="row gy-4">

        <div class="col-lg-6">

          <div class="row gy-4">
            <div class="col-md-6">
              <div class="info-box">
                <i class="bi bi-geo-alt"></i>
                <h3>Address</h3>
                <p>House - 744, Road -10, avenue -04, 2nd floor<br>Mirpur DOHS, Dhaka 1216.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-box">
                <i class="bi bi-telephone"></i>
                <h3>Call Us</h3>
                <p>+880 1907888839<br>+880 1907888899</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-box">
                <i class="bi bi-envelope"></i>
                <h3>Email Us</h3>
                <p>
                  <a href="mailto:hs@hypersystems.com.bd" class="__cf_email__">hs@hypersystems.com.bd</a>
                  <br>
                  <a href="mailto:hscare@hypersystems.com.bd" class="__cf_email__">hscare@hypersystems.com.bd</a>
                </p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-box">
                <i class="bi bi-clock"></i>
                <h3>Open Hours</h3>
                <p>Saturday - Thursday<br>10:00AM - 07:00PM</p>
              </div>
            </div>
          </div>

        </div>

        <div class="col-lg-6">
          <form action="{{ route('save-message') }}" method="post" class="php-email-form">
            {!! csrf_field() !!}
            <input type="hidden" name="type" value="message_lead">
            <div class="row gy-4">
              <div class="col-md-6">
                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
              </div>

              <div class="col-md-6 ">
                <input type="text" class="form-control" name="phone" placeholder="Your Phone Number" required>
              </div>

              <div class="col-md-12">
                <input type="email" class="form-control" name="email" placeholder="Email Address" required>
              </div>

              <div class="col-md-12">
                <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
              </div>

              <div class="col-md-12 text-center">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>

                <button type="submit">Send Message</button>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>

  </section><!-- End Contact Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">

  {{-- <div class="footer-newsletter">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12 text-center">
          <h4>Our Newsletter</h4>
          <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
        </div>
        <div class="col-lg-6">
          <form action="" method="post">
            <input type="email" name="email"><input type="submit" value="Subscribe">
          </form>
        </div>
      </div>
    </div>
  </div> --}}

  <div class="footer-top">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-12 footer-info">
          <a href="index.html" class="logo d-flex align-items-center">
            <img src="{{ asset('images/web_logo.png', true) }}" alt="">
            <span>myRADAR</span>
          </a>
          <p></p>
          <div class="social-links mt-3">
            <a href="https://www.facebook.com/myradartracker/" target="_blank" class="facebook"><i
                      class="bi bi-facebook"></i></a>
            {{-- <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram bx bxl-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin bx bxl-linkedin"></i></a> --}}
          </div>
        </div>

        <div class="col-lg-2 col-6 footer-links">
          {{-- <h4>Useful Links</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">About us</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Privacy policy</a></li>
          </ul> --}}
        </div>

        <div class="col-lg-2 col-6 footer-links">
          {{-- <h4>Our Services</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Web Design</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Web Development</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Product Management</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Marketing</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Graphic Design</a></li>
          </ul> --}}
        </div>

        <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
          <h4>Contact Us</h4>
          <p>
            House - 744, Road -10, avenue -04, 2nd floor<br>Mirpur DOHS, Dhaka 1216. <br>
            <strong>Phone:</strong> +880 1907888839<br>
            <strong>Email:</strong> <a href="href:hs@hypersystems.com.bd"
                                       class="__cf_email__">hs@hypersystems.com.bd</a><br>
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="copyright">
      {{-- &copy; Copyright <strong><span>FlexStart</span></strong>. All Rights Reserved --}}
    </div>
    <div class="credits">
    </div>
  </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center tw-z-[997]"><i
          class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{ asset('landing2/assets/vendor/aos/aos.js', true) }}"></script>
<script src="{{ asset('landing2/assets/vendor/php-email-form/validate.js', true) }}"></script>
<script src="{{ asset('landing2/assets/vendor/swiper/swiper-bundle.min.js', true) }}"></script>
<script src="{{ asset('landing2/assets/vendor/purecounter/purecounter.js', true) }}"></script>
<script src="{{ asset('landing2/assets/vendor/isotope-layout/isotope.pkgd.min.js', true) }}"></script>
<script src="{{ asset('landing2/assets/vendor/glightbox/js/glightbox.min.js', true) }}"></script>
<script src="{{ asset('landing2/assets/vendor/bootstrap/js/bootstrap.bundle.js', true) }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('landing2/assets/js/main.js', true) }}"></script>
</body>

</html>