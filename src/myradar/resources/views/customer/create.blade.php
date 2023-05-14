@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create New Customer
                </div>
                <div class="panel-body">
                    <customer-form></customer-form>
                </div>
                <div class="panel-footer">

                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
<script src="{{asset('js/customer/create.js')}}" charset="utf-8"></script>
@endsection
