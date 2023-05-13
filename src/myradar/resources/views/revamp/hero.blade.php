<!-- ======= Hero Section ======= -->
<section id="hero" class="hero d-flex align-items-center">
  <div class="row" style="width: 100%; --bs-gutter-x: 0;">
    <div class="col-lg-12" style="display: flex; flex-direction: column; align-items: center;">
      <div class="container-fluid position-relative">
        <img src="{{ asset('landing2/assets/image/banner.gif') }}" class="img-fluid d-none d-lg-block" alt=""
          style="width: 100%;" />
        <div class="row d-none d-lg-block position-absolute bottom-0 start-50 translate-middle-x">
          <div class="col-xs-12 d-flex flex-row justify-content-center align-items-center">
            <a target="_blank" href="{{ config('myradar.appstore') }}" title="Download from App Store"
              class="btn-appstore">App Store</a>
            <a target="_blank" href="{{ config('myradar.playstore') }}" title="Download from Play Store"
              class="btn-playstore">Play Store</a>
          </div>
        </div>
      </div>
      <img src="{{ asset('landing2/assets/image/live_tracking3.gif', true) }}" class="img-fluid d-lg-none" alt=""
        style="width: 100%;" />
      <div class="w-100 d-flex flex-row justify-content-center align-items-center d-lg-none" style="gap: 30px;">
        <a target="_blank" href="{{ config('myradar.appstore') }}" title="Download from App Store" style="width: 35%;">
          <img src="{{ asset('images/btn-appstore.png', true) }}" class="img-fluid" alt="">
        </a>
        <a target="_blank" href="{{ config('myradar.playstore') }}" title="Download from Play Store"
          style="width: 35%;">
          <img src="{{ asset('images/btn-playstore.png', true) }}" class="img-fluid" alt="">
        </a>
      </div>
      <h1 class="text-center @lang('misc.font')" style="font-weight: 800; color: #4154f1; font-size: 30px; margin-top: 30px;">
        Best vehicle tracking system in Bangladesh
      </h1>
      <p class="text-center @lang('misc.font')" style="font-weight: 700; color: #424242; font-size: 20px; margin-top: 10px;">
        @lang('header.banner.title')
      </p>
      <p class="text-enter @lang('misc.font')" style="margin-top: 10px; font-size: 16px;">
        @lang('header.banner.caption')
      </p>
      <div class="tw-flex tw-flex-col lg:tw-flex-row tw-justify-center tw-items-center tw-gap-8">
        <a href="#" @click="showOfferModal = true" style="background: #3B3B98;"
          class="btn-get-started d-inline-flex align-items-center justify-content-center align-self-center tw-gap-x-4">
          <img src="{{ asset('images/icon/giftbox.png') }}" alt=""
            class="tw-w-6 tw-h-6 animate__animated animate__tada animate__slow animate__infinite">
          <span class="@lang('misc.font')">@lang('header.banner.coupon')</span>
        </a>
        <a href="#pricing" style="background: #4154f1;padding: 18px 30px; border-radius: 4px; color: #fff;"
          class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
          <span class="@lang('misc.font')">@lang('header.banner.action')</span>
          <i class="bi bi-arrow-right text-white"></i>
        </a>
      </div>

    </div>
  </div>

</section><!-- End Hero -->
