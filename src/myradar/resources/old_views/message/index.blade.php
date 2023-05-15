@extends('layouts.new')

@push('style')
  <style media="screen">
    .message-box {
      border-bottom: 1px solid #e0e0e0;
    }
  </style>
@endpush

@section('content')
  <div class="row">
    @foreach ($messages as $key => $msg)
      <div class="col-xs-12 message-box">
        <h5>Sender: <b>{{$msg->name}}</b></h5>
        <h5>Phone: <b>{{$msg->phone}}</b></h5>
        <h5>Email: <b>{{$msg->email}}</b></h5>
        <p><small>{{$msg->created_at->toDayDateTimeString()}}</small></p>
        <p>{{$msg->body}}</p>
      </div>
    @endforeach
    {!! $messages->links() !!}
  </div>
@endsection
