@extends('layouts.bkash')

@section('content')
<div class="tw-min-w-screen tw-min-h-screen tw-flex tw-flex-col tw-justify-center tw-items-center tw-space-y-8">
  <img src="/images/myradar-logo-blue.png" alt="" class="tw-w-24 tw-h-auto tw-rounded tw-shadow-lg">
  <span class="tw-text-xl tw-text-slate-700 tw-font-semibold">myRADAR Bill Payment</span>
  <form action="/checkout-iframe/pay" method="POST" class="tw-w-10/12 md:tw-w-1/2 lg:tw-w-1/3">
    {!! csrf_field() !!}
    <div class="tw-w-full tw-flex tw-flex-col tw-items-center tw-space-y-4">
      <span class="tw-w-full tw-font-semibold tw-text-sm tw-text-gray-700">Car Number (Optional)</span>
      <input type="text"
        class="tw-w-full tw-border tw-border-solid tw-border-slate-200 tw-rounded tw-shadow-sm tw-px-4 tw-py-2 tw-text-sm tw-font-medium"
        placeholder="Ex: 11-2233" name="reg_no">

      <span class="tw-w-full tw-font-semibold tw-text-sm tw-text-gray-700 tw-mt-4">BDT Amount</span>
      <input type="number"
        class="tw-w-full tw-border tw-border-solid tw-border-slate-200 tw-rounded tw-shadow-sm tw-px-4 tw-py-2 tw-text-sm tw-font-medium"
        placeholder="Ex: 400" name="amount">
      <button type="submit"
        class="tw-w-full tw-px-4 tw-py-2 tw-rounded tw-shadow tw-border-none tw-bg-indigo-500 hover:tw-bg-indigo-600 tw-transition tw-duration-300 tw-uppercase tw-text-white tw-text-sm tw-cursor-pointer">
        Continue
      </button>
    </div>
  </form>
</div>
@endsection