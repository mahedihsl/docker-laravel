

@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Recharge Status of Devices <a href="/billing" class="btn btn-default btn-sm"> <i class="fa fa-arrow-circle-left fa-2x"></i></i></a>
            </div>
            <div class="panel-body">
              @if (count($import_errors)> 0)
              <ul class="">
                  @foreach ($import_errors as $import_error)
                      <li><h5 style="color:red">{{$import_error}}</h5></li>
                  @endforeach
              </ul>
              @endif
              @if (count($sucessfull_recharges)> 0)
              <ul class="">
                  @foreach ($sucessfull_recharges as $success)
                      <li><h5 style="color:green">{{$success}}</h5></li>
                  @endforeach
              </ul>
              @endif

           </div>
       </div>
     </div>
</div>


@endsection

@section('js')

@endsection
