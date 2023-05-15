@extends('layouts.new')

@push('style')

@endpush

@section('content')
  <div class="col-xs-12 table-responsive">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th class="col-xs-1 text-center">SL</th>
          <th class="col-xs-2 text-center">Customer</th>
          <th class="col-xs-2 text-center">Car No.</th>
          <th class="col-xs-2 text-center">Paid On</th>
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
            <tr>
              <td class="text-center">{{$start + $key}}</td>
              <td class="text-center">
                {{$item->user->name}}
              </td>
              <td class="text-center">
                {{$item->car->reg_no}}
              </td>
              <td class="text-center">{{ $item->paid_on->format('j M Y') }}</td>
              <td class="text-center">{{ $item->created_at->format('j M Y') }}</td>
              <td class="text-center">{{ $item->amount }} Taka</td>
              <td class="text-center">{{ $item->method }}</td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
    @if ($items->count())
      {!! $items->links() !!}
    @endif
  </div>
@endsection

@push('script')

@endpush
