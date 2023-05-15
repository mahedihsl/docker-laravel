@extends('layouts.new')

@section('content')
    <div class="row">
      <div class="col-xs-12">
        <h3>Test Speed Limit Cross Notification</h3>
        <hr>
        <form action="/test/speed-noti" class="form col-xs-12 col-md-4" method="post">
          {!! csrf_field() !!}
          <div class="form-group">
            <label for="speed">Speed (Km/h)</label>
            <input type="text" value="60" name="speed" class="form-control" id="speed" />
          </div>
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