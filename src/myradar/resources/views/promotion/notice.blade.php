@extends('layouts.new')

@push('style')
<style type="text/css">
  .alert-default {
    border-radius: 5px;
    border: 1px solid #eeeeee;
    background: white;
  }
</style>
@endpush

@section('title')
Due Bill SMS/Push Notice
@endsection

@section('content')
<div class="row" id="app">
  <div class="col-xs-12">
    @foreach ($counts as $via => $count)
    <div class="alert alert-default" role="alert">
      <div class="tw-mb-16 tw-flex">
        <span class="tw-flex-grow">Pending <strong>{{ strtoupper($via) }}</strong> Notifications: <strong id="{{ $via }}-count">{{ $count }}</strong></span>
        <a href="/export/due/notice/{{ $via }}" class="btn btn-info pull-right export-button tw-flex-shrink-0" data-via="{{ $via }}">
          <i class="fa fa-file-o"></i> Export
        </a>
        <button class="btn btn-success pull-right send-button tw-flex-shrink-0" style="margin: 0 20px;" data-via="{{ $via }}">
          <i class="fa fa-paper-plane"></i> Start Sending
        </button>
        <form action="/clear/due/notice" method="post" class="tw-flex-shrink-0">
          {!! csrf_field() !!}
          <input type="hidden" name="via" value="{{ $via }}">
          <button class="btn btn-default confirm" type="button">
            <i class="fa fa-times"></i>
            Clear All
          </button>
        </form>
      </div>
      <div class="progress">
        <div class="progress-bar progress-bar-success" id="progress-{{ $via }}" role="progressbar" aria-valuenow="0"
          aria-valuemin="0" aria-valuemax="100" style="width: 0%;" data-total="{{ $count }}">
          0%
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="col-xs-12">
    <form class="form" action="/send/due/notice" method="post" id="notice-form">
      {!! csrf_field() !!}
      <input type="hidden" name="via" value="" />
      <div class="col-xs-6">
        <div class="form-group">
          <label>Select Month</label>
          <select class="form-control" name="month">
            @foreach ($months as $key => $month)
            <option value="{{$month['value']}}">{{$month['label']}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-xs-6"></div>
      <div class="col-xs-12">
        <div class="form-group">
          <label for="">Message</label>
          <textarea name="message" rows="8" class="form-control" placeholder="Write SMS Content Here"></textarea>
        </div>
        <button class="btn btn-success btn-send" type="button" data-via="sms">
          <i class="fa fa-paper-plane"></i> SEND SMS
        </button>
        <button class="btn btn-primary btn-send" type="button" data-via="push">
          <i class="fa fa-bell"></i> SEND PUSH
        </button>
      </div>
    </form>
  </div>
  <div class="col-xs-12">
    <h4>Notice History</h4>
    @foreach ($history as $key => $notice)
    <div class="col-xs-12" style="margin-top: 25px;">
      <div style="display: flex; flex-direction: row; justify-content: start;">
        <strong><small>{{ $notice->created_at->toDayDateTimeString() }}</small></strong><br>
        @if ( ! is_null($notice->via))
        <span class="label label-default label-sm" style="margin-left: 15px;">{{ $notice->via }}</span>
        @endif
      </div>
      <p>{{ $notice->message }}</p>
      <div style="display: flex; flex-direction: row; justify-content: start;">
        @if ($notice->getPendingCount() != -1)
        <span class="label label-primary label-sm" style="margin-right: 10px;">Pending: {{ $notice->getPendingCount() }}</span>
        @endif
        @if ($notice->getSentCount() != -1)
        <span class="label label-success label-sm" style="margin-right: 10px;">Sent: {{ $notice->getSentCount() }}</span>
        @endif
        @if ($notice->getFailedCount() != -1)
        <span class="label label-danger label-sm">Failed: {{ $notice->getFailedCount() }}</span>
        @endif
      </div>
    </div>
    @endforeach
    {!! $history->links() !!}
  </div>
</div>
@endsection

@push('script')
<script src="{{asset('js/customer/promotion/index.js', $hasHttps)}}"></script>
<script type="text/javascript">
  var count;

    function startNoticeQueue(via) {
      $.post('/send/single/notice', {via}, function(data) {
        var progress = $('#progress-' + via)
        var count = parseInt(progress.data('total'))
        var done = count - data.remaining
        var percentage = Math.floor(done / count * 100)

        progress.attr('aria-valuenow', percentage)
        progress.css('width', percentage + '%')
        progress.text(percentage + '%')

        $('#' + via + '-count').text(data.remaining)
        if (data.remaining > 0) {
          startNoticeQueue(via)
        }
      })
    }

    $(function() {
      $('.btn-send').click(function() {
        var via = $(this).data('via');
        $('input[name="via"]').val(via);
        $('#notice-form').submit();
      })

      $('.send-button').click(function() {
        startNoticeQueue($(this).data('via'))
      })
    })
</script>
@endpush
