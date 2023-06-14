@extends('layouts.new')

@push('style')

@endpush

@section('content')

<div class="row">
    <div class="col-md-12">
        @include('bkash.chcekout-url.bkash_fillter', ['data' => $params])
    </div>
</div>

<div class="row">
    <div class="col-md-12 table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th class="col-xs-1 text-center">SL</th>
                    <th class="col-xs-1 text-center">Customer Name</th>
                    <th class="col-xs-1 text-center">Customer Phone No</th>
                    <th class="col-xs-1 text-center">bKash Wallet No</th>
                    <th class="col-xs-1 text-center">Amount (BDT)</th>
                    <th class="col-xs-1 text-center">bKash trxID</th> 
                    <th class="col-xs-1 text-center">Pay Date</th>
                </tr>
            </thead>
            <tbody>
                @if ($transactions->count())
                @php
                $start = ($transactions->perPage() * ($transactions->currentPage()-1)) + 1;
                @endphp

                @foreach ($transactions as $key => $item)
                <tr>
                    <td class="text-center">{{$start + $key}}</td>
                    <td class="text-center">{{ $item->user_name }}</td>
                    <td class="text-center">{{ $item->phone_no }}</td>
                    <td class="text-center">{{ $item->wallet_no }}</td>
                    <td class="text-center">{{ $item->amount }}</td>
                    <td class="text-center">{{ $item->trx_id }}</td> 
                    <td class="text-center">{{ $item->updated_at->format('j M Y g:i A') }}</td>
                </tr>

                @endforeach
                @endif
            </tbody>
        </table>
        @if ($transactions->count())
        {!! $transactions->links() !!}
        @endif
    </div>
</div>

@endsection