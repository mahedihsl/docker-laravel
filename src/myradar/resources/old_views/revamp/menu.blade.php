<!-- ======= Header ======= -->
@php
$hasHttps= env('APP_ENV')=='production'
@endphp
<header id="header" class="header fixed-top">
  <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

    <a href="{{ route('welcome') }}" class="logo d-flex align-items-center">
      <img src="{{ asset('images/web_logo.png',$hasHttps) }}" alt="myRADAR logo">
      <span>myRADAR</span>
    </a>

    <nav id="navbar" class="navbar">
      <ul>
        <li><a class="@lang('misc.font') nav-link scrollto active" href="{{$base}}#hero">@lang('header.menu.home')</a></li>
        <li><a class="@lang('misc.font') nav-link scrollto" href="{{$base}}#feature">@lang('header.menu.feature')</a></li>
        <li><a class="@lang('misc.font') nav-link scrollto" href="{{$base}}#pricing">@lang('header.menu.service')</a></li>
        <li><a class="@lang('misc.font') nav-link scrollto" href="{{$base}}#mobile">@lang('header.menu.app')</a></li>
        <li><a class="@lang('misc.font') nav-link scrollto" href="{{$base}}#pricing">@lang('header.menu.package')</a></li>
        <li><a class="@lang('misc.font') nav-link scrollto" href="{{ route('login', ['demo' => 'yes']) }}">@lang('header.menu.demo')</a></li>
        <li>
          <a class="nav-link scrollto" href="{{$base}}#contact">
            <img src="{{ asset('images/phone-call.svg') }}" class="animate__animated animate__heartBeat animate__infinite"
              alt="" style="width: 24px;" />
            <span class="@lang('misc.font')" style="margin-left: 12px;">@lang('header.menu.phone')</span>
          </a>
        </li>
        <li><a class="getstarted scrollto @lang('misc.font')" style="justify-content: center" href="{{ route('login') }}">@lang('header.menu.login')</a></li>
        <li>
          <div class="language-switcher">
            <a href="{{ route('welcome', ['lang' => 'bn']) }}" class="language bangla {{ App::isLocale('bn') ? 'active' : '' }}">বাংলা</a>
            <a href="{{ route('welcome', ['lang' => 'en']) }}" class="language {{ App::isLocale('en') ? 'active' : '' }}">Eng</a>
          </div>
        </li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->

  </div>
</header><!-- End Header -->
