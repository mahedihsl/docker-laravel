@extends('layouts.new')

@push('style')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
  <link rel="stylesheet" href="{{ asset('vendors/datetimepicker/build/jquery.datetimepicker.min.css', true) }}">
  <link rel="stylesheet" href="{{asset('vendors/time/include/ui-1.10.0/ui-lightness/jquery-ui.css', true)}}">
  <link rel="stylesheet" href="{{asset('vendors/time/jquery.ui.timepicker.css', true)}}">
@endpush

@section('title')
  Manage Drivers
@endsection

@section('content')
  <div class="row" id="app">
    <div class="col-xs-12">
      <input type="hidden" name="user_id" value="{{$userId}}">
      <input type="hidden" name="previous" value="{{$previous}}">
      <component :is="current" v-bind="props"></component>
    </div>
  </div>
@endsection

@push('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
  <script src="{{asset('js/moment.min.js', true)}}" charset="utf-8"></script>
  <script src="{{asset('vendors/time/include/ui-1.10.0/jquery.ui.core.min.js', true)}}"></script>
  <script src="{{asset('vendors/datetimepicker/build/jquery.datetimepicker.full.min.js', true)}}"></script>
  <script src="{{asset('vendors/time/jquery.ui.timepicker.js', true)}}"></script>
  <script src="{{ asset('js/enterprise/driver.js', true) }}" charset="utf-8"></script>
  <script type="text/javascript">
    $(function() {
      $('div.box-header').css('background', '#3c8dbc').css('color', '#ffffff');
    });
  </script>
@endpush
