@extends('layouts.new')

@section('title')
  Duty Hour Report
@endsection

@section('content')
  <div class="row" id="app">
    <div class="col-xs-12">
      <input type="hidden" name="user_id" value="{{$userId}}">
      <input type="hidden" name="month" value="{{$month}}">
      <input type="hidden" name="year" value="{{$year}}">
      <button class="btn btn-default pull-right" @click="dismiss" v-show="backable">
        <i class="fa fa-arrow-left"></i> Back
      </button>
      <component :is="current" v-bind="props"></component>
    </div>
  </div>
@endsection

@push('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js" charset="utf-8"></script>
  <script src="{{ asset('js/enterprise/duty.js', $hasHttps) }}" charset="utf-8"></script>
@endpush
