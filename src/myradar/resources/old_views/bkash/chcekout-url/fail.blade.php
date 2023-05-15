@extends('layouts.bkash')

@section('content')
<div class="min-w-screen min-h-screen flex flex-row justify-center items-center">
  <div class="flex flex-col justify-center items-center space-y-8">
    <img src="/images/pay-fail.png" alt="" class="w-64 h-auto">
    <span class="text-5xl text-red-500 font-bold">
      Payment Failed
    </span>
  </div>
</div>
@endsection