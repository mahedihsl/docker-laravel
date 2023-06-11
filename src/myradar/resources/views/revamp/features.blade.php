<!-- ======= Features Section ======= -->
@php
$hasHttps= env('APP_ENV')=='production'
@endphp
<section id="feature" class="features">

  <div class="container" data-aos="fade-up">

    <header class="section-header">
      <h2>Features</h2>
      <p class="bangla">@lang('feature.title')</p>
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
              <h3 class="bangla">@lang('feature.items.1')</h3>
            </div>
          </div>

          <div class="col-md-6" data-aos="zoom-out" data-aos-delay="300">
            <div class="feature-box d-flex align-items-center">
              <i class="bi bi-check"></i>
              <h3 class="bangla">@lang('feature.items.2')</h3>
            </div>
          </div>

          <div class="col-md-6" data-aos="zoom-out" data-aos-delay="300">
            <div class="feature-box d-flex align-items-center">
              <i class="bi bi-check"></i>
              <h3 class="bangla">@lang('feature.items.3')</h3>
            </div>
          </div>

          <div class="col-md-6" data-aos="zoom-out" data-aos-delay="400">
            <div class="feature-box d-flex align-items-center">
              <i class="bi bi-check"></i>
              <h3 class="bangla">@lang('feature.items.4')</h3>
            </div>
          </div>

          <div class="col-md-6" data-aos="zoom-out" data-aos-delay="500">
            <div class="feature-box d-flex align-items-center">
              <i class="bi bi-check"></i>
              <h3 class="bangla">@lang('feature.items.5')</h3>
            </div>
          </div>

          <div class="col-md-6" data-aos="zoom-out" data-aos-delay="600">
            <div class="feature-box d-flex align-items-center">
              <i class="bi bi-check"></i>
              <h3 class="bangla">@lang('feature.items.6')</h3>
            </div>
          </div>

        </div>
      </div>

    </div> <!-- / row -->

    <!-- Feature Tabs 1 -->
    <div class="row feture-tabs" data-aos="fade-up">
      <div class="col-lg-6">
        <h3 class="bangla">@lang('story.1.title')</h3>

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
              <span class="bangla"><strong></strong> @lang('story.1.items.1.normal')</span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">@lang('story.1.items.2.normal')</span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">@lang('story.1.items.3.normal')</span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla"><strong></strong> @lang('story.1.items.4.normal')</span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">@lang('story.1.items.5.normal')</span>
            </div>
            <a href="#pricing"
              style="background: #4154f1;padding: 8px 20px;margin-left: 30px;border-radius: 4px;color: #fff; margin-top: 30px;"
              class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
              <span class="bangla">@lang('header.banner.action')</span>
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
        <img src="{{ asset('landing2/assets/image/live_tracking3.gif', $hasHttps) }}" class="img-fluid" alt="">
      </div>

      <div class="col-lg-6">
        <h3 class="bangla">@lang('story.2.title')</h3>

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
              <span class="bangla">
                <strong>@lang('story.2.items.1.bold')</strong>
                @lang('story.2.items.1.normal')
              </span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">
                <strong>@lang('story.2.items.2.bold')</strong>
                @lang('story.2.items.2.normal')
              </span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">
                <strong>@lang('story.2.items.3.bold')</strong> 
                @lang('story.2.items.3.normal')
              </span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">
                <strong>@lang('story.2.items.4.bold')</strong> 
                @lang('story.2.items.4.normal')
              </span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">
                <strong>@lang('story.2.items.5.bold')</strong> 
                @lang('story.2.items.5.normal')
              </span>
            </div>
            <a href="#pricing"
              style="background: #4154f1;padding: 8px 20px;margin-left: 30px;border-radius: 4px;color: #fff; margin-top: 30px;"
              class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
              <span class="bangla">@lang('header.banner.action')</span>
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
        <h3 class="bangla">@lang('story.3.title')</h3>

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
              <span class="bangla">
                <strong>@lang('story.3.items.1.bold')</strong> 
                @lang('story.3.items.1.normal')  
              </span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">
                <strong>@lang('story.3.items.2.bold')</strong> 
                @lang('story.3.items.2.normal')  
              </span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">
                <strong>@lang('story.3.items.3.bold')</strong> 
                @lang('story.3.items.3.normal')  
              </span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">
                <strong>@lang('story.3.items.4.bold')</strong> 
                @lang('story.3.items.4.normal')
              </span>
            </div>
            <a href="#pricing"
              style="background: #4154f1;padding: 8px 20px;margin-left: 30px;border-radius: 4px;color: #fff; margin-top: 30px;"
              class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
              <span class="bangla">@lang('header.banner.action')</span>
              <i class="bi bi-arrow-right text-white"></i>
            </a>
          </div>
          <!-- End Tab 1 Content -->

        </div>

      </div>

      <div class="col-lg-6">
        <img src="{{ asset('landing2/assets/image/theft_protection.png', $hasHttps) }}" class="img-fluid" alt="">
      </div>

    </div>
    <!-- End Feature Tabs -->

    <!-- Feature Tabs 4 -->
    <div id="fuel-meter" class="row feture-tabs" data-aos="fade-up">
      <div class="col-lg-6">
        <img src="{{ asset('landing2/assets/image/cng_monitoring2.png', $hasHttps) }}" class="img-fluid" alt="">
      </div>

      <div class="col-lg-6">
        <h3 class="bangla">@lang('story.4.title')</h3>

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
              <span class="bangla">
                <strong>@lang('story.4.items.1.bold')</strong> 
                @lang('story.4.items.1.normal')
              </span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">
                <strong>@lang('story.4.items.2.bold')</strong> 
                @lang('story.4.items.2.normal')
              </span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">
                <strong>@lang('story.4.items.3.bold')</strong> 
                @lang('story.4.items.3.normal')
              </span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">
                <strong>@lang('story.4.items.4.bold')</strong> 
                @lang('story.4.items.4.normal')
              </span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">
                <strong>@lang('story.4.items.5.bold')</strong> 
                @lang('story.4.items.5.normal')
              </span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">
                <strong>@lang('story.4.items.6.bold')</strong> 
                @lang('story.4.items.6.normal')
              </span>
            </div>
            <a href="#pricing"
              style="background: #4154f1;padding: 8px 20px;margin-left: 30px;border-radius: 4px;color: #fff; margin-top: 30px;"
              class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
              <span class="bangla">@lang('header.banner.action')</span>
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
        <h3 class="bangla">@lang('story.5.title')</h3>

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
              <span class="bangla">
                <strong>@lang('story.5.items.1.bold')</strong> 
                @lang('story.5.items.1.normal')
              </span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">
                <strong>@lang('story.5.items.2.bold')</strong> 
                @lang('story.5.items.2.normal')
              </span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">
                <strong>@lang('story.5.items.3.bold')</strong> 
                @lang('story.5.items.3.normal')
              </span>
            </div>
            <a href="#pricing"
              style="background: #4154f1;padding: 8px 20px;margin-left: 30px;border-radius: 4px;color: #fff; margin-top: 30px;"
              class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
              <span class="bangla">@lang('header.banner.action')</span>
              <i class="bi bi-arrow-right text-white"></i>
            </a>
          </div>
          <!-- End Tab 1 Content -->

        </div>

      </div>

      <div class="col-lg-6">
        <img src="{{ asset('landing2/assets/image/live_tracking2.png', $hasHttps) }}" class="img-fluid" alt="">
      </div>

    </div>
    <!-- End Feature Tabs -->

    <!-- Feature Tabs 6 -->
    <div class="row feture-tabs" data-aos="fade-up">
      <div class="col-lg-6">
        <img src="{{ asset('landing2/assets/image/family_safety.png', $hasHttps) }}" class="img-fluid" alt="">
      </div>

      <div class="col-lg-6">
        <h3 class="bangla">@lang('story.6.title')</h3>

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
              <span class="bangla">
                <strong>@lang('story.6.items.1.bold')</strong>
                @lang('story.6.items.1.normal')
              </span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">
                <strong>@lang('story.6.items.2.bold')</strong>
                @lang('story.6.items.2.normal')
              </span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-check2"></i>
              <span class="bangla">
                <strong>@lang('story.6.items.3.bold')</strong>
                @lang('story.6.items.3.normal')
              </span>
            </div>

            <a href="#pricing"
              style="background: #4154f1;padding: 8px 20px;margin-left: 30px;border-radius: 4px;color: #fff; margin-top: 30px;"
              class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
              <span class="bangla">@lang('header.banner.action')</span>
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