@extends('layouts.new')

@section('content')
  <div class="row" id="app">
    <div class="col-xs-12 table-responsive">
      <company-list></company-list>
    </div>
  </div>
@endsection

@push('script')
  <script src="{{mix('js/bus/index.js', true)}}"></script>
@endpush
