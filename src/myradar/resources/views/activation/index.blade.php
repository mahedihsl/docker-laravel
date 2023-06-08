@extends('layouts.new')

@push('style')
<link rel="stylesheet" href="{{ asset('vendors/datetimepicker/build/jquery.datetimepicker.min.css', true) }}">
@endpush

@section('content')
<div class="col-xs-12 col-md-5">
  <form class="form" action="/activation/export" method="post">
    {!! csrf_field() !!}
    <div class="col-xs-4 col-md-4">
      <div class="form-group">
        <label>From Date</label>
        <input type="text" class="form-control date-picker" placeholder="" name="from">
      </div>
    </div>
    <div class="col-xs-4 col-md-4">
      <div class="form-group">
        <label>To Date</label>
        <input type="text" class="form-control date-picker" placeholder="" name="to">
      </div>
    </div>
    <div class="col-xs-4 col-md-4">
      <button type="submit" class="btn btn-primary" style="margin: 25px 0;">
        <i class="fa fa-file-o"></i> Export
      </button>
    </div>
  </form>
</div>
<div class="col-xs-12 col-md-7">
  <form class="form" action="/activation/batch/disable" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="file" name="blacklist" style="display: none" id="upload-blacklist" />
    <div style="width: 100%; display: flex; flex-direction: row; justify-content: space-between; align-items: center; padding: 10px 15px; border: 1px solid #eeeeee; border-radius: 4px;">
      <div>
        <p>
          <strong>Batch Disable User Account by Car Number</strong> <br>
          @if ($disable_count > 0)
            <strong class="text-success">{{ $disable_count }} account(s) disabled</strong>
          @else
            <span>Column name should be: <strong>reg_no</strong> (case sensitive)</span>
          @endif
        </p>
      </div>
      <div>
        <button type="button" class="btn btn-default trigger-upload" style="flex-shrink: 0;" data-target="upload-blacklist">
          <i class="fa fa-file-excel-o"></i>
          Upload Excel
        </button>
        <button type="submit" class="btn btn-primary" style="flex-shrink: 0;">
          <i class="fa fa-paper-plane-o"></i>
          Submit
        </button>
      </div>
    </div>
  </form>
</div>
<div class="col-xs-12 table-responsive">
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th class="col-xs-1 text-center">SL</th>
        <th class="col-xs-2 text-center">User</th>
        <th class="col-xs-1 text-center">Phone</th>
        <th class="col-xs-1 text-center">Key</th>
        <th class="col-xs-1 text-center">Com. ID</th>
        <th class="col-xs-2 text-center">IMEI</th>
        <th class="col-xs-1 text-center">Car No.</th>
        <th class="col-xs-1 text-center">Enabled</th>
        <th class="col-xs-2 text-center">Date</th>
      </tr>
    </thead>
    <tbody>
      @php
      $start = ($items->perPage() * ($items->currentPage()-1)) + 1;
      @endphp
      @foreach ($items as $key => $item)
      <tr>
        <td class="text-center">{{$start + $key}}</td>
        <td class="text-center">
          {{$item->car->user->name}}
        </td>
        <td class="text-center">
          {{$item->car->user->phone}}
        </td>
        <td class="text-center"><strong>{{$item->key}}</strong></td>
        <td class="text-center">{{$item->car->device->com_id or 'N/A'}}</td>
        <td class="text-center">{{$item->car->device->imei or 'N/A'}}</td>
        <td class="text-center">{{$item->car->reg_no}}</td>
        <td class="text-center">{{$item->car->user->isEnabled() ? 'Yes' : 'No'}}</td>
        <td class="text-center">{{$item->created_at->format("j M'y, g:i a")}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {!! $items->links() !!}
</div>
@endsection

@push('script')
<script src="{{ asset('js/moment.min.js', true) }}" charset="utf-8"></script>
<script src="{{asset('vendors/datetimepicker/build/jquery.datetimepicker.full.min.js', true)}}"></script>
<script type="text/javascript">
  $(function() {
      $('input.date-picker').datetimepicker({
          timepicker: false,
          format:'j M Y',
      });
    });
</script>
@endpush