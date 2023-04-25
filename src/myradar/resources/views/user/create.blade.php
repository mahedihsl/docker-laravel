@extends('layouts.new')

@section('content')
  <div class="col-xs-12 col-md-6 col-md-offset-3">
    <form class="form" action="/user/save" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Full Name"/>
            <p class="help-block">{{ $errors->first('name') }}</p>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number"/>
            <p class="help-block">{{ $errors->first('phone') }}</p>
        </div>

        <div class="form-group">
            <label for="nid">National ID</label>
            <input type="text" class="form-control" id="nid" name="nid" placeholder="National ID"/>
            <p class="help-block">{{ $errors->first('nid') }}</p>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email Address"/>
            <p class="help-block">{{ $errors->first('email') }}</p>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Min. length 6"/>
            <p class="help-block">{{ $errors->first('password') }}</p>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Type Password Again"/>
        </div>

        <div class="form-group">
            <label for="type">User Type</label>
            <select class="form-control" name="type" id="type">
                <option value="0">Select Type</option>
                <option value="{{ App\Entities\User::$TYPE_ADMIN }}">Admin</option>
                <option value="{{ App\Entities\User::$TYPE_AGENT }}">Customer Care</option>
                <option value="{{ App\Entities\User::$TYPE_OPERATION }}">Operation Team</option>
                <option value="{{ App\Entities\User::$TYPE_GOVT }}">LIA</option>
            </select>
            <p class="help-block">{{ $errors->first('type') }}</p>
        </div>

        <button type="submit" class="btn btn-success pull-right">
            <i class="fa fa-save"></i> SAVE
        </button>
    </form>
  </div>
@endsection

@section('js')

@endsection
