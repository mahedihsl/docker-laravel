@extends('layouts.new')

@push('style')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
  <link rel="stylesheet" href="{{ asset('vendors/datetimepicker/build/jquery.datetimepicker.min.css', $hasHttps) }}">
  <link rel="stylesheet" href="{{asset('vendors/time/include/ui-1.10.0/ui-lightness/jquery-ui.css', $hasHttps)}}">
  <link rel="stylesheet" href="{{asset('vendors/time/jquery.ui.timepicker.css', $hasHttps)}}">
  <link rel="stylesheet" href="{{ asset('css/material-switch.css', $hasHttps) }}">
  <link rel="stylesheet" href="{{ asset('css/simple.css', $hasHttps) }}">
  <style media="screen">
  .list-group-item {
      border: none;
  }
  .control-panel {
      margin-bottom: 20px;
  }
  .disabler {
      width: 100%;
      height: 100%;
      position: absolute;
      background: rgba(255, 255, 255, 0.6);
      z-index: 10;
  }

  .speed-factor-panel {
      border-bottom: 1px solid #E0E0E0;
      border-left: 1px solid #E0E0E0;
  }
  .speed-factor {
      border-top:  1px solid #E0E0E0;
      border-left:  1px solid #E0E0E0;
      border-right:  1px solid #E0E0E0;
      text-align: center;
      color: #FFFFFF;
      font-weight: bold;
      position: relative;
      bottom: 0;
  }
  .btn-time {
      position: relative;
      top: -62%;
      left: 46%;
  }
  .playback {
        position: absolute;
        top: 10px;
        left: 20px;
        color: #9E9E9E;
        font-weight: bold;
        font-size: 14px;
    }
    .track-mode {
      font-size: 16px;
      color: #2E7D32;
    }
    .map-clock {
      position: absolute;
      top: 10px;
      left: 50%;
      transform: translateX(-50%);
      background: white;
      padding: 4px 10px;
      font-size: 13px;
      color: #3F51B5;
      box-shadow: 0 5px 15px -5px rgba(0,0,0,0.506);
    }
    .warning-header {
      font-size: 24px;
      font-weight: normal;
      color: #F44336;
    }
    .switch-panel {
      visibility: hidden;
    }
  </style>
@endpush

@section('content')
  <div class="row">
    <div class="col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-1">
      <form class="form" id="car-chooser" method="get" action="{{route('car-tracking')}}">
        <div class="form-group">
          <label>Choose Car</label>
          <select class="form-control" name="device_id" data-cache="{{$device}}">
          </select>
        </div>
      </form>
    </div>
    <input type="hidden" name="current_device" value="{{$device}}" data-status="{{$subscribed}}"/>
    <div class="col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-1 switch-panel">
      <ul class="list-group">
        <li class="list-group-item">
          <strong id="track-type" class="track-mode">Live Tracking</strong>
          <div class="material-switch pull-right">
            <input id="live" name="live" type="checkbox"/>
            <label for="live" class="label-success"></label>
          </div>
        </li>
      </ul>
    </div>
  </div>

  <div class="row control-panel" id="control_panel">
    <div class="col-xs-12 col-md-4 col-md-offset-1">
      <div class="form">
        <div class="col-xs-12">
          <div class="form-group">
            <label for="datetimepicker1">Select Date</label>
            <input type="text" class="form-control" id="date"/>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label for="time1">From</label>
            <input type="text" class="form-control" id="time1"/>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label for="time2">To</label>
            <input type="text" class="form-control" id="time2"/>
          </div>
        </div>
        <div class="col-xs-12">
          <button type="button" class="btn btn-primary btn-block" id="filter">
            <i id="btn_history" class="fa fa-search"></i> Show History
          </button>
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-md-4 col-md-offset-1 speed-factor-panel">
      <span class="playback">Playback Speed</span>
      <div class="col-xs-2 col-xs-offset-1 speed-factor pull-down" data-height="60" data-bg="#66BB6A" data-factor="10" style="margin-top: 145px">
        1 X <br> <i class="fa fa-check"></i>
      </div>
      <div class="col-xs-2 col-xs-offset-1 speed-factor pull-down" data-height="90" data-bg="#26C6DA" data-factor="20" style="margin-top: 115px">
        2 X <br> <i class="fa fa-check"></i>
      </div>
      <div class="col-xs-2 col-xs-offset-1 speed-factor pull-down" data-height="130" data-bg="#7E57C2" data-factor="40" style="margin-top: 75px">
        4 X <br> <i class="fa fa-check"></i>
      </div>
      <div class="col-xs-2 col-xs-offset-1 speed-factor pull-down" data-height="180" data-bg="#26A69A" data-factor="100" style="margin-top: 25px">
        Fast <br> <i class="fa fa-check"></i>
      </div>
    </div>
  </div>

  <input type="hidden" name="user_id" value="{{$user->id}}">
  <div style="width: 100%; height: 500px; position: relative; display: none;" id="map_view">
    <div style="width: 100%; height: 500px;" id="map"></div>
    <span class="map-clock" id="map_clock">
      <i class="fa fa-clock-o"></i> <strong>--:--</strong>
    </span>
  </div>
  <div style="width: 100%; height: 500px; position: relative; display: none;" id="error_view">
    <div class="row">
      <div class="col-xs-12" style="padding: 60px 0;">
        <h3 class="text-center warning-header">
          <img src="{{asset('images/ic_message.png')}}" alt="" class="img center-block"/>
          {{-- <i class="fa fa-meh-o"></i><br> --}}
          This car is not subscribed for Tracking
        </h3>
      </div>
    </div>
  </div>
  <button type="button" id="timestamp" class="bttn-simple bttn-sm bttn-primary btn-time" style="display: none;">Time</button>
@endsection

@push('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAf9yCy5ZZ6iEo0EyOWjUg4EpUHIeuZVWQ&libraries=geometry"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="{{asset('js/moment.min.js', $hasHttps)}}" charset="utf-8"></script>
<script src="{{asset('vendors/time/include/ui-1.10.0/jquery.ui.core.min.js', $hasHttps)}}"></script>
<script src="{{asset('vendors/datetimepicker/build/jquery.datetimepicker.full.min.js', $hasHttps)}}"></script>
<script src="{{asset('vendors/time/jquery.ui.timepicker.js', $hasHttps)}}"></script>

<script src="https://js.pusher.com/4.0/pusher.min.js"></script>
<script type="text/javascript">
google.maps.LatLng.prototype.distanceFrom = function (newLatLng) {
    var EarthRadiusMeters = 6378137.0; // meters
    var lat1 = this.lat();
    var lon1 = this.lng();
    var lat2 = newLatLng.lat();
    var lon2 = newLatLng.lng();
    var dLat = (lat2 - lat1) * Math.PI / 180;
    var dLon = (lon2 - lon1) * Math.PI / 180;
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return EarthRadiusMeters * c;
}
</script>
<script src="{{ asset('js/position/live.js', $hasHttps) }}" charset="utf-8"></script>
<script type="text/javascript">

$(function() {
    user_id = $('input[name="user_id"]').val();
    $('#date').datetimepicker({
        timepicker: false,
        format:'j M Y'
    });
    $('#time1').timepicker();
    $('#time2').timepicker();
});
</script>

@endpush
