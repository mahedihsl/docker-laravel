@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">


            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">recharge {{ $recharge->phone }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/recharge') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <!-- <a href="{{ url('/recharge/' . $recharge->id . '/edit') }}" title="Edit recharge"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['recharge', $recharge->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete recharge',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!} -->
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-responsive table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $recharge->id }}</td>
                                    </tr>
                                    <tr><th> Phone </th><td> {{ $recharge->phone }} </td>
                                    </tr>
                                    <tr><th> Amount </th><td> {{ $recharge->amount }} </td></tr>
                                    <tr><th> Volume </th><td> {{ $recharge->volume }} </td></tr>
                                  <tr><th> Recharge Date </th><td> {{ Carbon\Carbon::parse($recharge->recharged_at)->format('d M Y') }}</td></tr>
                                    <tr><th> Validity </th><td> {{ Carbon\Carbon::parse($recharge->validity)->format('d M Y') }}</td></tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
