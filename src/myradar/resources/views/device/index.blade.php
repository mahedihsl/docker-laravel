@extends('layouts.new')

@push('style')
  <link rel="stylesheet" href="{{asset('vendors/buttons/buttons.min.css', $hasHttps)}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
@endpush

@section('title')
    Manage Devices
@endsection

@section('action')
    <a href="{{ route('bind.history') }}" class="btn btn-link">
      <i class="fa fa-history"></i> Bind History
    </a>
@endsection

@section('content')
  <div id="app">
    <new-device></new-device>
    <recent-devices></recent-devices>
  </div>
@endsection

@push('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
  <script src="https://unpkg.com/tippy.js/dist/tippy.all.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
  <script src="{{ asset('js/device/index.js', $hasHttps) }}" charset="utf-8"></script>
@endpush
