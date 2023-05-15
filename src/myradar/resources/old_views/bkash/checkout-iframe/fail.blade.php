@extends('layouts.bkash')

@section('content')
<div class="tw-min-w-screen tw-min-h-screen tw-flex tw-flex-row tw-justify-center tw-items-center">
  <div class="tw-flex tw-flex-col tw-justify-center tw-items-center tw-space-y-8">
    <img src="/images/pay-fail.png" alt="" class="tw-w-64 tw-h-auto">
    <span class="tw-text-5xl tw-text-red-500 tw-font-bold">
      Payment Failed
    </span>
    <span class="tw-text-xl tw-text-gray-800 tw-font-medium">
      {{ $message }}
    </span>
  </div>
</div>
@endsection