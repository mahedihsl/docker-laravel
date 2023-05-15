@extends('layouts.new')

@section('content')
    <div class="row">
      <div class="col-xs-12">
        <h3>Test Engine Status Notification</h3>
        <hr>
        <form action="/test/engine-noti" class="form col-xs-12 col-md-4" method="post">
          {!! csrf_field() !!}
          <div class="form-group">
            <label for="comid">Commercial ID</label>
            <input type="text" value="" name="com_id" class="form-control" id="comid" />
          </div>
          <button type="submit" class="btn btn-primary">Start Test</button>
        </form>
        <div class="col-xs-12 col-md-8">
          <ol>
            @foreach ($messages as $msg)
                <li><strong>{{ $msg }}</strong></li>
            @endforeach
          </ol>
        </div>
      </div>
    </div>
@endsection