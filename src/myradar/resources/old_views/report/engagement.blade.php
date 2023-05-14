@extends('layouts.new')

@push('style')

@endpush

@section('content')
<div class="col-xs-12"
  style="margin-bottom: 15px; display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
  <form class="form-inline" action="/engagement/report" method="get">
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Customer Name" name="name" value="{{$params->get('name')}}">
    </div>
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Phone Number" name="phone" value="{{$params->get('phone')}}">
    </div>
    <button type="submit" class="btn btn-success">
      <i class="fa fa-search"></i> Search
    </button>
    <a href="/engagement/report" class="btn btn-default">
      <i class="fa fa-close"></i> Clear
    </a>

  </form>
  <form class="form-inline" action="/engagement/export" method="get">
    <div class="form-group">
      <select name="month" class="form-control">
        <option value="1">January</option>
        <option value="2">February</option>
        <option value="3">March</option>
        <option value="4">April</option>
        <option value="5">May</option>
        <option value="6">June</option>
        <option value="7">July</option>
        <option value="8">August</option>
        <option value="9">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
      </select>
    </div>
    <div class="form-group">
      <select name="year" class="form-control">
        <option value="2020">2020</option>
        <option value="2021">2021</option>
        <option value="2022">2022</option>
        <option value="2023">2023</option>
        <option value="2024">2024</option>
        <option value="2025">2025</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">
      <i class="fa fa-file-text"></i> Export
    </button>
  </form>

</div>

@if (Auth::user()->type == 1)
<div class="col-xs-12">
  <form action="/engagement/smspack1-enabler" method="GET" style="margin: 15px 0; background: #f5f5f5; border-radius: 5px; border: 1px solid #eeeeee; padding: 20px 40px; display: flex; flex-direction: column; align-items: center;">
    <p style="color: #616161; font-size: 14px; font-weight: 600; margin-bottom: 20px;">Click the below button to enable SMS Pack1 for under engaged users. This script will monitor all app activity of
      previous month. SMS Pack1 will be enabled for all users who have less than 100 API requests, also SMS Pack1 will be
      disabled for all users who have more than 300 API requests. An Excel report will be generated after script is over.
    </p>
    <button class="btn btn-primary">Start Scanning</button>
  </form>  
</div>    
@endif

<div class="col-xs-12 table-responsive">
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th class="col-xs-1 text-center">SL</th>
        <th class="col-xs-2 text-center">Customer</th>
        <th class="col-xs-1 text-center">Cars</th>
        <th class="col-xs-2 text-center">{{ Carbon\Carbon::today()->format('j M') }}</th>
        <th class="col-xs-2 text-center">{{ Carbon\Carbon::yesterday()->format('j M') }}</th>
        <th class="col-xs-2 text-center">{{ Carbon\Carbon::today()->subDays(2)->format('j M') }}</th>
      </tr>
    </thead>
    <tbody>
      @php
      $start = ($items->perPage() * ($items->currentPage()-1)) + 1;
      @endphp
      @foreach ($items as $key => $item)
      @php
      $data = $item->getLatestActivity();
      @endphp
      <tr>
        <td class="text-center">{{ $start + $key }}</td>
        <td class="text-center">{{ $item->name }}</td>
        <td class="text-center">{{ $item->cars()->count() }}</td>
        <td class="text-center">
          <span class="text-success">open</span>-{{$data[0]['l']}} <br>
          <span class="text-primary">request</span>-{{$data[0]['r']}}
        </td>
        <td class="text-center">
          <span class="text-success">open</span>-{{$data[1]['l']}} <br>
          <span class="text-primary">request</span>-{{$data[1]['r']}}
        </td>
        <td class="text-center">
          <span class="text-success">open</span>-{{$data[2]['l']}} <br>
          <span class="text-primary">request</span>-{{$data[2]['r']}}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {!! $items->links() !!}
</div>
@endsection

@push('script')

@endpush