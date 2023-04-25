@extends('layouts.new')

@section('content')
  <div class="row">
    <div class="col-xs-12">
      All Users
      <a href="/user/create" class="btn btn-link pull-right">
        <i class="fa fa-plus"></i> New User
      </a>
    </div>
    <div class="col-md-12">
      <form class="form-inline" action="/users" method="get">
        <div class="form-group">
          <input type="text" name="name" class="form-control" id="name" placeholder="Type User's Name" value="{{$params['name'] or ''}}">
        </div>

        <button type="submit" class="btn btn-sm btn-primary">
          <i class="fa fa-search"></i>Search
        </button>
      </form>
    </div>
    <div class="col-xs-12 table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th class="col-xs-3">Name</th>
            <th class="col-xs-3">Type</th>
            <th class="col-xs-3">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $key => $user)
            <tr>
              <td>
                <span class="{{$user->deleted_at ? 'text-danger' : ''}}">{{ $user->name }}</span>
              </td>
              <td>{{ $user->type_name }}</td>
              <td>
                <a href="/user/details/{{$user->id}}" class="btn btn-link">
                  <i class="fa fa-info-circle"></i>
                </a>
                <a href="/user/edit/{{$user->id}}" class="btn btn-link">
                  <i class="fa fa-pencil"></i>
                </a>
                @if ($user->deleted_at)
                  <a href="/user/activate/{{$user->id}}" class="btn btn-link">
                    <i class="fa fa-square-o"></i>
                  </a>
                @else
                  <a href="/user/deactivate/{{$user->id}}" class="btn btn-link">
                    <i class="fa fa-check-square-o"></i>
                  </a>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
