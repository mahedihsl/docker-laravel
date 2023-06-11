@extends('layouts.bkash')

@section('content')
<div class="min-w-screen min-h-screen flex flex-row justify-center items-center">
  <div class="flex flex-col justify-center items-center space-y-8">
    <img src="/images/pay-fail.png" alt="" class="w-64 h-auto">
    <span class="text-5xl text-red-500 font-bold">
      Payment Failed
    </span>
  
    @if(isset($message))
    <span class="text-xl text-red-400 font-semibold">{{ $message }}</span>
    @endif

    <div class="text-center">
      <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-800 text-white rounded shadow-md"><a href="{{ route('url-amount', $uid) }}">Try Again</a></button>  
  </div>
  </div>
</div>
@endsection