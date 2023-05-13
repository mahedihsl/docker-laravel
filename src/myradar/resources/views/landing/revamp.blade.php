@php
$hasHttps= env('APP_ENV')=='production'
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-2QY67NRX6G"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-2QY67NRX6G');
  </script>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>myRADAR</title>
  <meta name="robots" content="noindex, nofollow">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="myRADAR vehicle tracker">
  <meta name="keywords" content="Radar, Car, Vehicle, Tracking">
  <meta name="author" content="HyperSystems">

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

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="{{ route('welcome') }}" class="logo d-flex align-items-center">
        <img src="{{ asset('images/web_logo.png', true) }}" alt="myRADAR logo">
        <span>myRADAR</span>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="@lang('misc.font') nav-link scrollto active" href="#hero">হোম</a></li>
          <li><a class="@lang('misc.font') nav-link scrollto" href="#features">ফিচার</a></li>
          <li><a class="@lang('misc.font') nav-link scrollto" href="#services">সেবাসমূহ</a></li>
          <li><a class="@lang('misc.font') nav-link scrollto" href="#mobile">মোবাইল অ্যাপ</a></li>
          <li><a class="@lang('misc.font') nav-link scrollto" href="#pricing">প্যাকেজ</a></li>
          <li><a class="@lang('misc.font') nav-link scrollto" href="{{ route('login', ['demo' => 'yes']) }}">ফ্রি ডেমো</a></li>
          <li>
            <a class="nav-link scrollto" href="#contact">
              <img src="{{ asset('images/phone-call.svg') }}" class="animate__animated animate__tada animate__infinite"
                alt="" style="width: 24px;" />
              <span class="@lang('misc.font')" style="margin-left: 12px;">+8801907888839</span>
            </a>
          </li>
          <li><a class="getstarted scrollto @lang('misc.font')" href="{{ route('login') }}">লগ ইন</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <div class="fab-links">
    <button class="bg-pink" data-bs-toggle="modal" data-bs-target="#phoneNumberModal">
      <i class="fas fa-phone-alt"></i>
    </button>
    <a class="bg-blue" href="#contact">
      <i class="fab fa-facebook-messenger"></i>
    </a>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="phoneNumberModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Call Us</h5>
        </div>
        <div class="modal-body">
          <p>+880 1907888839 <br>+880 1907888899</p>
        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div> --}}
      </div>
    </div>
  </div>

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center">

    <div class="row" style="width: 100%; --bs-gutter-x: 0;">
      <div class="col-lg-12" style="display: flex; flex-direction: column; align-items: center;">
        <img src="{{ asset('landing2/assets/image/banner.gif', $hasHttps) }}" class="img-fluid d-none d-lg-block" alt=""
          style="width: 100%;" />
        <img src="{{ asset('landing2/assets/image/live_tracking3.gif', true) }}" class="img-fluid d-lg-none" alt=""
          style="width: 100%;" />
        <h2 class="text-center @lang('misc.font')" style="font-weight: 800; color: #424242; font-size: 24px;">
          মাইরাডার অ্যাপ এর স্মার্ট ফিচারে, গাড়ি থাকুক নিরাপদে
        </h2>
        <p class="text-enter @lang('misc.font')" style="margin-top: 10px; font-size: 16px;">
          আপনার প্রিয় গাড়ির সুরক্ষায়, আস্থা ও বিশ্বাসের আরেক নাম মাইরাডার
        </p>
        <a href="#pricing" style="background: #4154f1;padding: 18px 30px; border-radius: 4px; color: #fff;"
          class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
          <span class="@lang('misc.font')">প্যাকেজ দেখুন</span>
          <i class="bi bi-arrow-right text-white"></i>
        </a>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">
    <!-- ======= Values Section ======= -->
    <section id="values" class="values">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Our Values</h2>
          <p class="@lang('misc.font')">স্মার্ট জিপিএস ট্র্যাকার</p>
        </header>

        <div class="row">

          <div class="col-lg-4">
            <div class="box" data-aos="fade-up" data-aos-delay="200">
              <img src="{{ asset('landing2/assets/image/live_tracking.png', true) }}" class="img-fluid" alt="">
              <h3 class="@lang('misc.font')">লাইভ ট্র্যাকিং</h3>
              <p class="@lang('misc.font')">লাইভ ট্র্যাকিং এর মাধ্যমে জানতে পারবেন গাড়ি এখন কোথায় আছে</p>
            </div>
          </div>

          <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="box" data-aos="fade-up" data-aos-delay="400">
              <img src="{{ asset('landing2/assets/image/lock_unlock.png', true) }}" class="img-fluid" alt="">
              <h3 class="@lang('misc.font')">ডিজিটাল ইঞ্জিন লক</h3>
              <p class="@lang('misc.font')">অ্যাপ এর মাধ্যমে দূরে থেকেও গাড়ি নিয়ন্ত্রণ করুন অনায়সে</p>
            </div>
          </div>

          <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="box" data-aos="fade-up" data-aos-delay="600">
              <img src="{{ asset('landing2/assets/image/cng_monitoring.png', true) }}" class="img-fluid" alt="">
              <h3 class="@lang('misc.font')">ফুয়েল ও সিএনজি মনিটরিং</h3>
              <p class="@lang('misc.font')">শুধুমাত্র আমরাই দিচ্ছি ফুয়েল এবং সিএনজি মনিটরিং সুবিধা</p>
            </div>
          </div>

        </div>

      </div>

    </section><!-- End Values Section -->

    <!-- ======= Counts Section ======= -->
    {{-- <section id="counts" class="counts">
      <div class="container" data-aos="fade-up">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6">
            <div class="count-box">
              <i class="bi bi-emoji-smile"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1"
                  class="purecounter"></span>
                <p>Happy Clients</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="count-box">
              <i class="bi bi-journal-richtext" style="color: #ee6c20;"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1"
                  class="purecounter"></span>
                <p>Projects</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="count-box">
              <i class="bi bi-headset" style="color: #15be56;"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="1463" data-purecounter-duration="1"
                  class="purecounter"></span>
                <p>Hours Of Support</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="count-box">
              <i class="bi bi-people" style="color: #bb0852;"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1"
                  class="purecounter"></span>
                <p>Hard Workers</p>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section> --}}
    <!-- End Counts Section -->

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Features</h2>
          <p class="@lang('misc.font')">আমাদের আকর্ষণীয় ফিচারসমূহ</p>
        </header>

        <div class="row">

          <div class="col-lg-6">
            <img src="{{ asset('landing2/assets/image/features.png', true) }}" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 mt-5 mt-lg-0 d-flex">
            <div class="row align-self-center gy-4">

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="200">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3 class="@lang('misc.font')">লাইভ ট্র্যাকিং</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="300">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3 class="@lang('misc.font')">৩ মাসের ট্রিপ হিস্ট্রি</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="300">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3 class="@lang('misc.font')">ইঞ্জিন লক/আনলক</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="400">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3 class="@lang('misc.font')">ফুয়েল মনিটরিং সিস্টেম</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="500">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3 class="@lang('misc.font')">সি এন জি মনিটরিং সিস্টেম</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="600">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3 class="@lang('misc.font')">ডেসটিনেশন এলার্ট</h3>
                </div>
              </div>

            </div>
          </div>

        </div> <!-- / row -->

        <!-- Feature Tabs 1 -->
        <div class="row feture-tabs" data-aos="fade-up">
          <div class="col-lg-6">
            <h3 class="@lang('misc.font')">আপনার প্রিয় গাড়ীটি রেখে দুরে এসেছেন!! ভয় নেই, পাহারায় আছে মাইরাডার</h3>

            <!-- Tabs -->
            <ul class="nav nav-pills mb-3">
              <li>
                <a class="nav-link active" data-bs-toggle="pill" href="#tab1"></a>
              </li>
            </ul>
            <!-- End Tabs -->

            <!-- Tab Content -->
            <div class="tab-content">

              <div class="tab-pane fade show active" id="tab1">
                {{-- <p>Consequuntur inventore voluptates consequatur aut vel et. Eos doloribus expedita. Sapiente atque
                  consequatur minima nihil quae aspernatur quo suscipit voluptatem.</p> --}}
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong></strong> কেউ দরজা খুললেই পেয়ে যাবেন "ডোর ওপেন এলার্ট"</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')">কত সময় যাবত গাড়ি পারকিং এ আছে তাও জানতে পারবেন।</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')">ইঞ্জিন অন হলেই পেয়ে যাবেন "ইঞ্জিন অন এলার্ট"</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong></strong> গাড়ির গতি, অবস্থান, দিক ইত্যাদি দেখা যাবে</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')">এক পলকে দেখে নিতে পারবেন গাড়ির ভ্রমন পথ</span>
                </div>
                <a href="#pricing"
                  style="background: #4154f1;padding: 8px 20px;margin-left: 30px;border-radius: 4px;color: #fff; margin-top: 30px;"
                  class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                  <span class="@lang('misc.font')">প্যাকেজ দেখুন</span>
                  <i class="bi bi-arrow-right text-white"></i>
                </a>
              </div>
              <!-- End Tab 1 Content -->

            </div>

          </div>

          <div class="col-lg-6">
            <img src="{{ asset('landing2/assets/image/car_safety.png', true) }}" class="img-fluid" alt="">
          </div>

        </div>
        <!-- End Feature Tabs -->

        <!-- Feature Tabs 2 -->
        <div class="row feture-tabs" data-aos="fade-up">
          <div class="col-lg-6">
            <img src="{{ asset('landing2/assets/image/live_tracking3.gif', true) }}" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6">
            <h3 class="@lang('misc.font')">গাড়ি কি আপনার চোখের আড়ালে !! নজরদারি করুন মাইরাডার লাইভ ট্র্যাকিং দিয়ে</h3>

            <!-- Tabs -->
            <ul class="nav nav-pills mb-3">
              <li>
                <a class="nav-link active" data-bs-toggle="pill" href="#tab1"></a>
              </li>
            </ul>
            <!-- End Tabs -->

            <!-- Tab Content -->
            <div class="tab-content">

              <div class="tab-pane fade show active" id="tab1">
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong>লাইভ ট্র্যাকিং ২৪ ঘণ্টা - </strong> গাড়ির গতি, অবস্থান, দিক ইত্যাদি দেখা
                    যাবে</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong>হিস্টরি মনিটরিং :</strong>গাড়ি কখন কোথায় আসা/যাওয়ার জন্য কোন রুট ব্যবহার
                    করছে তা এক
                    ক্লিকেই মুঠোফোনে দেখা যাবে। History ট্র্যাকিং রেকর্ড থাকবে ৩ মাস পর্যন্ত</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong>Traffic View: </strong> Google Traffic View (রাস্তায় যানজট) লাইভ আপডেট
                    থাকবে মাইরাডার
                    অ্যাপ এ</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong>ইঞ্জিন এলার্টঃ</strong> ইঞ্জিন অন/অফ নোটিফিকেশনের মাধ্যমে জানতে পারবেন
                    গাড়ি কতবার অন/অফ
                    করা হয়েছে</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong>ডিজিটাল ইঞ্জিন লকঃ</strong> মোবাইল অ্যাপ দিয়ে গাড়ির ইঞ্জিন লক/আনলক করা
                    যাবে
                    অনায়াসে</span>
                </div>
                <a href="#pricing"
                  style="background: #4154f1;padding: 8px 20px;margin-left: 30px;border-radius: 4px;color: #fff; margin-top: 30px;"
                  class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                  <span class="@lang('misc.font')">প্যাকেজ দেখুন</span>
                  <i class="bi bi-arrow-right text-white"></i>
                </a>
              </div>
              <!-- End Tab 1 Content -->

            </div>

          </div>

        </div>
        <!-- End Feature Tabs -->

        <!-- Feature Tabs 2 -->
        <div class="row feture-tabs" data-aos="fade-up">


          <div class="col-lg-6">
            <h3 class="@lang('misc.font')">গাড়ি চূরি নিয়ে চিন্তিত !! সুরক্ষায় আছি আমরা</h3>

            <!-- Tabs -->
            <ul class="nav nav-pills mb-3">
              <li>
                <a class="nav-link active" data-bs-toggle="pill" href="#tab1"></a>
              </li>
            </ul>
            <!-- End Tabs -->

            <!-- Tab Content -->
            <div class="tab-content">

              <div class="tab-pane fade show active" id="tab1">
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong>লক মোড:</strong> পারকিং করার পরে রাখুন লক মোডে, হবেনা ইঞ্জিন অন, কন্ট্রোল
                    আপনার
                    অ্যাপে</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong>ইঞ্জিন লক:</strong> myRadar অ্যাপ এর মাধ্যমে গাড়ি চুরি হওয়ার সাথে সাথে
                    ইঞ্জিন অফ
                    করে দিতে পারবেন</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong>জিইও ফেন্স নোটিফিকেশনঃ</strong> নির্ধারিত এলাকার বাহিরে বা ভিতরে প্রবেশ
                    করলে এলার্ট
                    পেয়ে যাবেন সাথে সাথেই ।</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong>ইমারজেন্সি বাটনঃ</strong> হাইজ্যাক হলে ড্রাইভার চাপবে বাটন, চলে আসবে
                    ইমারজেঞ্ছি
                    এলার্ট</span>
                </div>
                <a href="#pricing"
                  style="background: #4154f1;padding: 8px 20px;margin-left: 30px;border-radius: 4px;color: #fff; margin-top: 30px;"
                  class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                  <span class="@lang('misc.font')">প্যাকেজ দেখুন</span>
                  <i class="bi bi-arrow-right text-white"></i>
                </a>
              </div>
              <!-- End Tab 1 Content -->

            </div>

          </div>

          <div class="col-lg-6">
            <img src="{{ asset('landing2/assets/image/theft_protection.png', true) }}" class="img-fluid" alt="">
          </div>

        </div>
        <!-- End Feature Tabs -->

        <!-- Feature Tabs 3 -->
        <div class="row feture-tabs" data-aos="fade-up">
          <div class="col-lg-6">
            <img src="{{ asset('landing2/assets/image/cng_monitoring2.png', true) }}" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6">
            <h3 class="@lang('misc.font')">ফুয়েল, সিএনজি এবং অন্যান্য হিসাব রাখতে হিমসিম খাচ্ছেন!! নো টেনশন</h3>

            <!-- Tabs -->
            <ul class="nav nav-pills mb-3">
              <li>
                <a class="nav-link active" data-bs-toggle="pill" href="#tab1"></a>
              </li>
            </ul>
            <!-- End Tabs -->

            <!-- Tab Content -->
            <div class="tab-content">

              <div class="tab-pane fade show active" id="tab1">
                {{-- <p>Consequuntur inventore voluptates consequatur aut vel et. Eos doloribus expedita. Sapiente atque
                  consequatur minima nihil quae aspernatur quo suscipit voluptatem.</p> --}}
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong>মাইলেজ রিপোর্টঃ</strong> মাইলেজ রিপোর্ট দেখে সহজেই পরিমাপ করতে
                    পারবেন ফুয়েলের হিসাব।</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong>সি এন জি মনিটরিংঃ</strong> গাড়ির CNG মিটার myRADAR মোবাইল অ্যাপ-এ দেখতে
                    পাবেন এবং গাড়িতে
                    CNG নেওয়ার সাথে সাথেই ফোনে নোটিফিকেশন পাবেন।</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong>ফুয়েল মনিটরিংঃ </strong>গাড়ির ফুয়েল মিটার দেখতে পাবেন মোবাইল App -
                    এ</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')">ফুয়েল রিফিল এবং লীকেজ এলার্ট (শিগ্রই আসছে)</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong>ডেইলি সামারি:</strong> কতবার ইঞ্জিন অন/অফ করা হয়েছে, কতটুকু সময় চলেছে,
                    কত দুরুত্ত
                    অতিক্রম করেছে নোটিফিকেশন এবং SMS-এর মাধ্যমে জানিয়ে দেয়া হবে</span>
                </div>
                <a href="#pricing"
                  style="background: #4154f1;padding: 8px 20px;margin-left: 30px;border-radius: 4px;color: #fff; margin-top: 30px;"
                  class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                  <span class="@lang('misc.font')">প্যাকেজ দেখুন</span>
                  <i class="bi bi-arrow-right text-white"></i>
                </a>
              </div>
              <!-- End Tab 1 Content -->

            </div>

          </div>



        </div>
        <!-- End Feature Tabs -->

        <!-- Feature Tabs 4 -->
        <div class="row feture-tabs" data-aos="fade-up">


          <div class="col-lg-6">
            <h3 class="@lang('misc.font')">নির্দিষ্ট এলাকার বাইরে গাড়ির যাতায়াত মনিটর করতে চান!! সমাধানে মাইরাডার</h3>

            <!-- Tabs -->
            <ul class="nav nav-pills mb-3">
              <li>
                <a class="nav-link active" data-bs-toggle="pill" href="#tab1"></a>
              </li>
            </ul>
            <!-- End Tabs -->

            <!-- Tab Content -->
            <div class="tab-content">

              <div class="tab-pane fade show active" id="tab1">
                {{-- <p>Consequuntur inventore voluptates consequatur aut vel et. Eos doloribus expedita. Sapiente atque
                  consequatur minima nihil quae aspernatur quo suscipit voluptatem.</p> --}}
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong>ডেসটিনেশন এলার্ট:</strong> নির্ধারিত এলাকার বাহিরে গেলে এলার্ট।</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong>এরাইভাল এলার্ট:</strong> নির্ধারিত এলাকার ভিতরে প্রবেশ করলে
                    এলার্ট।</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')">সকল গুরুত্বপূর্ণ শহরে প্রবেশ এবং প্রস্থান এর সময় নোটিফিকেশান পাবেন অটোমেটিক্যালি
                    ।</span>
                </div>
                <a href="#pricing"
                  style="background: #4154f1;padding: 8px 20px;margin-left: 30px;border-radius: 4px;color: #fff; margin-top: 30px;"
                  class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                  <span class="@lang('misc.font')">প্যাকেজ দেখুন</span>
                  <i class="bi bi-arrow-right text-white"></i>
                </a>
              </div>
              <!-- End Tab 1 Content -->

            </div>

          </div>

          <div class="col-lg-6">
            <img src="{{ asset('landing2/assets/image/live_tracking2.png', true) }}" class="img-fluid" alt="">
          </div>

        </div>
        <!-- End Feature Tabs -->

        <!-- Feature Tabs 5 -->
        <div class="row feture-tabs" data-aos="fade-up">
          <div class="col-lg-6">
            <img src="{{ asset('landing2/assets/image/family_safety.png', true) }}" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6">
            <h3 class="@lang('misc.font')">আপনজনদের সুরক্ষায় myRadar</h3>

            <!-- Tabs -->
            <ul class="nav nav-pills mb-3">
              <li>
                <a class="nav-link active" data-bs-toggle="pill" href="#tab1"></a>
              </li>
            </ul>
            <!-- End Tabs -->

            <!-- Tab Content -->
            <div class="tab-content">

              <div class="tab-pane fade show active" id="tab1">
                {{-- <p>Consequuntur inventore voluptates consequatur aut vel et. Eos doloribus expedita. Sapiente atque
                  consequatur minima nihil quae aspernatur quo suscipit voluptatem.</p> --}}
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong></strong> অতিরিক্ত গতিতে গাড়ি চললেই এলার্ট পাবেন সাথে সাথে</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')"><strong></strong> বাচ্চা নির্ধারিত সময়ে স্কুলে পৌঁছেছে কিনা, তা মোবাইল অ্যাপ - এ
                    জানতে
                    পারবেন</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span class="@lang('misc.font')">আপনার সেট করে দেয়া গন্তব্যে আপনজন পৌঁছা মাত্র জানিয়ে দেবে myRadar</span>
                </div>

                <a href="#pricing"
                  style="background: #4154f1;padding: 8px 20px;margin-left: 30px;border-radius: 4px;color: #fff; margin-top: 30px;"
                  class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                  <span class="@lang('misc.font')">প্যাকেজ দেখুন</span>
                  <i class="bi bi-arrow-right text-white"></i>
                </a>
              </div>
              <!-- End Tab 1 Content -->

            </div>

          </div>



        </div>
        <!-- End Feature Tabs -->

      </div>

    </section><!-- End Features Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Services</h2>
          <p class="@lang('misc.font')">মাইরাডারের সেবাসমূহ</p>
        </header>

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-box blue">
              <i class="ri-discuss-line icon"></i>
              <h3 class="@lang('misc.font')">লাইভ ট্র্যাকিং</h3>
              <ul class="@lang('misc.font')" style="text-align: left;">
                <li>LIVE ট্র্যাকিং ২৪ ঘণ্টা - গাড়ির গতি, অবস্থান, দিক</li>
                <li>History ট্র্যাকিং রেকর্ড ৩ মাস অবধি</li>
                <li>SPEED ভায়োলেশন এলার্ট</li>
                <li>ইঞ্জিন ON/OFF নোটিফিকেশন</li>
                <li>মোবাইল অ্যাপ দিয়ে গাড়ি ON/OFF নিয়ন্ত্রণ করা</li>
                <li>জানতে পারবেন প্রতিদিন কতবার ইঞ্জিন অন করা হয়েছে</li>
              </ul>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-box orange">
              <i class="ri-discuss-line icon"></i>
              <h3 class="@lang('misc.font')">মাইলেজ রিপোর্ট</h3>
              <ul class="@lang('misc.font')" style="text-align: left;">
                <li>প্রতিদিন কত কিলোমিটার ভ্রমণ করেছেন এক পলকেই জানতে পারবেন মাইলেজ রিপোর্ট দেখে</li>
                <li>বিগত দিনের মাইলেজ রিপোর্ট দেখতে পাবেন খুব সহজে</li>
                <li>অস্বাভাবিক মাইলেজ নোটিফিকেশন</li>
              </ul>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="service-box green">
              <i class="ri-discuss-line icon"></i>
              <h3 class="@lang('misc.font')">Special CNG প্যাকেজ</h3>
              <ul class="@lang('misc.font')" style="text-align: left;">
                <li>শুধু আমরা দিচ্ছি আপনার গাড়ির CNG মিটার মনিটর সুবিধা</li>
                <li>গাড়ির CNG মিটার myRADAR মোবাইল অ্যাপ-এ মনিটর করা</li>
                <li>গাড়িতে CNG নেওয়ার পরে অ্যাপ-এ Money receipt পাবেন</li>
                <li>গাড়িতে CNG Refill করার পুরাতন রেকর্ড পাবেন অ্যাপ আর মাধ্যমে</li>
              </ul>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="service-box red">
              <i class="ri-discuss-line icon"></i>
              <h3 class="@lang('misc.font')">ডেসটিনেশন এলার্ট</h3>
              <ul class="@lang('misc.font')" style="text-align: left;">
                <li>গন্তব্যে পৌছার নোটিফিকেশন : School, Home, Office ইত্যাদি</li>
                <li>নির্ধারিত এলাকার বাহিরে বা ভিতরে প্রবেশ করলে এলার্ট</li>
                <li>নিজের ইচ্ছেমত এলাকা জিও ফেন্স হিসেবে নির্ধারণ করুন</li>
                <li>জিও ফেন্স - আনলিমিটেড</li>
              </ul>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
            <div class="service-box purple">
              <i class="ri-discuss-line icon"></i>
              <h3 class="@lang('misc.font')">Corporate গ্রাহকদের জন্য সুবিধা সমূহ</h3>
              <ul class="@lang('misc.font')" style="text-align: left;">
                <li>Fleet Management Software মাধ্যমে সব গাড়ি নিয়ন্ত্রণের সুবিধা</li>
                <li>সকল গাড়ীর ড্রাইভিং সময়কাল রিপোর্ট</li>
                <li>ড্রাইভারদের ডিউটি সময়কাল রিপোর্ট</li>
                <li>জোনের মাধ্যমে একই সময়ে একাধিক গাড়ী মনিটর করুন</li>
                <li>সহজেই ম্যানেজ করুন ড্রাইভারদের শিডিউল</li>
              </ul>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="700">
            <div class="service-box pink">
              <i class="ri-discuss-line icon"></i>
              <h3 class="@lang('misc.font')">অন্যান্য সুবিধা সমূহ</h3>
              <ul class="@lang('misc.font')" style="text-align: left;">
                <li>Android, iPhone এবং ব্রাউজার ব্যবহার করে গাড়ি ট্র্যাকিং সুবিধা</li>
                <li>এক আইডি থেকে সব গাড়ি নিয়ন্ত্রণের সুবিধা</li>
                <li>আপনার বাড়ি, অফিস সর্বত্র আমাদের ইঞ্জিনিয়ার দ্বারা FREE Install</li>
                <li>আমাদের প্রতি ডিভাইসে থাকছে ২ বছরের রিপ্লেসমেন্ট গ্যারান্টি</li>
                <li>গাড়ির TAX, Insurance, Fitness date নোটিফিকেশন</li>
                <li>২৪ ঘন্টা কাস্টমার কেয়ার সুবিধা</li>
              </ul>
            </div>
          </div>

        </div>

      </div>

    </section><!-- End Services Section -->

    <section id="mobile" class="features">
      <div class="container" data-aos="fade-up">
        <!-- Feature Icons -->
        <div class="row feature-icons" data-aos="fade-up">
          <h3 class="@lang('misc.font')">মোবাইল অ্যাপ</h3>

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

        <div class="row">
          <div class="col-xs-12 d-flex flex-column flex-md-row justify-content-center align-items-center">
            <a target="_blank" href="https://apps.apple.com/jm/app/bangla-radar/id1526805734"
              title="Download from App Store" class="btn-appstore">App Store</a>
            <a target="_blank" href="https://play.google.com/store/apps/details?id=com.mobile.hs.hyperware"
              title="Download from Play Store" class="btn-playstore">Play Store</a>
          </div>

        </div>
        <!-- End Feature Icons -->
      </div>
    </section>

    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Pricing</h2>
          <p class="@lang('misc.font')">আমাদের প্যাকেজ সমূহ</p>
        </header>

        <div class="row gy-4" data-aos="fade-left">

          <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
            <div class="box">
              <h3 class="price-standard">Standard <div class="arrow"></div>
              </h3>
              <div class="price @lang('misc.font')"><sup></sup>৬,০০০<span> টাকা</span></div>
              <div class="price2 @lang('misc.font')"><span>মাসিক চার্জ </span>৪০০<span> টাকা</span></div>
              {{-- <img src="{{ asset('landing2/assets/img/pricing-free.png', true) }}" class="img-fluid" alt=""> --}}
              <ul class="@lang('misc.font')">
                <li>লাইভ ট্র্যাকিং</li>
                <li>ট্রাভেল হিস্টোরি</li>
                <li>ইঞ্জিন লক/আনলক</li>
                <li>ইঞ্জিন অন/অফ এলার্ট</li>
                <li class="na">লাইভ সি এন জি মিটার</li>
                <li class="na">সি এন জি রিফিল এলার্ট</li>
                <li>জিইও ফেন্স</li>
                <li>কাস্টমাইজড জিইও ফেন্স</li>
                <li>স্পিড ভায়োলেশন এলার্ট</li>
                <li>ডেসটিনেশন এলার্ট</li>
                <li class="na">এসি অন/অফ নোটিফিকেশন</li>
                <li class="na">প্যানিক বাটন</li>
                <li>ডেইলি সামারি এসএমএস</li>
                <li class="na">ফুয়েল মনিটরিং সিস্টেম</li>
                <li class="na">ডোর লক নোটিফিকশন</li>
                <li>৩ মাস পর্যন্ত ট্র্যাকিং হিস্ট্রি</li>
                <li>২৪ মাসের ওয়ারেন্টি</li>
                <li>২৪x৭ হেল্পলাইন সুবিধা</li>
              </ul>
              <a href="#contact" class="btn-buy">Buy Now</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
            <div class="box">
              {{-- <span class="featured">Featured</span> --}}
              <h3 class="price-special">Special <div class="arrow"></div>
              </h3>
              <div class="price @lang('misc.font')"><sup></sup>৮,০০০<span> টাকা</span></div>
              <div class="price2 @lang('misc.font')"><span>মাসিক চার্জ </span>৫০০<span> টাকা</span></div>
              {{-- <img src="{{ asset('landing2/assets/img/pricing-starter.png', true) }}" class="img-fluid" alt="">
              --}}
              <ul class="@lang('misc.font')">
                <li>লাইভ ট্র্যাকিং</li>
                <li>ট্রাভেল হিস্টোরি</li>
                <li>ইঞ্জিন লক/আনলক</li>
                <li>ইঞ্জিন অন/অফ এলার্ট</li>
                <li>লাইভ সি এন জি মিটার</li>
                <li>সি এন জি রিফিল এলার্ট</li>
                <li>জিইও ফেন্স</li>
                <li>কাস্টমাইজড জিইও ফেন্স</li>
                <li>স্পিড ভায়োলেশন এলার্ট</li>
                <li>ডেসটিনেশন এলার্ট</li>
                <li class="na">এসি অন/অফ নোটিফিকেশন</li>
                <li class="na">প্যানিক বাটন</li>
                <li>ডেইলি সামারি এসএমএস</li>
                <li>ফুয়েল মনিটরিং সিস্টেম</li>
                <li class="na">ডোর লক নোটিফিকশন</li>
                <li>৩ মাস পর্যন্ত ট্র্যাকিং হিস্ট্রি</li>
                <li>২৪ মাসের ওয়ারেন্টি</li>
                <li>২৪x৭ হেল্পলাইন সুবিধা</li>
              </ul>
              <a href="#contact" class="btn-buy">Buy Now</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
            <div class="box">
              <h3 class="price-advanced">Advanced <div class="arrow"></div>
              </h3>
              <div class="price @lang('misc.font')"><sup></sup>১৫,০০০<span> টাকা</span></div>
              <div class="price2 @lang('misc.font')"><span>মাসিক চার্জ </span>৮০০<span> টাকা</span></div>
              {{-- <img src="{{ asset('landing2/assets/img/pricing-business.png', true) }}" class="img-fluid" alt="">
              --}}
              <ul class="@lang('misc.font')">
                <li>লাইভ ট্র্যাকিং</li>
                <li>ট্রাভেল হিস্টোরি</li>
                <li>ইঞ্জিন লক/আনলক</li>
                <li>ইঞ্জিন অন/অফ এলার্ট</li>
                <li>লাইভ সি এন জি মিটার</li>
                <li>সি এন জি রিফিল এলার্ট</li>
                <li>জিইও ফেন্স</li>
                <li>কাস্টমাইজড জিইও ফেন্স</li>
                <li>স্পিড ভায়োলেশন এলার্ট</li>
                <li>ডেসটিনেশন এলার্ট</li>
                <li>এসি অন/অফ নোটিফিকেশন</li>
                <li>প্যানিক বাটন</li>
                <li>ডেইলি সামারি এসএমএস</li>
                <li>ফুয়েল মনিটরিং সিস্টেম</li>
                <li>ডোর লক নোটিফিকশন</li>
                <li>৩ মাস পর্যন্ত ট্র্যাকিং হিস্ট্রি</li>
                <li>২৪ মাসের ওয়ারেন্টি</li>
                <li>২৪x৭ হেল্পলাইন সুবিধা</li>
              </ul>
              <a href="#contact" class="btn-buy">Buy Now</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="400">
            <div class="box">
              <h3 class="price-business">Business <div class="arrow"></div>
              </h3>
              <div class="price @lang('misc.font')"><sup></sup>Custom<span></span></div>
              <div class="price2 @lang('misc.font')">&nbsp;</div>
              {{-- <img src="{{ asset('landing2/assets/img/pricing-ultimate.png', true) }}" class="img-fluid" alt="">
              --}}
              <ul class="@lang('misc.font')">
                <li>লাইভ ট্র্যাকিং</li>
                <li>ট্রাভেল হিস্টোরি</li>
                <li>ইঞ্জিন লক/আনলক</li>
                <li>ইঞ্জিন অন/অফ এলার্ট</li>
                <li>লাইভ সি এন জি মিটার</li>
                <li>সি এন জি রিফিল এলার্ট</li>
                <li>জিইও ফেন্স</li>
                <li>কাস্টমাইজড জিইও ফেন্স</li>
                <li>স্পিড ভায়োলেশন এলার্ট</li>
                <li>ডেসটিনেশন এলার্ট</li>
                <li>এসি অন/অফ নোটিফিকেশন</li>
                <li>প্যানিক বাটন</li>
                <li>ডেইলি সামারি এসএমএস</li>
                <li>ফুয়েল মনিটরিং সিস্টেম</li>
                <li>ডোর লক নোটিফিকশন</li>
                <li>৩ মাস পর্যন্ত ট্র্যাকিং হিস্ট্রি</li>
                <li>২৪ মাসের ওয়ারেন্টি</li>
                <li>২৪x৭ হেল্পলাইন সুবিধা</li>
              </ul>
              <a href="#contact" class="btn-buy">Buy Now</a>
            </div>
          </div>
        </div>
      </div>

    </section><!-- End Pricing Section -->

    <!-- ======= F.A.Q Section ======= -->
    <section id="faq" class="faq">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>F.A.Q</h2>
          <p class="@lang('misc.font')">মাইরাডার সম্পর্কিত জিজ্ঞাসা</p>
        </header>

        <div class="row">
          <div class="col-lg-6">
            <!-- F.A.Q List 1-->
            <div class="accordion accordion-flush @lang('misc.font')" id="faqlist1">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed font-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq-content-1">
                    কিভাবে আমার পাসওয়ার্ড উদ্ধার করবো ?
                  </button>
                </h2>
                <div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                  <div class="accordion-body">
                    লগ ইন পৃষ্ঠায় পাসওয়ার্ড ভুলে গেছেন? চাপুন >> নিজের পুনরুদ্ধারের বিকল্পগুলি ই-মেইলের মাধ্যমে বা
                    স্ব-পুনরুদ্ধারের জন্য এসএমএস নির্বাচন করুন >> এগিয়ে যান >> পিন কোডটি লিখুন >> আপনার পাসওয়ার্ড
                    পরিবর্তন করুন
                    আপনি আমাদের কল সেন্টার থেকে সহায়তা নিতে পারেন তারা আপনাকে সহায়তা করতে পেরে খুশি হবে।
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed font-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq-content-2">
                    আমি কি আমার গাড়ী দূরবর্তীভাবে লক করতে পারব ?
                  </button>
                </h2>
                <div id="faq-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                  <div class="accordion-body">
                    হ্যাঁ। আপনি যে কোনো সময় থেকে যে কোন জায়গা থেকে করতে পারেন। এমনকি আপনার গাড়ী বন্ধ থাকা অবস্থায় ও
                    হয়।
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed font-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq-content-3">
                    চলমান মোডে আমার গাড়ী লক করা কি নিরাপদ ?
                  </button>
                </h2>
                <div id="faq-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                  <div class="accordion-body">
                    হ্যাঁ। এটা নিরাপদ. ইঞ্জিন বন্ধ করার সময় এটিতে স্বয়ংক্রিয় নিরাপদ গতি পরীক্ষা এবং বুদ্ধিমত্তা
                    রয়েছে
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed font-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq-content-4">
                    আমি কি অ্যাপ দিয়ে গাড়ী চালু করতে পারব ?
                  </button>
                </h2>
                <div id="faq-content-4" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                  <div class="accordion-body">
                    না, আপনি করতে পারেন না। অ্যাপ থেকে চালু হওয়ার পরে আপনাকে একটি ডবল নিরাপত্তা বিকল্প দেওয়ার জন্য
                    গাড়ী থেকে চালু করতে হবে।
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed font-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq-content-5">
                    আমার গাড়ি চালু হচ্ছে না। কি করব ?
                  </button>
                </h2>
                <div id="faq-content-5" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                  <div class="accordion-body">
                    আপনার অ্যাপ্লিকেশন চেক করুন। আনলক মোডে আপনার গাড়ী নিশ্চিত করুন। আরো তথ্যের জন্য কল সেন্টার থেকে
                    সমর্থন নিন।
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed font-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq-content-6">
                    আমি কি পুশ নোটিফিকেশান বন্ধ করতে পারব ?
                  </button>
                </h2>
                <div id="faq-content-6" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                  <div class="accordion-body">
                    হ্যাঁ। আপনি করতে পারেন। অ্যাকাউন্ট >> সেটিংস >> নোটিফিকেশান বন্ধ করুন।
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed font-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq-content-7">
                    কেন আমার ট্র্যাকার কাজ করছে না ?
                  </button>
                </h2>
                <div id="faq-content-7" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                  <div class="accordion-body">
                    আপনার ইন্টারনেট ডাটা চেক করুন >> যদি ঠিক থাকে তবে আপনার বিল তথ্য পরীক্ষা করুন। >> অন্যথাই আমাদের কল
                    সেন্টারে কল করুন ।
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="col-lg-6">

            <!-- F.A.Q List 2-->
            <div class="accordion accordion-flush @lang('misc.font')" id="faqlist2">

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed font-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq2-content-8">
                    বিল পরিশোধ করবো কিভাবে ?
                  </button>
                </h2>
                <div id="faq2-content-8" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                  <div class="accordion-body">
                    বিকাশ, রকেট, ক্রেডিট কার্ড, ময়দদার ব্যাংক অ্যাকাউন্টের মাধ্যমে।
                    বিশেষ ক্ষেত্রে আমরা আমাদের কর্মকর্তাকে নগদ সংগ্রহ করতে পাঠাই।
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed font-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq2-content-9">
                    আমার জ্বালানী / গ্যাস মিটার সঠিক নয়। কি করবো ?
                  </button>
                </h2>
                <div id="faq2-content-9" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                  <div class="accordion-body">
                    আমাদের ওয়েবসাইটে লগইন করুন (http://www.myradar.com.bd/)...>> ফিক্সিং / গ্যাস মিটার >> সরবরাহ ইনপুট
                    রিফিল / রিজার্ভ। অথবা
                    প্রথমে সার্ভিস এ যান >> তেল >>ফিক্স ফুয়েল মিটার>>বর্তমান ফুয়েলের পরিমাণ প্রদান করুন।
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed font-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq2-content-10">
                    কিভাবে সঠিক গ্যাসের পরিমাণ মূল্য পেতে পারব ?
                  </button>
                </h2>
                <div id="faq2-content-10" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                  <div class="accordion-body">
                    সঠিক গ্যাসের পরিমাণের মূল্য পাওয়ার জন্য আপনাকে আমাদের কয়েকটি গ্যাস ইভেন্টের জন্য ব্যয় করা
                    পরিমাণটি দিতে হবে।
                    প্রথমে সার্ভিস এ যান >>গ্যাস >>গ্যাস হিস্ট্রি>>Give amount
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed font-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq2-content-11">
                    আমি কি দ্রুত সতর্কতা পেতে পারি ?
                  </button>
                </h2>
                <div id="faq2-content-11" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                  <div class="accordion-body">
                    হ্যাঁ, আপনার গাড়ীর গতি 60 বা 80 কিলোমিটারের বেশি হলে আপনি গতির বিজ্ঞপ্তি পাবেন।
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed font-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq2-content-12">
                    আমি কি অ্যাপের মাধ্যমে একাধিক গাড়ী ট্র্যাক করতে পারব ?
                  </button>
                </h2>
                <div id="faq2-content-12" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                  <div class="accordion-body">
                    হ্যাঁ, আপনি পারবেন, (যদি আপনার মাল্টি গাড়ি থাকে)। লগইন করার পরে আপনি গাড়ী নির্বাচন জন্য সতর্কতা
                    পাবেন। পাশাপাশি উপরের ডানদিকের গাড়ির আইকন ক্লিক করে আপনার গাড়িটি চয়ন করতে পারেন
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed font-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq2-content-13">
                    আমি কি অ্যাপের মাধ্যমে মাইলেজ তথ্য পেতে ?
                  </button>
                </h2>
                <div id="faq2-content-13" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                  <div class="accordion-body">
                    হ্যাঁ, আপনি পারেন। সার্ভিস এ যান >> মাইলেজ।
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>

      </div>

    </section><!-- End F.A.Q Section -->

    <!-- ======= Clients Section ======= -->
    <section id="clients" class="clients">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2></h2>
          <p class="@lang('misc.font')">কর্পোরেট পার্টনার</p>
        </header>

        <div class="clients-wrapper">
          <img src="{{ asset('images/partners/banglalink.png', true) }}" alt="">
          <img src="{{ asset('images/partners/robi.png', true) }}" alt="" style="margin: 0 50px;">
          <img src="{{ asset('images/partners/jural.png', true) }}" alt="">
        </div>

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
            <form action="{{route('save-message')}}" method="post" class="php-email-form">
              {!! csrf_field() !!}
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
              House - 744, Road -10, avenue -04, 2nd floor<br>Mirpur DOHS, Dhaka 1216.
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
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/flexstart-bootstrap-startup-template/ -->
        {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  {{-- <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script> --}}
  <script src="{{ asset('landing2/assets/vendor/aos/aos.js', true) }}"></script>
  <script src="{{ asset('landing2/assets/vendor/php-email-form/validate.js', true) }}"></script>
  <script src="{{ asset('landing2/assets/vendor/swiper/swiper-bundle.min.js', true) }}"></script>
  <script src="{{ asset('landing2/assets/vendor/purecounter/purecounter.js', true) }}"></script>
  <script src="{{ asset('landing2/assets/vendor/isotope-layout/isotope.pkgd.min.js', true) }}"></script>
  <script src="{{ asset('landing2/assets/vendor/glightbox/js/glightbox.min.js', true) }}"></script>
  <script src="{{ asset('landing2/assets/vendor/bootstrap/js/bootstrap.bundle.js', true) }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('landing2/assets/js/main.js', true) }}"></script>

  {{-- <script>if( window.self == window.top ) { (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-55234356-4', 'auto'); ga('send', 'pageview'); } </script> --}}
</body>

</html>
