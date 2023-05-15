@extends('layouts.new')

@section('content')
    <div class="row">
      <div class="col-xs-12">
        <h3>Test General Push Notification</h3>
        <hr>
        <form action="/test/push-noti" class="form col-xs-12 col-md-4" method="post">
          {!! csrf_field() !!}
          <div class="form-group">
            <label for="reg">Reg. Number of a Car</label>
            <input type="text" value="" name="reg_no" class="form-control" id="reg" placeholder="Ex: 99-1234" />
          </div>
          <div class="form-group">
            <label for="noti-type">Notification Type</label>
            <select name="type" value="0" class="form-control">
              <option value="0">General</option>
              <option value="20">Engine</option>
              <option value="21">Speed</option>
              <option value="22">Geo Fence</option>
              <option value="23">Mileage</option>
              <option value="24">Payment</option>
              <option value="26">Password</option>
            </select>
          </div>
          <div class="form-group">
            <label for="title">Notification Title</label>
            <input type="text" value="" name="title" class="form-control" id="title" placeholder="A short title" />
          </div>
          <div class="form-group">
            <label for="body">Notification Body</label>
            <textarea type="text" value="" name="body" class="form-control" id="body" rows="6" placeholder="Write multiline text or Bangla text" ></textarea>
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