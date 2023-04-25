@extends('layouts.app')

@section('css')
    <style media="screen">
        .operator-logo {
            width: 30%;
            height: auto;
            margin: 10px auto;
            display: block;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
            <form action="{{route('update-operator')}}" class="form" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="{{$op->id}}">
                <div class="form-group">
                    <img src="{{$op->image->url}}" alt="" class="img operator-logo">
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{$op->name}}">
                </div>
                <div class="form-group">
                    <label for="ussd">USSD</label>
                    <input type="text" name="ussd" id="ussd" class="form-control" value="{{$op->ussd}}">
                </div>
                <div class="form-group">
                    <label for="start">Starting Position</label>
                    <input type="text" name="start" id="start" class="form-control" value="{{$op->start}}">
                </div>
                <div class="form-group">
                    <label for="sender">Sender</label>
                    <input type="text" name="sender" id="sender" class="form-control" value="{{$op->sender}}">
                </div>
                <a href="{{route('operators')}}" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
@endsection
