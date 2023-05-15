@extends('layouts.new')

@section('title')
Campaign Leads
@endsection

@section('content')
<div class="tw-w-full tw-flex tw-flex-col tw-gap-y-5">
  <div class="tw-w-full tw-flex tw-flex-row tw-justify-between tw-items-start">
    <form action="/leads" method="get" class="tw-w-full tw-flex tw-flex-row tw-items-center tw-gap-x-4">
      <select name="type" class="tw-w-1/4 form-control">
        <option value="">Select Lead Type</option>
        <option value="demo_user_lead" {{ $type=='demo_user_lead' ? 'selected' : '' }}>Android demo user lead</option>
        <option value="lucky_coupon_lead" {{ $type=='lucky_coupon_lead' ? 'selected' : '' }}>Lucky coupon lead</option>
        <option value="message_lead" {{ $type=='message_lead' ? 'selected' : '' }}>Web message lead</option>
        <option value="hsl_message" {{ $type=='hsl_message' ? 'selected' : '' }}>HSL website message</option>
      </select>
      @php
      $agents = ['Masud', 'Hasib', 'Wahida', 'Ahnaf', 'Shahadat', 'Rubel', 'Agent 1', 'Agent 2']
      @endphp
      <select name="agent" class="form-control tw-w-1/4">
        <option value="">Select Agent</option>
        @foreach ($agents as $a)
        <option value="{{ $a }}" {{ $agent==$a ? 'selected' : '' }}>{{ $a }}</option>
        @endforeach
      </select>
      <button type="submit" class="btn btn-primary">
        <i class="fa fa-search"></i> Filter
      </button>
      <a href="/leads" class="btn btn-default">
        <i class="fa fa-times"></i> Clear
      </a>
    </form>

    @if (Auth::user()->type == 1)
    <a href="/lead/assignment" target="_blank"
      class="tw-block tw-shrink-0 tw-rounded tw-bg-white hover:tw-bg-gray-200 tw-transition tw-duration-300 tw-border tw-border-solid tw-border-blue-500 tw-px-6 tw-py-3 tw-text-xl tw-text-blue-600 tw-font-medium">
      Lead Assignment
    </a>
    @endif

  </div>
  @foreach ($leads as $lead)
  @include('promotion.lead-box', ['lead' => $lead])
  @endforeach

  {!! $leads->appends(request()->input())->links() !!}
</div>
@endsection

@push('script')

@endpush