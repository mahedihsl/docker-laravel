@extends('layouts.new')

@section('css')

@endsection

@section('title')
{{ $user->name }} - <span>New RMS Site</span>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <form class="col-xs-6 form" action="/rms/site/save" method="post">
            {!! csrf_field() !!}

            <input type="hidden" name="user_id" value="{{ $user->id }}" />

            <div class="form-group">
                <label for="name">Site Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Ex: Factory building 1"/>
                <p class="help-block">{{ $errors->first('name') }}</p>
            </div>

            <div class="form-group">
                <div class="pull-right">
                    <a href="/rms/site/manage?user_id={{ $user->id }}" class="btn btn-default">
                        <i class="fa fa-times"></i> CLOSE
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> SAVE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/rms/index.js', $hasHttps) }}" charset="utf-8"></script>
@endsection
