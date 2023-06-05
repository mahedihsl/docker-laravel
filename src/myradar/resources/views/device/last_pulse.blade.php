@extends('layouts.new')
@php
$hasHttps= env('APP_ENV')=='production'
@endphp

@push('style')

@endpush

@section('content')
  <div id="app">
    <input type="hidden" name="day" value="{{$day}}">
    <div class="col-xs-12 col-md-3">
      <selector></selector>
    </div>
    <div class="col-xs-12 col-md-6">
      <perf-chart></perf-chart>
    </div>
    <div class="col-xs-12 col-md-8 col-md-offset-2">
      <device-list></device-list>
    </div>
  </div>
@endsection

@push('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js" charset="utf-8"></script>
  <script src="{{ asset('js/device/last_pulse.js', $hasHttps) }}" charset="utf-8"></script>
@endpush
