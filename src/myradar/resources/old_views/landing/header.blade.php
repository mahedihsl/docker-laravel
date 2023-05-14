<div class="header-content">

    @include('landing.eheater')

    <!-- .container -->
    <div class="container">

        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 mt-8">
                <div class="owl-carousel">
                    <div>
                        <img src="{{ asset('images/features/vts.png', true) }}" alt="" class="img-rounded">
                        <h4 class="text-center">Track &amp; Relax</h4>
                    </div>
                    <div>
                        <img src="{{ asset('images/features/remote-car-lock.gif', true) }}" alt="" class="img-rounded">
                        <h4 class="text-center">Remote Lock</h4>
                    </div>
                    <div>
                        <img src="{{ asset('images/features/remote-car-refueling.gif', true) }}" alt="" class="img-rounded">
                        <h4 class="text-center">Fuel &amp; Gas Monitor</h4>
                    </div>
                    <div>
                        <img src="{{ asset('images/features/remote-lock-geo-fence.png', true) }}" alt="" class="img-rounded">
                        <h4 class="text-center">Theft Protection</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="header-txt">
            <h1>Meet Bestapp for mobile chat</h1>
        </div> --}}

        {{-- <div class="header-btn">
            <a href="#download" class="btn-custom btn-icon "><i class="ion ion-ios-cloud-download-outline"></i> Download App</a>
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
