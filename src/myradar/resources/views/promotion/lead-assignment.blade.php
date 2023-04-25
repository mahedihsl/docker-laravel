@extends('layouts.new')

@section('title')
Lead Assignment
@endsection

@section('content')
<div class="tw-w-full tw-flex tw-flex-col tw-space-y-12">
  
  @include('promotion.comp.lead-agent-table', [
    'id' => 'lucky_coupon_lead',
    'title' => 'Agents for Lucky Coupon Lead',
    'agents' => $couponAgents
  ])
  @include('promotion.comp.lead-agent-table', [
    'id' => 'demo_user_lead',
    'title' => 'Agents for Demo User Lead',
    'agents' => $demoAgents
  ])

</div>
@endsection

@push('script')

@endpush