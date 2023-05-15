@extends('layouts.new')

@push('style')

@endpush

@section('title')
Device Bind History
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <form action="{{ route('bind.history') }}" class="form form-inline" method="GET">
      <div class="form-group">
        <input type="text" placeholder="Reg No." name="reg_no" class="form-control"
          value="{{ $query->get('reg_no', '') }}" />
      </div>
      <div class="form-group">
        <input type="text" placeholder="Com. ID" name="com_id" class="form-control"
          value="{{ $query->get('com_id', '') }}" />
      </div>
      <button class="btn btn-success" type="submit">
        <i class="fa fa-filter"></i> Filter
      </button>
      <button class="btn btn-default" type="button" id="clear-form">
        <i class="fa fa-times"></i> Clear
      </button>
    </form>
  </div>
  <div class="col-xs-12">
    <table class="table table-responsive table-striped">
      <thead>
        <tr>
          <th class="col-xs-1">#</th>
          <th class="col-xs-2">Car</th>
          <th class="col-xs-2">Device</th>
          <th class="col-xs-3">Action</th>
          <th class="col-xs-4">Time</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($logs as $i => $log)
        <tr>
          <td>{{ ($logs->currentPage() - 1) * $logs->perPage() + $i + 1 }}</td>
          <td>{{ $log['car'] }}</td>
          <td>{{ $log['device'] }}</td>
          <td>
            @if ($log['action'] == 'BIND')
            <span class="text-success">
              <i class="fa fa-dot-circle-o"></i>
              {{ $log['action'] }}
            </span>
            @else
            <span class="text-danger">
              <i class="fa fa-dot-circle-o"></i>
              {{ $log['action'] }}
            </span>
            @endif

          </td>
          <td>{{ $log['time'] }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $logs->links() }}
  </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
  $(function() {
    $('#clear-form').click(function() {
      $('input[name="reg_no"]').val('')
      $('input[name="com_id"]').val('')

      $(this).closest('form').submit()
    })
  })
</script>
@endpush