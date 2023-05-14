@extends('layouts.new')

@push('style')
<style media="screen">
    .info-boxx {
        background: white;
        border-radius: 4px;
        min-height: 260px;
        margin-top: 20px;
        border: 1px solid #E0E0E0;
        box-shadow: 0 3px 6px rgba(0,0,0,0.10), 0 6px 12px rgba(0,0,0,0.16);
    }
    .info-boxx .box-title {
        font-size: 15px;
        font-weight: bold;
        color: #616161;
        padding: 6px 0;
    }
    .info-boxx > .content {
        width: 100%;
        height: auto;
        margin: auto;
        display: block;
    }
    .info-boxx .full-width {
        width: 100%;
        display: block;
    }
    .text-main {
        font-size: 16px;
        font-weight: bold;
        /*color: #212121;*/
    }
    .icon-main {
        display: block;
        margin: 20px auto;
        width: 60px;
        height: 60px;
    }
    .btn-action {
        background: white;
        border-radius: 5px;
        display: block;
        margin: 15px auto;
    }
    .action-blue {
        border: 1px solid #2196F3;
        color: #1976D2;
    }
    .action-blue:hover {
        background: #EEEEEE;
        border: 1px solid #2196F3;
        color: #1976D2;
    }
    .action-green {
        border: 1px solid #4CAF50;
        color: #388E3C;
    }
    .action-orange {
        border: 1px solid #FF9800;
        color: #F57C00;
    }
    .action-purple {
        border: 1px solid #9C27B0;
        color: #7B1FA2;
    }
    .btn-purple:hover {
        color: white;
        background: #9C27B0;
        border: 1px solid #7B1FA2;
    }
    .btn-orange:hover {
        color: white;
        background: #FF9800;
        border: 1px solid #F57C00;
    }
    .chart-box {
        width: 100%;
        display: block;
        margin: 15px auto;
    }
    .raw-canvas {
        display: block;
        margin: 0 auto;
    }
    .v-space {
        margin: 20px 0;
    }
    .large-box {
        min-height: 300px;
    }

    .select-style {
        margin-top: 10px;
        border: 1px solid #ccc;
        width: 120px;
        border-radius: 3px;
        overflow: hidden;
        background: #fafafa url("data:image/png;base64,R0lGODlhDwAUAIABAAAAAP///yH5BAEAAAEALAAAAAAPABQAAAIXjI+py+0Po5wH2HsXzmw//lHiSJZmUAAAOw==") no-repeat 90% 50%;
    }

    .select-style select {
        cursor: pointer;
        padding: 5px 8px;
        width: 130%;
        border: none;
        box-shadow: none;
        background: transparent;
        background-image: none;
        -webkit-appearance: none;
    }

    .select-style select:focus {
        outline: none;
    }
</style>
@endpush

@section('content')
  <input type="hidden" name="car_id" value="{{$car_id}}">
  <input type="hidden" name="device_id" value="{{$device_id}}">
  <div id="app">
    <div class="row">
      <engine></engine>
      <fuel></fuel>
      <gas></gas>
    </div>
    <div class="row">
      <fuel-chart></fuel-chart>
      <gas-view></gas-view>
    </div>
    <div class="row">
      <mileage></mileage>
    </div>
  </div>
@endsection

@push('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js" charset="utf-8"></script>
  <script src="{{ asset('js/customer/service.js') }}" charset="utf-8"></script>
@endpush
