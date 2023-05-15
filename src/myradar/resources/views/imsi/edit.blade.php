@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit imsi #{{ $imsi->imsi }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/imsi') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                

                        {!! Form::model($imsi, [
                            'method' => 'PATCH',
                            'url' => ['/imsi', $imsi->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('imsi.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
