<!-- ======= Hero Section ======= -->
@php
$hasHttps= env('APP_ENV')=='production'
@endphp
<section id="hero" class="hero d-flex align-items-center">
  <div class="row" style="width: 100%; --bs-gutter-x: 0;">
    <div class="col-lg-12" style="display: flex; flex-direction: column; align-items: center;">
      <div class="container-fluid position-relative">
        <img src="{{ asset('landing2/assets/image/banner.gif', $hasHttps) }}" class="img-fluid d-none d-lg-block" alt=""
          style="width: 100%;" />
        <div class="row d-none d-lg-block position-absolute bottom-0 start-50 translate-middle-x">
          <div class="col-xs-12 d-flex flex-row justify-content-center align-items-center">
            <a target="_blank" href="{{ config('myradar.appstore') }}"
              title="Download from App Store" class="btn-appstore">App Store</a>
            <a target="_blank" href="{{ config('myradar.playstore') }}"
              title="Download from Play Store" class="btn-playstore">Play Store</a>
          </div>
        </div>
      </div>
      <img src="{{ asset('landing2/assets/image/live_tracking3.gif', $hasHttps) }}" class="img-fluid d-lg-none" alt=""
        style="width: 100%;" />
      <div class="w-100 d-flex flex-row justify-content-center align-items-center d-lg-none" style="gap: 30px;">
        <a target="_blank" href="{{ config('myradar.appstore') }}"
            title="Download from App Store" style="width: 35%;">
          <img src="{{ asset('images/btn-appstore.png', $hasHttps) }}" class="img-fluid" alt="">  
        </a>
        <a target="_blank" href="{{ config('myradar.playstore') }}"
          title="Download from Play Store" style="width: 35%;">
          <img src="{{ asset('images/btn-playstore.png', $hasHttps) }}" class="img-fluid" alt="">  
        </a>
      </div>
      <h2 class="text-center bangla" style="font-weight: 800; color: #424242; font-size: 24px; margin-top: 30px;">
        @lang('header.banner.title')
      </h2>
      <p class="text-enter bangla" style="margin-top: 10px; font-size: 16px;">
        @lang('header.banner.caption')
      </p>
      <a href="#pricing" style="background: #4154f1;padding: 18px 30px; border-radius: 4px; color: #fff;"
        class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
        <span class="bangla">@lang('header.banner.action')</span>
        <i class="bi bi-arrow-right text-white"></i>
      </a>
    </div>
  </div>

</section><!-- End Hero -->