@extends('layouts.new')

@section('content')
  <div class="row">
    <div class="col-xs-12 col-md-6 col-md-offset-3">
      <form action="/change/password" class="form-horizontal" method="post">
        {!! csrf_field() !!}
        <div class="form-group">
          <label class="col-xs-4 control-label" for="current">Current Password</label>
          <div class="col-xs-8">
            <input type="password" class="form-control" name="current" id="current" placeholder="">
            @if ($errors->has('current'))
              <p class="text-danger">{{$errors->first('current')}}</p>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label class="col-xs-4 control-label" for="new">New Password</label>
          <div class="col-xs-8">
            <input type="password" class="form-control" name="new" id="new" placeholder="">
            @if ($errors->has('new'))
              <p class="text-danger">{{$errors->first('new')}}</p>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label class="col-xs-4 control-label" for="newc">Confirm Password</label>
          <div class="col-xs-8">
            <input type="password" class="form-control" name="new_confirmation" id="newc" placeholder="">
            @if ($errors->has('new_confirmation'))
              <p class="text-danger">{{$errors->first('new_confirmation')}}</p>
            @endif
          </div>
        </div>
        <button class="btn btn-info pull-right" type="submit">Change</button>
      </form>
    </div>
  </div>
@endsection
