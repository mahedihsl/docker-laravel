@extends('layouts.new')

@section('title')
Generators
@endsection

@section('content')
<div class="row" id="app">
  <div class="col-xs-12">
    <empty-box v-if="!generators.length" />
  </div>
  <div class="col-xs-12 col-md-4" style="display: flex; flex-direction: column; align-items: center;" v-if="generators.length">
    <div style="padding: 20px 20px;">
      <strong>Fuel Meter</strong>
    </div>
    
    <fuel-meter :value="fuel" />
  </div>
  <div class="col-xs-12 col-md-8" style="display: flex; flex-direction: column;" v-if="generators.length">
    <div
      style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; padding: 10px 20px;">
      <div>
        <strong>Fuel History</strong>
      </div>
      {{-- <div class="btn-group">
        <button class="btn" :class="{'btn-primary': chartType == 'daily', 'btn-default': chartType != 'daily'}"
          @click="chartType = 'daily'">Daily</button>
        <button class="btn" :class="{'btn-primary': chartType == 'hourly', 'btn-default': chartType != 'hourly'}"
          @click="chartType = 'hourly'">Hourly</button>
      </div> --}}
    </div>
    <fuel-graph :items="history" />
  </div>
</div>
@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js" charset="utf-8"></script>
<script src="{{ asset('js/enterprise/generator.js', true) }}" charset="utf-8"></script>
@endpush