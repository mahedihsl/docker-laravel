<!-- ======= Pricing Section ======= -->
@php
$hasHttps= env('APP_ENV')=='production'
@endphp
<section id="pricing" class="pricing">

  <div class="container" data-aos="fade-up">

    <header class="section-header">
      <h2>Pricing</h2>
      <p class="bangla">@lang('price.title')</p>
    </header>

    <div class="row gy-4" data-aos="fade-left">

      <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
        <div class="box">
          <h3 class="price-standard">@lang('price.standard.name') <div class="arrow"></div>
          </h3>
          <div class="price bangla"><sup class="na">@lang('price.standard.price_prev')</sup>@lang('price.standard.price')<span> @lang('misc.currency')</span></div>
          <div class="price2 bangla"><span>@lang('misc.month_charge') </span>@lang('price.standard.bill')<span> @lang('misc.currency')</span></div>
          {{-- <img src="{{ asset('landing2/assets/img/pricing-free.png', $hasHttps) }}" class="img-fluid" alt=""> --}}
          <ul class="bangla">
            <li>@lang('price.items.1')</li>
            <li>@lang('price.items.2')</li>
            <li>@lang('price.items.3')</li>
            <li>@lang('price.items.4')</li>
            <li>@lang('price.items.5')</li>
            <li>@lang('price.items.6')</li>
            <li>@lang('price.items.7')</li>
            <li>@lang('price.items.8')</li>
            <li>@lang('price.items.9')</li>
            <li class="na">@lang('price.items.10')</li>
            <li class="na">@lang('price.items.11')</li>
            <li class="na">@lang('price.items.12')</li>
            <li class="na">@lang('price.items.13')</li>
            <li class="na">@lang('price.items.14')</li>
            <li class="na">@lang('price.items.15')</li>
            <li>@lang('price.items.16')</li>
            <li>@lang('price.items.17')</li>
            <li>@lang('price.items.18')</li>
          </ul>
          <a href="#contact" class="btn-buy">Buy Now</a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
        <div class="box">
          {{-- <span class="featured">Featured</span> --}}
          <h3 class="price-special">@lang('price.special.name') <div class="arrow"></div>
          </h3>
          <div class="price bangla"><sup class="na">@lang('price.special.price_prev')</sup>@lang('price.special.price')<span> @lang('misc.currency')</span></div>
          <div class="price2 bangla"><span>@lang('misc.month_charge') </span>@lang('price.special.bill')<span> @lang('misc.currency')</span></div>
          {{-- <img src="{{ asset('landing2/assets/img/pricing-starter.png', $hasHttps) }}" class="img-fluid" alt="">
          --}}
          <ul class="bangla">
            <li>@lang('price.items.1')</li>
            <li>@lang('price.items.2')</li>
            <li>@lang('price.items.3')</li>
            <li>@lang('price.items.4')</li>
            <li>@lang('price.items.5')</li>
            <li>@lang('price.items.6')</li>
            <li>@lang('price.items.7')</li>
            <li>@lang('price.items.8')</li>
            <li>@lang('price.items.9')</li>
            <li>@lang('price.items.10')</li>
            <li>@lang('price.items.11')</li>
            <li>@lang('price.items.12')</li>
            <li class="na">@lang('price.items.13')</li>
            <li class="na">@lang('price.items.14')</li>
            <li class="na">@lang('price.items.15')</li>
            <li>@lang('price.items.16')</li>
            <li>@lang('price.items.17')</li>
            <li>@lang('price.items.18')</li>
          </ul>
          <a href="#contact" class="btn-buy">Buy Now</a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
        <div class="box">
          <h3 class="price-advanced">@lang('price.advanced.name') <div class="arrow"></div>
          </h3>
          <div class="price bangla"><sup></sup>@lang('price.advanced.price')<span> @lang('misc.currency')</span></div>
          <div class="price2 bangla"><span>@lang('misc.month_charge') </span>@lang('price.advanced.bill')<span> @lang('misc.currency')</span></div>
          {{-- <img src="{{ asset('landing2/assets/img/pricing-business.png', $hasHttps) }}" class="img-fluid" alt="">
          --}}
          <ul class="bangla">
            <li>@lang('price.items.1')</li>
            <li>@lang('price.items.2')</li>
            <li>@lang('price.items.3')</li>
            <li>@lang('price.items.4')</li>
            <li>@lang('price.items.5')</li>
            <li>@lang('price.items.6')</li>
            <li>@lang('price.items.7')</li>
            <li>@lang('price.items.8')</li>
            <li>@lang('price.items.9')</li>
            <li>@lang('price.items.10')</li>
            <li>@lang('price.items.11')</li>
            <li>@lang('price.items.12')</li>
            <li>@lang('price.items.13')</li>
            <li>@lang('price.items.14')</li>
            <li>@lang('price.items.15')</li>
            <li>@lang('price.items.16')</li>
            <li>@lang('price.items.17')</li>
            <li>@lang('price.items.18')</li>
          </ul>
          <a href="#contact" class="btn-buy">Buy Now</a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="400">
        <div class="box">
          <h3 class="price-business">@lang('price.business.name') <div class="arrow"></div>
          </h3>
          <div class="price bangla"><sup></sup>@lang('price.business.price')<span></span></div>
          <div class="price2 bangla">&nbsp;</div>
          {{-- <img src="{{ asset('landing2/assets/img/pricing-ultimate.png', $hasHttps) }}" class="img-fluid" alt="">
          --}}
          <ul class="bangla">
            <li>@lang('price.items.1')</li>
            <li>@lang('price.items.2')</li>
            <li>@lang('price.items.3')</li>
            <li>@lang('price.items.4')</li>
            <li>@lang('price.items.5')</li>
            <li>@lang('price.items.6')</li>
            <li>@lang('price.items.7')</li>
            <li>@lang('price.items.8')</li>
            <li>@lang('price.items.9')</li>
            <li>@lang('price.items.10')</li>
            <li>@lang('price.items.11')</li>
            <li>@lang('price.items.12')</li>
            <li>@lang('price.items.13')</li>
            <li>@lang('price.items.14')</li>
            <li>@lang('price.items.15')</li>
            <li>@lang('price.items.16')</li>
            <li>@lang('price.items.17')</li>
            <li>@lang('price.items.18')</li>
          </ul>
          <a href="#contact" class="btn-buy">Buy Now</a>
        </div>
      </div>
    </div>
  </div>

</section><!-- End Pricing Section -->
