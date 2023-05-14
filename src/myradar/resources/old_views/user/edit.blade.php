@extends('layouts.new')

@section('content')
  <form class="form" action="/user/update" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="hidden" name="id" value="{{$user->id}}">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="{{$user->name}}">
      <p class="help-block">{{ $errors->first('name') }}</p>
    </div>

    <div class="form-group">
      <label for="phone">Phone</label>
      <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" value="{{$user->phone}}">
      <p class="help-block">{{ $errors->first('phone') }}</p>
    </div>

    <div class="form-group">
      <label for="nid">National ID</label>
      <input type="text" class="form-control" id="nid" name="nid" placeholder="National ID" value="{{$user->nid}}">
      <p class="help-block">{{ $errors->first('nid') }}</p>
    </div>

    <div class="form-group">
      <label for="type">User Type</label>
      <select class="form-control" name="type" id="type" data-real={{$user->type}}>
        <option value="0">Select Type</option>
        <option value="{{ App\Entities\User::$TYPE_ADMIN }}">Admin</option>
        <option value="{{ App\Entities\User::$TYPE_AGENT }}">Agent</option>
        <option value="{{ App\Entities\User::$TYPE_GOVT }}">Govt.</option>
      </select>
      <p class="help-block">{{ $errors->first('type') }}</p>
    </div>

    <div class="form-group">
      <label for="note">Note</label>
      <textarea name="note" rows="4" class="form-control">{{$user->note or ''}}</textarea>
    </div>

    <button type="submit" class="btn btn-success btn-sm">
      <i class="fa fa-save"></i> UPDATE
    </button>
</form>
@endsection
