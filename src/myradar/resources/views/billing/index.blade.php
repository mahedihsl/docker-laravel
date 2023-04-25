@extends('layouts.new')

@push('style')

@endpush

@section('content')
  <div class="col-xs-12">
    <a href="/billing/export" class="btn btn-primary pull-right">
      <i class="fa fa-file-text"></i> Export
    </a>
  </div>
  <div class="col-xs-12 table-responsive">
    <table class="table-striped table-bordered">
      <thead>
        <tr>
          <th class="col-xs-1 text-center">SL</th>
          <th class="col-xs-2 text-center">Customer</th>
          <th class="col-xs-1 text-center">Car No.</th>
          <th class="col-xs-2 text-center">Date of Activation</th>
          <th class="col-xs-1 text-center">Total</th>
          <th class="col-xs-1 text-center">Paid</th>
          <th class="col-xs-1 text-center">Due</th>
          <th class="col-xs-1 text-center">Waive</th>
        </tr>
      </thead>
      <tbody>
        @php
          $start = ($items->perPage() * ($items->currentPage()-1)) + 1;
        @endphp
        @foreach ($items as $key => $item)
          @php
            $total = $item->car->totalBill();
            $paid = $item->car->totalPaid();
            $waive = $item->car->totalWaive();
            $due = max(0, $total - $paid - $waive);
          @endphp
          <tr>
            <td class="text-center">{{$start + $key}}</td>
            <td class="text-center">
              {{$item->car->user->name}}
            </td>
            <td class="text-center">
              {{$item->car->reg_no}}
            </td>
            <td class="text-center">{{ $item->created_at->toDayDateTimeString() }}</td>
            <td class="text-center">{{ $total }}</td>
            <td class="text-center">{{ $paid }}</td>
            <td class="text-center">{{ $due }}</td>
            <td class="text-center">{{ $waive }}</td>
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
