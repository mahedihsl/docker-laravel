@extends('layouts.custom')
@section('content')
<br><br><br><br>
@if(Session::has('flash'))
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert">×</a>
            <strong>Congrats!!!</strong> {!!Session::get('flash')!!}
        </div>
    @endif

<form id="form-forget-pass" role="form" method="POST" action="{{ url('/password/newPassword') }}" novalidate class="form-horizontal">
  <div class="col-md-9">
       <h2><div id="msg"></div></h2>
    <label for="code" class="col-sm-4 control-label">Code </label>

    <div class="col-sm-8">
      <div class="form-group">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="text" class="form-control" id="code" name="code" placeholder="Password Reset Code">
        @if($errors->has('code'))
            {{ $errors->first('code')}}
        @endif
      </div>
    </div>
    <label for="password" class="col-sm-4 control-label">Password</label>

      <div class="col-sm-8">
          <div class="form-group">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        @if($errors->has('password'))
            {{ $errors->first('password')}}
        @endif
      </div>
      </div>

      <label for="confirm_password" class="col-sm-4 control-label">Confirm Password</label>

        <div class="col-sm-8">
            <div class="form-group">
          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">

        </div>
        </div>

  </div>
  <div class="form-group">
    <div class="col-sm-offset-5 col-sm-6">
      <button type="submt" class="btn btn-success">Submit</button>
     <br><br><br>

    </div>
  </div>
</form>
@endsection
@section('js')
<script>
$(document).ready(function() {


});
</script>
@endsection
