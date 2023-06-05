@php
$hasHttps= env('APP_ENV')=='production'
@endphp

@extends('layouts.new')

@section('title')
  Complains
@endsection



@section('content')

  <div class="row" id="app">
		<input type="hidden" name="count_inv" value="{{ $count['inv'] }}">
		<input type="hidden" name="count_opn" value="{{ $count['opn'] }}">
		<input type="hidden" name="count_cls" value="{{ $count['cls'] }}">
		<input type="hidden" name="count_rsl" value="{{ $count['rsl'] }}">
		<input type="hidden" name="count_rep" value="{{ $count['rep'] }}">
		<input type="hidden" name="count_reo" value="{{ $count['reo'] }}">
      <div class="col-md-3">
          <side-bar> </side-bar>
      </div>
      <div class="col-md-9">
          <component :is="currentView"></component>
      </div>
  </div>
@endsection

@push('script')
  <script src="{{asset('js/service/complain/index.js', $hasHttps)}}"></script>
@endpush
