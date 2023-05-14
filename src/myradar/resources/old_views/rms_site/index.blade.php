@extends('layouts.new')

@section('css')

@endsection

@section('title')
{{ $user->name }} - <span>RMS Site Management</span>
@endsection

@section('action')
<a href="/rms/site/create?user_id={{ $user->id }}" class="btn btn-success">
    <i class="fa fa-plus"></i>
    New Site
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="col-xs-4">Name</th>
                    <th class="col-xs-5">Installed Devices</th>
                    <th class="col-xs-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sites as $site)
                <tr>
                    <td>{{ $site['name'] }}</td>
                    <td>
                        @foreach ($site['com_ids'] as $com_id)
                        <span class="label label-default">{{ $com_id }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="/rms/site/edit/{{ $site['id'] }}" class="btn btn-default">Edit</a>
                        <a href="/rms/site/configure/{{ $site['id'] }}" class="btn btn-primary">Devices</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')

@endsection