@php
$hasHttps= env('APP_ENV')=='production'
@endphp

@extends('layouts.new')
@push('style')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
@endpush
@section('content')
  <div class="row" id="app">
    <div class="col-md-12">
      <h5>
        <strong>@{{title}}</strong>
        <button v-show="!current" class="btn btn-primary pull-right" @click="changeView(1)">
          <i class="fa fa-plus"></i> New Customer
        </button>
        <button v-show="!current" class="btn btn-primary pull-right" @click="sendPaymentMessage()" style="margin-right:4px">
          <i class="fa "></i> Payment SMS
        </button>
        <button v-show="!current" class="btn btn-primary pull-right" @click="sendPaymentMethod()" style="margin-right:4px">
          <i class="fa "></i> Payment Method
        </button>
        <button v-show="current" class="btn btn-default pull-right" @click="changeView(0)">
          <i class="fa fa-arrow-left"></i> Back
        </button>
      </h5>
      <hr class="divider">
      <component :is="currentView"></component>
    </div>
  </div>
@endsection

@push('script')
<script src="{{ asset('js/customer/index.js', $hasHttps) }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endpush
