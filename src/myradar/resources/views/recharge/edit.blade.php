@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit recharge #{{ $recharge->phone }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/recharge') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if(Session::has('flash_message'))
                            {{ Session::get('flash_message')}}
                        @endif

                        {!! Form::model($recharge, [
                            'method' => 'PATCH',
                            'url' => ['/recharge', $recharge->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('recharge.form_edit', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
