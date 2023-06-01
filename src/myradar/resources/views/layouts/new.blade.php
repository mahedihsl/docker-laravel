@php
$hasHttps= env('APP_ENV')=='production'
@endphp
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name') }}</title>

  <link rel="shortcut icon" href="{{ asset('images/favicon.ico', $hasHttps) }}">
  <link rel="apple-touch-icon" href="{{ asset('landing/images/apple-touch-icon.png', $hasHttps) }}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('landing/images/apple-touch-icon-72x72.png', $hasHttps) }}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('landing/images/apple-touch-icon-114x114.png', $hasHttps) }}">


  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('vendors/Ionicons/css/ionicons.min.css', $hasHttps) }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css', $hasHttps) }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('css/skins/_all-skins.min.css', $hasHttps) }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <link rel="stylesheet" href="{{ asset('vendors/toastr/toastr.min.css', $hasHttps) }}">
  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.6.1/tailwind.min.css"> --}}
  <link rel="stylesheet" href="{{ asset('css/app.css', $hasHttps) }}">
  <link rel="stylesheet" href="{{ asset('css/tailwind.css', $hasHttps) }}">
  @stack('style')
  <!-- Scripts -->
  <script>
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};

  </script>
</head>

<body class="hold-transition skin-blue-light sidebar-mini">
  <div class="wrapper">

    @php
    $user = Auth::user();
    @endphp

    @include('partial.topbar', ['user' => $user])

    @include('partial.sidebar', ['user' => $user])

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      {{-- <section class="content-header">
          <h1>
            Blank page
            <small>it all starts here</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
          </ol>
        </section> --}}

      <!-- Main content -->
      <section class="content container-fluid">

        <!-- Default box -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">@yield('title')</h3>

            <div class="box-tools pull-right">
              @yield('action')
              {{-- <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> --}}
            </div>
          </div>
          <div class="box-body">
            @yield('content')
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            @yield('footer')
          </div>
          <!-- /.box-footer-->
        </div>
        <!-- /.box -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('partial.footer', ['user' => $user])

    <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    {{-- add session flash mesages --}}
    <input type="hidden" name="toast" value="{{session('msg')}}" data-type="{{session('type')}}">
  </div>
  <!-- ./wrapper -->

  <!-- jQuery 3 -->
  {{-- <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
     --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </script>
  <!-- Bootstrap 3.3.7 -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- FastClick -->
  <script src="{{asset('vendors/fastclick/lib/fastclick.js', $hasHttps)}}"></script>
  <!-- Sparkline -->
  <script src="{{asset('vendors/jquery-sparkline/dist/jquery.sparkline.min.js', $hasHttps)}}"></script>
  <!-- SlimScroll -->
  <script src="{{asset('vendors/jquery-slimscroll/jquery.slimscroll.min.js', $hasHttps)}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('js/adminlte.min.js', $hasHttps)}}"></script>
  <script src="{{asset('vendors/toastr/toastr.min.js', $hasHttps)}}" charset="utf-8"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('js/demo.js', $hasHttps)}}"></script>
  <script src="{{asset('js/common.js', $hasHttps)}}" charset="utf-8"></script>
  <script>
    $(document).ready(function () {
    $('.sidebar-menu').tree()
    $('.trigger-upload').click(function(event) {
      var target = $(this).data('target')
      $('#' + target).click()
    })
  })
  </script>

  @stack('script')
</body>

</html>