@extends('layouts.new')

@section('title')
  Promo Schemes
@endsection



@section('content')
  <div class="row" id="app">
    <div class="col-xs-12">
      <promo-scheme> </promo-scheme>
    </div>
  </div>
@endsection

@push('script')
  <script src="{{asset('js/customer/promotion/index.js', true)}}"></script>
@endpush
