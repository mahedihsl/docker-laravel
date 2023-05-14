@extends('layouts.new')

@push('style')

@endpush

@section('content')
  <div class="col-xs-12">
    <form class="" action="/billing/drilldown" method="get">
      <div class="row">
        <div class="col-xs-2 col-xs-offset-1">
          <select name="month" class="form-control" data-real="{{$month}}">
            <option value="0">Select Month</option>
            <option value="1">Jan</option>
            <option value="2">Feb</option>
            <option value="3">Mar</option>
            <option value="4">Apr</option>
            <option value="5">May</option>
            <option value="6">Jun</option>
            <option value="7">Jul</option>
            <option value="8">Aug</option>
            <option value="9">Sep</option>
            <option value="10">Oct</option>
            <option value="11">Nov</option>
            <option value="12">Dec</option>
          </select>
        </div>
        <div class="col-xs-2">
          <select class="form-control" name="year" data-real="{{$year}}">
            <option value="0">Select Year</option>
            <option value="2018">2018</option>
            <option value="2019">2019</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
          </select>
        </div>
        <div class="col-xs-3">
          <select class="form-control" name="filter" data-real="{{$filter}}">
            <option value="1">Billing Month</option>
            <option value="2">Collection Month</option>
          </select>
        </div>
        <div class="col-xs-2">
          <input class="btn btn-primary" type="submit" name="export" value="Search"/>
          <input class="btn btn-info" type="submit" name="export" value="Export"/>
        </div>
      </div>
    </form>
  </div>
  <div class="col-xs-12 table-responsive">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th class="col-xs-1 text-center">SL</th>
          <th class="col-xs-2 text-center">Customer</th>
          <th class="col-xs-2 text-center">Car No.</th>
          <th class="col-xs-2 text-center">Date/Time</th>
          <th class="col-xs-2 text-center">Input On</th>
          <th class="col-xs-1 text-center">Amount</th>
          <th class="col-xs-1 text-center">Method</th>
        </tr>
      </thead>
      <tbody>
        @if ($items->count())
          @php
            $start = ($items->perPage() * ($items->currentPage()-1)) + 1;
          @endphp
          @foreach ($items as $key => $item)
            @php
              $amount = $filter == 1 ? $item->car->bill : $item->amount;
              $date = $filter == 2 ? $item->paid_on->format('j M Y') : Carbon\Carbon::createFromDate($year, $month, 1)->format('M Y');
            @endphp
            <tr>
              <td class="text-center">{{$start + $key}}</td>
              <td class="text-center">
                {{$item->user->name}}
              </td>
              <td class="text-center">
                {{$item->car->reg_no}}
              </td>
              <td class="text-center">{{ $date }}</td>
              <td class="text-center">{{ $item->created_at->format('j M Y') }}</td>
              <td class="text-center">{{ $amount }} Taka</td>
              <td class="text-center">{{ $item->method }}</td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
    @if ($items->count())
      {!! $items->appends(['month' => $month, 'year' => $year, 'filter' => $filter])->links() !!}
    @endif
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
