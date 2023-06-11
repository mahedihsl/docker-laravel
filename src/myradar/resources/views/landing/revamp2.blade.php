<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>FlexStart Bootstrap Template - Index</title>
  <meta name="robots" content="noindex, nofollow">
  <meta content="" name="description">

  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('landing2/assets/img/favicon.png', $hasHttps) }}" rel="icon">
  <link href="{{ asset('landing2/assets/img/apple-touch-icon.png', $hasHttps) }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('landing2/assets/vendor/bootstrap/css/bootstrap.min.css', $hasHttps) }}" rel="stylesheet">
  <link href="{{ asset('landing2/assets/vendor/bootstrap-icons/bootstrap-icons.css', $hasHttps) }}" rel="stylesheet">
  <link href="{{ asset('landing2/assets/vendor/aos/aos.css', $hasHttps) }}" rel="stylesheet">
  <link href="{{ asset('landing2/assets/vendor/remixicon/remixicon.css', $hasHttps) }}" rel="stylesheet">
  <link href="{{ asset('landing2/assets/vendor/swiper/swiper-bundle.min.css', $hasHttps) }}" rel="stylesheet">
  <link href="{{ asset('landing2/assets/vendor/glightbox/css/glightbox.min.css', $hasHttps) }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('landing2/assets/css/style.css', $hasHttps) }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: FlexStart - v1.1.1
  * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <img src="{{ asset('landing2/assets/img/logo.png', $hasHttps) }}" alt="">
        <span>FlexStart</span>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#services">Services</a></li>
          <li><a class="nav-link scrollto" href="#portfolio">Portfolio</a></li>
          <li><a class="nav-link scrollto" href="#team">Team</a></li>
          <li><a href="blog.html">Blog</a></li>
          <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
          <li><a class="getstarted scrollto" href="#about">Get Started</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center">

    <div class="" style="padding: 0; margin-top: 40px;">
      <div class="row">
        {{-- <div class="col-lg-6 d-flex flex-column justify-content-center">
          <h1 data-aos="fade-up">Product TAG line will be here</h1>
          <h2 data-aos="fade-up" data-aos-delay="400">This line will describe the main product features</h2>
          <div data-aos="fade-up" data-aos-delay="600">
            <div class="text-center text-lg-start">
              <a href="#about"
                class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                <span>অর্ডার করুন</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div> --}}
        {{-- <div class="col-lg-12">
          <img src="{{ asset('cars.gif', $hasHttps) }}" class="img-fluid" alt=""/>
        </div> --}}
        <div class="col-lg-12 hero-img" data-aos="zoom-out" data-aos-delay="200" style="margin-top: 100px;">
          {{-- <img src="{{ asset('landing2/assets/img/banner.jpg', $hasHttps) }}" class="img-fluid" alt=""> --}}
          <img src="{{ asset('cars.gif', $hasHttps) }}" class="img-fluid" alt="" />
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">
    <!-- ======= About Section ======= -->
    {{-- <section id="about" class="about">

      <div class="container" data-aos="fade-up">
        <div class="row gx-0">

          <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <div class="content">
              <h3>Who We Are</h3>
              <h2>Expedita voluptas omnis cupiditate totam eveniet nobis sint iste. Dolores est repellat corrupti
                reprehenderit.</h2>
              <p>
                Quisquam vel ut sint cum eos hic dolores aperiam. Sed deserunt et. Inventore et et dolor consequatur
                itaque ut voluptate sed et. Magnam nam ipsum tenetur suscipit voluptatum nam et est corrupti.
              </p>
              <div class="text-center text-lg-start">
                <a href="#"
                  class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                  <span>Read More</span>
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
            <img src="{{ asset('landing2/assets/img/about.jpg') }}" class="img-fluid" alt="">
    </div>

    </div>
    </div>

    </section> --}}
    <!-- End About Section -->

    <!-- ======= Values Section ======= -->
    <section id="values" class="values">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Our Values</h2>
          <p>স্মার্ট জিপিএস ট্র্যাকার</p>
        </header>

        <div class="row">

          <div class="col-lg-4">
            <div class="box" data-aos="fade-up" data-aos-delay="200">
              <img src="{{ asset('landing2/assets/image/live_tracking.png', $hasHttps) }}" class="img-fluid" alt="">
              <h3>লাইভ ট্র্যাকিং</h3>
              <p>লাইভ ট্র্যাকিং এর মাধ্যমে জানতে পারবেন গাড়ি এখন কোথায় আছে</p>
            </div>
          </div>

          <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="box" data-aos="fade-up" data-aos-delay="400">
              <img src="{{ asset('landing2/assets/image/lock_unlock.png', $hasHttps) }}" class="img-fluid" alt="">
              <h3>ইঞ্জিন লক/আনলক</h3>
              <p>অ্যাপ এর মাধ্যমে দূরে থেকেও গাড়ি নিয়ন্ত্রণ করুন অনায়সে</p>
            </div>
          </div>

          <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="box" data-aos="fade-up" data-aos-delay="600">
              <img src="{{ asset('landing2/assets/image/cng_monitoring.png', $hasHttps) }}" class="img-fluid" alt="">
              <h3>সি এন জি মনিটরিং</h3>
              <p>শুধুমাত্র আমরাই দিচ্ছি সি এন জি মনিটরিং সুবিধা</p>
            </div>
          </div>

        </div>

      </div>

    </section><!-- End Values Section -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
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
    </section><!-- End Counts Section -->

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Features</h2>
          <p>আমাদের আকর্ষণীয় ফিচারসমূহ</p>
        </header>

        <div class="row">

          <div class="col-lg-6">
            <img src="{{ asset('landing2/assets/image/features.png', $hasHttps) }}" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 mt-5 mt-lg-0 d-flex">
            <div class="row align-self-center gy-4">

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="200">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>লাইভ ট্র্যাকিং</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="300">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>৩ মাসের ট্রিপ হিস্ট্রি</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="300">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>ইঞ্জিন লক/আনলক</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="400">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>ফুয়েল মনিটরিং সিস্টেম</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="500">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>সি এন জি মনিটরিং সিস্টেম</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="600">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>ডেসটিনেশন এলার্ট</h3>
                </div>
              </div>

            </div>
          </div>

        </div> <!-- / row -->

        <!-- Feature Tabs 1 -->
        <div class="row feture-tabs" data-aos="fade-up">
          <div class="col-lg-6">
            <h3>আপনার প্রিয় গাড়ীটি রেখে দুরে এসেছেন!! ভয় নেই, পাহারায় আছে মাইরাডার</h3>

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
                  <span><strong></strong> কেউ দরজা খুললেই পেয়ে যাবেন "ডোর ওপেন এলার্ট"</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span>কত সময় যাবত গাড়ি পারকিং এ আছে তাও জানতে পারবেন।</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span>ইঞ্জিন অন হলেই পেয়ে যাবেন "ইঞ্জিন অন এলার্ট"</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span><strong></strong> গাড়ির গতি, অবস্থান, দিক ইত্যাদি দেখা যাবে</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span>এক পলকে দেখে নিতে পারবেন গাড়ির ভ্রমন পথ</span>
                </div>
                <a href="#about"
                  style="background: #4154f1;padding: 8px 20px;margin-left: 30px;border-radius: 4px;color: #fff; margin-top: 30px;"
                  class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                  <span>প্যাকেজ দেখুন</span>
                  <i class="bi bi-arrow-right text-white"></i>
                </a>
              </div>
              <!-- End Tab 1 Content -->

            </div>

          </div>

          <div class="col-lg-6">
            <img src="{{ asset('landing2/assets/image/car_safety.png', $hasHttps) }}" class="img-fluid" alt="">
          </div>

        </div>
        <!-- End Feature Tabs -->

        <!-- Feature Tabs 2 -->
        <div class="row feture-tabs" data-aos="fade-up">
          <div class="col-lg-6">
            <img src="{{ asset('landing2/assets/image/theft_protection.png', $hasHttps) }}" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6">
            <h3>গাড়ি চূরি নিয়ে চিন্তিত !! সুরক্ষায় আছি আমরা</h3>

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
                  <span><strong>লক মোড:</strong> পারকিং করার পরে রাখুন লক মোডে, হবেনা ইঞ্জিন অন, কন্ট্রোল আপনার
                    অ্যাপে</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span><strong>ইঞ্জিন লক:</strong> myRadar অ্যাপ এর মাধ্যমে গাড়ি চুরি হওয়ার সাথে সাথে ইঞ্জিন অফ
                    করে দিতে পারবেন</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span><strong>জিইও ফেন্স নোটিফিকেশনঃ</strong> নির্ধারিত এলাকার বাহিরে বা ভিতরে প্রবেশ করলে এলার্ট
                    পেয়ে যাবেন সাথে সাথেই ।</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span><strong>ইমারজেন্সি বাটনঃ</strong> হাইজ্যাক হলে ড্রাইভার চাপবে বাটন, চলে আসবে ইমারজেঞ্ছি
                    এলার্ট</span>
                </div>
                <a href="#about"
                  style="background: #4154f1;padding: 8px 20px;margin-left: 30px;border-radius: 4px;color: #fff; margin-top: 30px;"
                  class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                  <span>প্যাকেজ দেখুন</span>
                  <i class="bi bi-arrow-right text-white"></i>
                </a>
              </div>
              <!-- End Tab 1 Content -->

            </div>

          </div>

        </div>
        <!-- End Feature Tabs -->

        <!-- Feature Tabs 3 -->
        <div class="row feture-tabs" data-aos="fade-up">
          <div class="col-lg-6">
            <h3>সি এন জি, ফুয়েল এবং অন্যান্য হিসাব রাখতে হিমসিম খাচ্ছেন!! নো টেনশন</h3>

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
                  <span><strong>মাইলেজ রিপোর্টঃ</strong> মাইলেজ রিপোর্ট দেখে সহজেই পরিমাপ করতে
                    পারবেন ফুয়েলের হিসাব।</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span><strong>সি এন জি মনিটরিংঃ</strong> গাড়ির CNG মিটার myRADAR মোবাইল অ্যাপ-এ দেখতে পাবেন এবং গাড়িতে
                    CNG নেওয়ার সাথে সাথেই ফোনে নোটিফিকেশন পাবেন।</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span><strong>ফুয়েল মনিটরিংঃ </strong>গাড়ির ফুয়েল মিটার দেখতে পাবেন মোবাইল App - এ</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span>ফুয়েল রিফিল এবং লীকেজ এলার্ট (শিগ্রই আসছে)</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span><strong>ডেইলি সামারি:</strong> কতবার ইঞ্জিন অন/অফ করা হয়েছে, কতটুকু সময় চলেছে, কত দুরুত্ত
                    অতিক্রম করেছে নোটিফিকেশন এবং SMS-এর মাধ্যমে জানিয়ে দেয়া হবে</span>
                </div>
                <a href="#about"
                  style="background: #4154f1;padding: 8px 20px;margin-left: 30px;border-radius: 4px;color: #fff; margin-top: 30px;"
                  class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                  <span>প্যাকেজ দেখুন</span>
                  <i class="bi bi-arrow-right text-white"></i>
                </a>
              </div>
              <!-- End Tab 1 Content -->

            </div>

          </div>

          <div class="col-lg-6">
            <img src="{{ asset('landing2/assets/image/cng_monitoring2.png', $hasHttps) }}" class="img-fluid" alt="">
          </div>

        </div>
        <!-- End Feature Tabs -->

        <!-- Feature Tabs 4 -->
        <div class="row feture-tabs" data-aos="fade-up">
          <div class="col-lg-6">
            <img src="{{ asset('landing2/assets/image/live_tracking2.png', $hasHttps) }}" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6">
            <h3>নির্দিষ্ট এলাকার বাইরে গাড়ির যাতায়াত মনিটর করতে চান!! সমাধানে মাইরাডার</h3>

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
                  <span><strong>ডেসটিনেশন এলার্ট:</strong> নির্ধারিত এলাকার বাহিরে গেলে এলার্ট।</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span><strong>এরাইভাল এলার্ট:</strong> নির্ধারিত এলাকার ভিতরে প্রবেশ করলে এলার্ট।</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span>সকল গুরত্তপুরন শহরে প্রবেশ এবং প্রস্থান এর সময় নোটিফিকেশান পাবেন অটোমেটিক্যালি ।</span>
                </div>
                <a href="#about"
                  style="background: #4154f1;padding: 8px 20px;margin-left: 30px;border-radius: 4px;color: #fff; margin-top: 30px;"
                  class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                  <span>প্যাকেজ দেখুন</span>
                  <i class="bi bi-arrow-right text-white"></i>
                </a>
              </div>
              <!-- End Tab 1 Content -->

            </div>

          </div>

        </div>
        <!-- End Feature Tabs -->

        <!-- Feature Tabs 5 -->
        <div class="row feture-tabs" data-aos="fade-up">
          <div class="col-lg-6">
            <h3>আপনজনদের সুরক্ষায় myRadar</h3>

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
                  <span><strong></strong> অতিরিক্ত গতিতে গাড়ি চললেই এলার্ট পাবেন সাথে সাথে</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span><strong></strong> বাচ্চা নির্ধারিত সময়ে স্কুলে পৌঁছেছে কিনা, তা মোবাইল App - এ জানতে পারবেন</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <span>আপনার সেট করে দেয়া গন্তব্যে আপনজন পৌঁছা মাত্র জানিয়ে দেবে myRadar</span>
                </div>

                <a href="#about"
                  style="background: #4154f1;padding: 8px 20px;margin-left: 30px;border-radius: 4px;color: #fff; margin-top: 30px;"
                  class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                  <span>প্যাকেজ দেখুন</span>
                  <i class="bi bi-arrow-right text-white"></i>
                </a>
              </div>
              <!-- End Tab 1 Content -->

            </div>

          </div>

          <div class="col-lg-6">
            <img src="{{ asset('landing2/assets/image/family_safety.png', $hasHttps) }}" class="img-fluid" alt="">
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
          <p>মাইরাডারের সেবাসমূহ</p>
        </header>

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-box blue">
              <i class="ri-discuss-line icon"></i>
              <h3>লাইভ ট্র্যাকিং</h3>
              <ul style="text-align: left;">
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
              <h3>মাইলেজ রিপোর্ট</h3>
              <ul style="text-align: left;">
                <li>প্রতিদিন কত কিলোমিটার ভ্রমণ করেছেন এক পলকেই জানতে পারবেন মাইলেজ রিপোর্ট দেখে</li>
                <li>বিগত দিনের মাইলেজ রিপোর্ট দেখতে পাবেন খুব সহজে</li>
                <li>অস্বাভাবিক মাইলেজ নোটিফিকেশন</li>
              </ul>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="service-box green">
              <i class="ri-discuss-line icon"></i>
              <h3>Special CNG প্যাকেজ</h3>
              <ul style="text-align: left;">
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
              <h3>ডেসটিনেশন এলার্ট</h3>
              <ul style="text-align: left;">
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
              <h3>Corporate গ্রাহকদের জন্য সুবিধা সমূহ</h3>
              <ul style="text-align: left;">
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
              <h3>অন্যান্য সুবিধা সমূহ</h3>
              <ul style="text-align: left;">
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

    <section class="features">
      <div class="container" data-aos="fade-up">
        <!-- Feature Icons -->
        <div class="row feature-icons" data-aos="fade-up">
          <h3>মোবাইল অ্যাপ ফিচার</h3>

          <div class="row">
            <div class="col-xs-12">
              <div style="display: flex; flex-direction: row;">
                <div style="padding: 10px;">
                  <img src="{{ asset('images/screenshots/1.jpg', $hasHttps) }}" alt="" style="width: 100%; border-radius: 4px;" />
                </div>
                <div style="padding: 10px;">
                  <img src="{{ asset('images/screenshots/2.jpg', $hasHttps) }}" alt="" style="width: 100%; border-radius: 4px;" />
                </div>
                <div style="padding: 10px;">
                  <img src="{{ asset('images/screenshots/3.jpg', $hasHttps) }}" alt="" style="width: 100%; border-radius: 4px;" />
                </div>
                <div style="padding: 10px;">
                  <img src="{{ asset('images/screenshots/4.jpg', $hasHttps) }}" alt="" style="width: 100%; border-radius: 4px;" />
                </div>
                <div style="padding: 10px;">
                  <img src="{{ asset('images/screenshots/5.jpg', $hasHttps) }}" alt="" style="width: 100%; border-radius: 4px;" />
                </div>
              </div>
            </div>

            {{-- <div class="col-xl-4 text-center" data-aos="fade-right" data-aos-delay="100">
          <img src="{{ asset('landing2/assets/img/features-3.png') }}" class="img-fluid p-4" alt="">
          </div>

          <div class="col-xl-8 d-flex content">
            <div class="row align-self-center gy-4">

              <div class="col-md-6 icon-box" data-aos="fade-up">
                <i class="ri-line-chart-line"></i>
                <div>
                  <h4>লাইভ ট্র্যাকিং</h4>
                  <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip</p>
                </div>
              </div>

              <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                <i class="ri-stack-line"></i>
                <div>
                  <h4>ইঞ্জিন এলার্ট</h4>
                  <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt</p>
                </div>
              </div>

              <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                <i class="ri-brush-4-line"></i>
                <div>
                  <h4>মাইলেজ রিপোর্ট</h4>
                  <p>Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere</p>
                </div>
              </div>

              <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                <i class="ri-magic-line"></i>
                <div>
                  <h4>Special CNG প্যাকেজ</h4>
                  <p>Expedita veritatis consequuntur nihil tempore laudantium vitae denat pacta</p>
                </div>
              </div>

              <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
                <i class="ri-command-line"></i>
                <div>
                  <h4>ডেসটিনেশন এলার্ট</h4>
                  <p>Et fuga et deserunt et enim. Dolorem architecto ratione tensa raptor marte</p>
                </div>
              </div>

              <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                <i class="ri-radar-line"></i>
                <div>
                  <h4>Explicabo consectetur</h4>
                  <p>Est autem dicta beatae suscipit. Sint veritatis et sit quasi ab aut inventore</p>
                </div>
              </div>

            </div>
          </div> --}}

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
          <p>Check our Pricing</p>
        </header>

        <div class="row gy-4" data-aos="fade-left">

          <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
            <div class="box">
              <h3 style="color: #07d5c0;">Standard</h3>
              <div class="price"><sup></sup>৬,০০০<span> টাকা</span></div>
              <div class="price2"><span>মাসিক চার্জ </span>৪০০<span> টাকা</span></div>
              <img src="{{ asset('landing2/assets/img/pricing-free.png', $hasHttps) }}" class="img-fluid" alt="">
              <ul>
                <li>লাইভ ট্র্যাকিং</li>
                <li>ট্রাভেল হিস্টোরি</li>
                <li>অডিও মনিটরিং</li>
                <li class="na">ইঞ্জিন লক/আনলক</li>
                <li class="na">ইঞ্জিন অন/অফ এলার্ট</li>
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
              <a href="#" class="btn-buy">Buy Now</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
            <div class="box">
              <span class="featured">Featured</span>
              <h3 style="color: #65c600;">Special</h3>
              <div class="price"><sup></sup>৮,০০০<span> টাকা</span></div>
              <div class="price2"><span>মাসিক চার্জ </span>৫০০<span> টাকা</span></div>
              <img src="{{ asset('landing2/assets/img/pricing-starter.png', $hasHttps) }}" class="img-fluid" alt="">
              <ul>
                <li>লাইভ ট্র্যাকিং</li>
                <li>ট্রাভেল হিস্টোরি</li>
                <li>অডিও মনিটরিং</li>
                <li class="na">ইঞ্জিন লক/আনলক</li>
                <li class="na">ইঞ্জিন অন/অফ এলার্ট</li>
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
              <a href="#" class="btn-buy">Buy Now</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
            <div class="box">
              <h3 style="color: #ff901c;">Advanced</h3>
              <div class="price"><sup></sup>১৫,০০০<span> টাকা</span></div>
              <div class="price2"><span>মাসিক চার্জ </span>৮০০<span> টাকা</span></div>
              <img src="{{ asset('landing2/assets/img/pricing-business.png', $hasHttps) }}" class="img-fluid" alt="">
              <ul>
                <li>লাইভ ট্র্যাকিং</li>
                <li>ট্রাভেল হিস্টোরি</li>
                <li>অডিও মনিটরিং</li>
                <li class="na">ইঞ্জিন লক/আনলক</li>
                <li class="na">ইঞ্জিন অন/অফ এলার্ট</li>
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
              <a href="#" class="btn-buy">Buy Now</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="400">
            <div class="box">
              <h3 style="color: #ff0071;">Business</h3>
              <div class="price"><sup></sup>Custom<span></span></div>
              <img src="{{ asset('landing2/assets/img/pricing-ultimate.png', $hasHttps) }}" class="img-fluid" alt="">
              <ul>
                <li>লাইভ ট্র্যাকিং</li>
                <li>ট্রাভেল হিস্টোরি</li>
                <li>অডিও মনিটরিং</li>
                <li class="na">ইঞ্জিন লক/আনলক</li>
                <li class="na">ইঞ্জিন অন/অফ এলার্ট</li>
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
              <a href="#" class="btn-buy">Buy Now</a>
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
          <p>Frequently Asked Questions</p>
        </header>

        <div class="row">
          <div class="col-lg-6">
            <!-- F.A.Q List 1-->
            <div class="accordion accordion-flush" id="faqlist1">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq-content-1">
                    Non consectetur a erat nam at lectus urna duis?
                  </button>
                </h2>
                <div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                  <div class="accordion-body">
                    Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur
                    gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq-content-2">
                    Feugiat scelerisque varius morbi enim nunc faucibus a pellentesque?
                  </button>
                </h2>
                <div id="faq-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                  <div class="accordion-body">
                    Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id
                    donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque
                    elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq-content-3">
                    Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi?
                  </button>
                </h2>
                <div id="faq-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                  <div class="accordion-body">
                    Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar
                    elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque
                    eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis
                    sed odio morbi quis
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="col-lg-6">

            <!-- F.A.Q List 2-->
            <div class="accordion accordion-flush" id="faqlist2">

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq2-content-1">
                    Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla?
                  </button>
                </h2>
                <div id="faq2-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                  <div class="accordion-body">
                    Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id
                    donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque
                    elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq2-content-2">
                    Tempus quam pellentesque nec nam aliquam sem et tortor consequat?
                  </button>
                </h2>
                <div id="faq2-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                  <div class="accordion-body">
                    Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in.
                    Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est.
                    Purus gravida quis blandit turpis cursus in
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq2-content-3">
                    Varius vel pharetra vel turpis nunc eget lorem dolor?
                  </button>
                </h2>
                <div id="faq2-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                  <div class="accordion-body">
                    Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae ultricies leo integer malesuada
                    nunc vel. Tincidunt eget nullam non nisi est sit amet. Turpis nunc eget lorem dolor sed. Ut
                    venenatis tellus in metus vulputate eu scelerisque. Pellentesque diam volutpat commodo sed egestas
                    egestas fringilla phasellus faucibus. Nibh tellus molestie nunc non blandit massa enim nec.
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>

      </div>

    </section><!-- End F.A.Q Section -->

    <!-- ======= Portfolio Section ======= -->
    {{-- <section id="portfolio" class="portfolio">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Portfolio</h2>
          <p>Check our latest work</p>
        </header>

        <div class="row" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">All</li>
              <li data-filter=".filter-app">App</li>
              <li data-filter=".filter-card">Card</li>
              <li data-filter=".filter-web">Web</li>
            </ul>
          </div>
        </div>

        <div class="row gy-4 portfolio-container" data-aos="fade-up" data-aos-delay="200">

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="{{ asset('landing2/assets/img/portfolio/portfolio-1.jpg') }}" class="img-fluid" alt="">
    <div class="portfolio-info">
      <h4>App 1</h4>
      <p>App</p>
      <div class="portfolio-links">
        <a href="{{ asset('landing2/assets/img/portfolio/portfolio-1.jpg') }}" data-gallery="portfolioGallery"
          class="portfokio-lightbox" title="App 1"><i class="bi bi-plus"></i></a>
        <a href="portfolio-details.html" title="More Details"><i class="bi bi-link"></i></a>
      </div>
    </div>
    </div>
    </div>

    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
      <div class="portfolio-wrap">
        <img src="{{ asset('landing2/assets/img/portfolio/portfolio-2.jpg') }}" class="img-fluid" alt="">
        <div class="portfolio-info">
          <h4>Web 3</h4>
          <p>Web</p>
          <div class="portfolio-links">
            <a href="{{ asset('landing2/assets/img/portfolio/portfolio-2.jpg') }}" data-gallery="portfolioGallery"
              class="portfokio-lightbox" title="Web 3"><i class="bi bi-plus"></i></a>
            <a href="portfolio-details.html" title="More Details"><i class="bi bi-link"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
      <div class="portfolio-wrap">
        <img src="{{ asset('landing2/assets/img/portfolio/portfolio-3.jpg') }}" class="img-fluid" alt="">
        <div class="portfolio-info">
          <h4>App 2</h4>
          <p>App</p>
          <div class="portfolio-links">
            <a href="{{ asset('landing2/assets/img/portfolio/portfolio-3.jpg') }}" data-gallery="portfolioGallery"
              class="portfokio-lightbox" title="App 2"><i class="bi bi-plus"></i></a>
            <a href="portfolio-details.html" title="More Details"><i class="bi bi-link"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
      <div class="portfolio-wrap">
        <img src="{{ asset('landing2/assets/img/portfolio/portfolio-4.jpg') }}" class="img-fluid" alt="">
        <div class="portfolio-info">
          <h4>Card 2</h4>
          <p>Card</p>
          <div class="portfolio-links">
            <a href="{{ asset('landing2/assets/img/portfolio/portfolio-4.jpg') }}" data-gallery="portfolioGallery"
              class="portfokio-lightbox" title="Card 2"><i class="bi bi-plus"></i></a>
            <a href="portfolio-details.html" title="More Details"><i class="bi bi-link"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
      <div class="portfolio-wrap">
        <img src="{{ asset('landing2/assets/img/portfolio/portfolio-5.jpg') }}" class="img-fluid" alt="">
        <div class="portfolio-info">
          <h4>Web 2</h4>
          <p>Web</p>
          <div class="portfolio-links">
            <a href="{{ asset('landing2/assets/img/portfolio/portfolio-5.jpg') }}" data-gallery="portfolioGallery"
              class="portfokio-lightbox" title="Web 2"><i class="bi bi-plus"></i></a>
            <a href="portfolio-details.html" title="More Details"><i class="bi bi-link"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
      <div class="portfolio-wrap">
        <img src="{{ asset('landing2/assets/img/portfolio/portfolio-6.jpg') }}" class="img-fluid" alt="">
        <div class="portfolio-info">
          <h4>App 3</h4>
          <p>App</p>
          <div class="portfolio-links">
            <a href="{{ asset('landing2/assets/img/portfolio/portfolio-6.jpg') }}" data-gallery="portfolioGallery"
              class="portfokio-lightbox" title="App 3"><i class="bi bi-plus"></i></a>
            <a href="portfolio-details.html" title="More Details"><i class="bi bi-link"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
      <div class="portfolio-wrap">
        <img src="{{ asset('landing2/assets/img/portfolio/portfolio-7.jpg') }}" class="img-fluid" alt="">
        <div class="portfolio-info">
          <h4>Card 1</h4>
          <p>Card</p>
          <div class="portfolio-links">
            <a href="{{ asset('landing2/assets/img/portfolio/portfolio-7.jpg') }}" data-gallery="portfolioGallery"
              class="portfokio-lightbox" title="Card 1"><i class="bi bi-plus"></i></a>
            <a href="portfolio-details.html" title="More Details"><i class="bi bi-link"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
      <div class="portfolio-wrap">
        <img src="{{ asset('landing2/assets/img/portfolio/portfolio-8.jpg') }}" class="img-fluid" alt="">
        <div class="portfolio-info">
          <h4>Card 3</h4>
          <p>Card</p>
          <div class="portfolio-links">
            <a href="{{ asset('landing2/assets/img/portfolio/portfolio-8.jpg') }}" data-gallery="portfolioGallery"
              class="portfokio-lightbox" title="Card 3"><i class="bi bi-plus"></i></a>
            <a href="portfolio-details.html" title="More Details"><i class="bi bi-link"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
      <div class="portfolio-wrap">
        <img src="{{ asset('landing2/assets/img/portfolio/portfolio-9.jpg') }}" class="img-fluid" alt="">
        <div class="portfolio-info">
          <h4>Web 3</h4>
          <p>Web</p>
          <div class="portfolio-links">
            <a href="{{ asset('landing2/assets/img/portfolio/portfolio-9.jpg') }}" data-gallery="portfolioGallery"
              class="portfokio-lightbox" title="Web 3"><i class="bi bi-plus"></i></a>
            <a href="portfolio-details.html" title="More Details"><i class="bi bi-link"></i></a>
          </div>
        </div>
      </div>
    </div>

    </div>

    </div>

    </section> --}}
    <!-- End Portfolio Section -->

    <!-- ======= Testimonials Section ======= -->
    {{-- <section id="testimonials" class="testimonials">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Testimonials</h2>
          <p>What they are saying about us</p>
        </header>

        <div class="testimonials-slider swiper-container" data-aos="fade-up" data-aos-delay="200">
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium
                  quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.
                </p>
                <div class="profile mt-auto">
                  <img src="{{ asset('landing2/assets/img/testimonials/testimonials-1.jpg') }}" class="testimonial-img"
    alt="">
    <h3>Saul Goodman</h3>
    <h4>Ceo &amp; Founder</h4>
    </div>
    </div>
    </div><!-- End testimonial item -->

    <div class="swiper-slide">
      <div class="testimonial-item">
        <div class="stars">
          <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
            class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
        </div>
        <p>
          Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis
          quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
        </p>
        <div class="profile mt-auto">
          <img src="{{ asset('landing2/assets/img/testimonials/testimonials-2.jpg') }}" class="testimonial-img" alt="">
          <h3>Sara Wilsson</h3>
          <h4>Designer</h4>
        </div>
      </div>
    </div><!-- End testimonial item -->

    <div class="swiper-slide">
      <div class="testimonial-item">
        <div class="stars">
          <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
            class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
        </div>
        <p>
          Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim
          tempor labore quem eram duis noster aute amet eram fore quis sint minim.
        </p>
        <div class="profile mt-auto">
          <img src="{{ asset('landing2/assets/img/testimonials/testimonials-3.jpg') }}" class="testimonial-img" alt="">
          <h3>Jena Karlis</h3>
          <h4>Store Owner</h4>
        </div>
      </div>
    </div><!-- End testimonial item -->

    <div class="swiper-slide">
      <div class="testimonial-item">
        <div class="stars">
          <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
            class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
        </div>
        <p>
          Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit
          minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.
        </p>
        <div class="profile mt-auto">
          <img src="{{ asset('landing2/assets/img/testimonials/testimonials-4.jpg') }}" class="testimonial-img" alt="">
          <h3>Matt Brandon</h3>
          <h4>Freelancer</h4>
        </div>
      </div>
    </div><!-- End testimonial item -->

    <div class="swiper-slide">
      <div class="testimonial-item">
        <div class="stars">
          <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
            class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
        </div>
        <p>
          Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa
          labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.
        </p>
        <div class="profile mt-auto">
          <img src="{{ asset('landing2/assets/img/testimonials/testimonials-5.jpg') }}" class="testimonial-img" alt="">
          <h3>John Larson</h3>
          <h4>Entrepreneur</h4>
        </div>
      </div>
    </div><!-- End testimonial item -->

    </div>
    <div class="swiper-pagination"></div>
    </div>

    </div>

    </section> --}}
    <!-- End Testimonials Section -->

    <!-- ======= Team Section ======= -->
    {{-- <section id="team" class="team">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Team</h2>
          <p>Our hard working team</p>
        </header>

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="member">
              <div class="member-img">
                <img src="{{ asset('landing2/assets/img/team/team-1.jpg') }}" class="img-fluid" alt="">
    <div class="social">
      <a href=""><i class="bi bi-twitter"></i></a>
      <a href=""><i class="bi bi-facebook"></i></a>
      <a href=""><i class="bi bi-instagram"></i></a>
      <a href=""><i class="bi bi-linkedin"></i></a>
    </div>
    </div>
    <div class="member-info">
      <h4>Walter White</h4>
      <span>Chief Executive Officer</span>
      <p>Velit aut quia fugit et et. Dolorum ea voluptate vel tempore tenetur ipsa quae aut. Ipsum
        exercitationem iure minima enim corporis et voluptate.</p>
    </div>
    </div>
    </div>

    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
      <div class="member">
        <div class="member-img">
          <img src="{{ asset('landing2/assets/img/team/team-2.jpg') }}" class="img-fluid" alt="">
          <div class="social">
            <a href=""><i class="bi bi-twitter"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
        <div class="member-info">
          <h4>Sarah Jhonson</h4>
          <span>Product Manager</span>
          <p>Quo esse repellendus quia id. Est eum et accusantium pariatur fugit nihil minima suscipit corporis.
            Voluptate sed quas reiciendis animi neque sapiente.</p>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
      <div class="member">
        <div class="member-img">
          <img src="{{ asset('landing2/assets/img/team/team-3.jpg') }}" class="img-fluid" alt="">
          <div class="social">
            <a href=""><i class="bi bi-twitter"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
        <div class="member-info">
          <h4>William Anderson</h4>
          <span>CTO</span>
          <p>Vero omnis enim consequatur. Voluptas consectetur unde qui molestiae deserunt. Voluptates enim aut
            architecto porro aspernatur molestiae modi.</p>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400">
      <div class="member">
        <div class="member-img">
          <img src="{{ asset('landing2/assets/img/team/team-4.jpg') }}" class="img-fluid" alt="">
          <div class="social">
            <a href=""><i class="bi bi-twitter"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
        <div class="member-info">
          <h4>Amanda Jepson</h4>
          <span>Accountant</span>
          <p>Rerum voluptate non adipisci animi distinctio et deserunt amet voluptas. Quia aut aliquid doloremque
            ut possimus ipsum officia.</p>
        </div>
      </div>
    </div>

    </div>

    </div>

    </section> --}}
    <!-- End Team Section -->

    <!-- ======= Clients Section ======= -->
    <section id="clients" class="clients">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Our Clients</h2>
          <p>Temporibus omnis officia</p>
        </header>

        <div class="clients-slider swiper-container">
          <div class="swiper-wrapper align-items-center">
            <div class="swiper-slide"><img src="{{ asset('landing2/assets/img/clients/client-1.png', $hasHttps) }}"
                class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{ asset('landing2/assets/img/clients/client-2.png', $hasHttps) }}"
                class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{ asset('landing2/assets/img/clients/client-3.png', $hasHttps) }}"
                class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{ asset('landing2/assets/img/clients/client-4.png', $hasHttps) }}"
                class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{ asset('landing2/assets/img/clients/client-5.png', $hasHttps) }}"
                class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{ asset('landing2/assets/img/clients/client-6.png', $hasHttps) }}"
                class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{ asset('landing2/assets/img/clients/client-7.png', $hasHttps) }}"
                class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{ asset('landing2/assets/img/clients/client-8.png', $hasHttps) }}"
                class="img-fluid" alt=""></div>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>

    </section>
    <!-- End Clients Section -->

    <!-- ======= Recent Blog Posts Section ======= -->
    {{-- <section id="recent-blog-posts" class="recent-blog-posts">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Blog</h2>
          <p>Recent posts form our Blog</p>
        </header>

        <div class="row">

          <div class="col-lg-4">
            <div class="post-box">
              <div class="post-img"><img src="{{ asset('landing2/assets/img/blog/blog-1.jpg') }}" class="img-fluid"
                  alt=""></div>
              <span class="post-date">Tue, September 15</span>
              <h3 class="post-title">Eum ad dolor et. Autem aut fugiat debitis voluptatem consequuntur sit</h3>
              <a href="blog-singe.html" class="readmore stretched-link mt-auto"><span>Read More</span><i
                  class="bi bi-arrow-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="post-box">
              <div class="post-img"><img src="{{ asset('landing2/assets/img/blog/blog-2.jpg') }}" class="img-fluid"
                  alt=""></div>
              <span class="post-date">Fri, August 28</span>
              <h3 class="post-title">Et repellendus molestiae qui est sed omnis voluptates magnam</h3>
              <a href="blog-singe.html" class="readmore stretched-link mt-auto"><span>Read More</span><i
                  class="bi bi-arrow-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="post-box">
              <div class="post-img"><img src="{{ asset('landing2/assets/img/blog/blog-3.jpg') }}" class="img-fluid"
                  alt=""></div>
              <span class="post-date">Mon, July 11</span>
              <h3 class="post-title">Quia assumenda est et veritatis aut quae</h3>
              <a href="blog-singe.html" class="readmore stretched-link mt-auto"><span>Read More</span><i
                  class="bi bi-arrow-right"></i></a>
            </div>
          </div>

        </div>

      </div>

    </section> --}}
    <!-- End Recent Blog Posts Section -->

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
                  <p>A108 Adam Street,<br>New York, NY 535022</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <i class="bi bi-telephone"></i>
                  <h3>Call Us</h3>
                  <p>+1 5589 55488 55<br>+1 6678 254445 41</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <i class="bi bi-envelope"></i>
                  <h3>Email Us</h3>
                  <p><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                      data-cfemail="8be2e5ede4cbeef3eae6fbe7eea5e8e4e6">[email&#160;protected]</a><br><a
                      href="/cdn-cgi/l/email-protection" class="__cf_email__"
                      data-cfemail="41222e2f35202235012439202c312d246f222e2c">[email&#160;protected]</a></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <i class="bi bi-clock"></i>
                  <h3>Open Hours</h3>
                  <p>Monday - Friday<br>9:00AM - 05:00PM</p>
                </div>
              </div>
            </div>

          </div>

          <div class="col-lg-6">
            <form action="forms/contact.php" method="post" class="php-email-form">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required>
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

    <div class="footer-newsletter">
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
    </div>

    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-5 col-md-12 footer-info">
            <a href="index.html" class="logo d-flex align-items-center">
              <img src="{{ asset('landing2/assets/img/logo.png', $hasHttps) }}" alt="">
              <span>FlexStart</span>
            </a>
            <p>Cras fermentum odio eu feugiat lide par naso tierra. Justo eget nada terra videa magna derita valies
              darta donna mare fermentum iaculis eu non diam phasellus.</p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram bx bxl-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin bx bxl-linkedin"></i></a>
            </div>
          </div>

          <div class="col-lg-2 col-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">About us</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Web Design</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Web Development</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Product Management</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Marketing</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Graphic Design</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
            <h4>Contact Us</h4>
            <p>
              A108 Adam Street <br>
              New York, NY 535022<br>
              United States <br><br>
              <strong>Phone:</strong> +1 5589 55488 55<br>
              <strong>Email:</strong> <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                data-cfemail="bcd5d2dad3fcd9c4ddd1ccd0d992dfd3d1">[email&#160;protected]</a><br>
            </p>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>FlexStart</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/flexstart-bootstrap-startup-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  {{-- <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script> --}}
  <script src="{{ asset('landing2/assets/vendor/aos/aos.js', $hasHttps) }}"></script>
  <script src="{{ asset('landing2/assets/vendor/php-email-form/validate.js', $hasHttps) }}"></script>
  <script src="{{ asset('landing2/assets/vendor/swiper/swiper-bundle.min.js', $hasHttps) }}"></script>
  <script src="{{ asset('landing2/assets/vendor/purecounter/purecounter.js', $hasHttps) }}"></script>
  <script src="{{ asset('landing2/assets/vendor/isotope-layout/isotope.pkgd.min.js', $hasHttps) }}"></script>
  <script src="{{ asset('landing2/assets/vendor/glightbox/js/glightbox.min.js', $hasHttps) }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('landing2/assets/js/main.js', $hasHttps) }}"></script>

  {{-- <script>if( window.self == window.top ) { (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-55234356-4', 'auto'); ga('send', 'pageview'); } </script> --}}
</body>

</html>
