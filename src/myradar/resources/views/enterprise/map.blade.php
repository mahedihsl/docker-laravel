@extends('layouts.new')

@section('title')
  Map Search
@endsection

@section('content')
  <div class="row" id="app">
    <div class="col-xs-12">
      <input type="hidden" name="user_id" value="{{$user->id}}">
      <map-view></map-view>
    </div>
  </div>
@endsection

@push('script')
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAf9yCy5ZZ6iEo0EyOWjUg4EpUHIeuZVWQ&libraries=geometry"></script>
  <script src="{{asset('js/moment.min.js', true)}}" charset="utf-8"></script>
  <script src="{{asset('js/markerwithlabel.min.js', true)}}" charset="utf-8"></script>
  <script src="https://js.pusher.com/4.0/pusher.min.js"></script>
  <script src="{{asset('js/enterprise/map.js', true)}}" charset="utf-8"></script>
  <script type="text/javascript">
    $(function() {
      $('div.box-header').css('background', '#0095BF').css('color', '#ffffff');
    });
  </script>
@endpush
