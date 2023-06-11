<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hyper Systems') }}</title>

    <!-- Styles -->
    <!-- Bootstrap -->
    <link href="{{asset('vendors/bootstrap/dist/css/bootstrap.min.css', $hasHttps)}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- NProgress -->
    <link href="{{ asset('vendors/nprogress/nprogress.css', $hasHttps) }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('vendors/iCheck/skins/flat/green.css', $hasHttps) }}" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{ asset('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css', $hasHttps) }}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ asset('vendors/jqvmap/dist/jqvmap.min.css', $hasHttps) }}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    {{-- <link href="{{asset('vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet"> --}}
    <link href="{{ asset('css/datepicker.min.css', $hasHttps) }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('build/css/custom.min.css', $hasHttps) }}" rel="stylesheet">
    <link href="{{ asset('css/app.css', $hasHttps) }}" rel="stylesheet">

    @yield('css')

    <!-- Scripts -->
    <script>
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};

        </script>
</head>
<body class="nav-md">
    <div id="app" class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="/" class="site_title"> <span>HyperWare</span></a>
                        <a href="/login" class="btn btn-primary"> <i class="fa fa-arrow-circle-left fa-1x"></i></i></a>

                    </div>
                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">

                        </div>

                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                        <!-- /sidebar menu -->

                        <!-- /menu footer buttons -->

                        <!-- /menu footer buttons -->
                    </div>
                </div>

                <!-- top navigation -->

                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">
                    @yield('content')
                </div>
                <!-- /page content -->

                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        Hyper Wear - @2017 All Right Reserved<a href="http://hypersystems.com.bd">Hyper Systems</a>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>

        </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <script src="{{asset('vendors/bootstrap/dist/js/bootstrap.min.js', $hasHttps)}}"></script>
    <!-- FastClick -->
    <script src="{{asset('vendors/fastclick/lib/fastclick.js', $hasHttps)}}"></script>
    <!-- NProgress -->
    <script src="{{asset('vendors/nprogress/nprogress.js', $hasHttps)}}"></script>
    <!-- Chart.js -->
    <script src="{{asset('vendors/Chart.js/dist/Chart.min.js', $hasHttps)}}"></script>
    <!-- gauge.js -->
    <script src="{{asset('vendors/gauge.js/dist/gauge.min.js', $hasHttps)}}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js', $hasHttps)}}"></script>
    <!-- iCheck -->
    <script src="{{asset('vendors/iCheck/icheck.min.js', $hasHttps)}}"></script>
    <!-- Skycons -->
    <script src="{{asset('vendors/skycons/skycons.js', $hasHttps)}}"></script>
    <!-- Flot -->
    <script src="{{asset('vendors/Flot/jquery.flot.js', $hasHttps)}}"></script>
    <script src="{{asset('vendors/Flot/jquery.flot.pie.js', $hasHttps)}}"></script>
    <script src="{{asset('vendors/Flot/jquery.flot.time.js', $hasHttps)}}"></script>
    <script src="{{asset('vendors/Flot/jquery.flot.stack.js', $hasHttps)}}"></script>
    <script src="{{asset('vendors/Flot/jquery.flot.resize.js', $hasHttps)}}"></script>
    <!-- Flot plugins -->
    <script src="{{asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js', $hasHttps)}}"></script>
    <script src="{{asset('vendors/flot-spline/js/jquery.flot.spline.min.js', $hasHttps)}}"></script>
    <script src="{{asset('vendors/flot.curvedlines/curvedLines.js', $hasHttps)}}"></script>
    <!-- DateJS -->
    <script src="{{asset('vendors/DateJS/build/date.js', $hasHttps)}}"></script>
    <!-- JQVMap -->
    <script src="{{asset('vendors/jqvmap/dist/jquery.vmap.js', $hasHttps)}}"></script>
    <script src="{{asset('vendors/jqvmap/dist/maps/jquery.vmap.world.js', $hasHttps)}}"></script>
    <script src="{{asset('vendors/jqvmap/examples/js/jquery.vmap.sampledata.js', $hasHttps)}}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{asset('vendors/moment/min/moment.min.js', $hasHttps)}}"></script>
    {{-- <script src="{{asset('vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script> --}}
    <script src="{{asset('js/datepicker.min.js', $hasHttps)}}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{asset('build/js/custom.min.js', $hasHttps)}}"></script>
    <script src="{{asset('js/common.js', $hasHttps)}}" charset="utf-8"></script>
    @yield('js')
</body>
</html>
