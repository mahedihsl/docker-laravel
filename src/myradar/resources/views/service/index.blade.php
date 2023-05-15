@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Services
                    <a href="/service/create" class="btn btn-link pull-right">Create New</a>
                </div>

                <div class="panel-body">
                    <service-list></service-list>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{ asset('js/service.js') }}"></script>
@endsection
