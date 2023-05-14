@extends('layouts.tracker')

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <input type="hidden" name="user_id" value="{{$user->id}}">
      <div style="width: 100%; height: 500px;" id="map"></div>
    </div>
  </div>
@endsection

@push('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAf9yCy5ZZ6iEo0EyOWjUg4EpUHIeuZVWQ&libraries=geometry"></script>
<script src="{{ asset('js/customer/tracker.js') }}" charset="utf-8"></script>
@endpush
