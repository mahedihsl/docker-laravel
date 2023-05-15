<div class="tw-rounded-lg tw-w-full tw-flex tw-flex-row tw-justify-start tw-items-start tw-px-8 tw-py-5 tw-bg-gray-100">
  <div class="tw-flex tw-flex-col tw-gap-y-2 tw-w-6/12">
    <span class="tw-text-gray-700 tw-font-semibold tw-text-2xl">{{ $lead->name }}</span>
    <div class="tw-flex tw-flex-row tw-gap-x-8">
      <span class="tw-text-gray-700 tw-text-2xl tw-font-medium">
        <i class="fa fa-phone"></i> {{ $lead->phone or '--' }}
      </span>
      <span class="tw-text-gray-700 tw-text-2xl tw-font-medium">
        <i class="fa fa-envelope"></i> {{ $lead->email or '--' }}
      </span>
    </div>
    <p class="tw-text-2xl tw-text-gray-600 tw-font-normal tw-mt-2">
      @if (!$lead->message)
      <span class="tw-italic tw-text-gray-500">No message</span>
      @else
      {{ $lead->message }}
      @endif
    </p>
  </div>

  <div class="tw-flex tw-flex-col tw-gap-y-2 tw-w-3/12">
    <span class="tw-text-gray-700 tw-text-xl tw-font-medium">
      <i class="fa fa-calendar tw-mr-2"></i> {{ $lead->created_at->toDayDateTimeString() }}
    </span>
    <span class="tw-text-gray-700 tw-text-xl tw-font-semibold">
      <i class="fa fa-certificate tw-mr-2"></i> {{ $lead->getTypeLabel() }}
    </span>
    @if ($lead->type == 'lucky_coupon_lead')
    <span class="tw-text-gray-700 tw-text-xl tw-font-semibold">
      <i class="fa fa-gift tw-mr-2"></i>
      Code - {{ $lead->meta['code'] }}
      ({{ $lead->meta['discount'] }}% Discount)
      @if ($lead->meta['notified'])
      <span class="tw-text-green-500"><i class="fa fa-check"></i> SMS SENT</span>
      @endif
    </span>
    @elseif($lead->type == 'demo_user_lead')
    <span class="tw-text-gray-700 tw-text-xl tw-font-semibold">
      <i class="fa fa-key tw-mr-2"></i>
      OTP: {{ $lead->meta['otp'] }}
    </span>
    @endif
  </div>

  <div class="tw-w-3/12">
    @php
    $agent = isset($lead->meta['agent']) ? $lead->meta['agent'] : null;
    @endphp
    <span>
      Agent:
      @if ($agent)
      <strong>{{ $agent['name'] }} ({{ $agent['phone'] }})</strong>
      @else
      <strong>N/A</strong>
      @endif

    </span>
  </div>
</div>