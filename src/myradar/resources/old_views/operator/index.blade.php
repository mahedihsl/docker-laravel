@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h3>Mobile Operators</h3>
        </div>
        <div class="col-sm-12">
            @foreach ($ops as $key => $op)
                <div class="row" style="margin-top: 20px">
                    <div class="col-sm-2">
                        <img src="{{$op->image->url}}" alt="" class="img" style="width: 60%; height: auto;">
                    </div>
                    <div class="col-sm-3">{{$op->name}}</div>
                    <div class="col-sm-2">
                        <a href="{{route('edit-operator', ['id' => $op->id])}}" class="btn btn-link">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
