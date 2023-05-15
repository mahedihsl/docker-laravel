@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">New Service</div>

                <div class="panel-body">
                    <form class="form" action="/service/save" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Service Name" value="{{ old('name') }}">
                            <p class="help-block">{{$errors->first('name')}}</p>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select class="form-control" name="type" id="type">
                                <option value="{{App\Entities\Service::$TYPE_DIGITAL}}">Digital</option>
                                <option value="{{App\Entities\Service::$TYPE_ANALOG}}">Analog</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
