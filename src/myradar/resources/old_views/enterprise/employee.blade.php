@extends('layouts.new')

@push('style')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
@endpush

@section('title')
  Manage Employees
@endsection

@section('content')
  <div class="row" id="app">
    <div class="col-xs-12">
      <input type="hidden" name="user_id" value="{{$userId}}">
      <component :is="current" v-bind="props"></component>
    </div>
  </div>
@endsection

@push('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
  <script src="{{ asset('js/enterprise/employee.js', true) }}" charset="utf-8"></script>
  <script type="text/javascript">
    $(function() {
      $('div.box-header').css('background', '#3c8dbc').css('color', '#ffffff');
    });
  </script>
@endpush
