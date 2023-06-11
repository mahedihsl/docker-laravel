@extends('layouts.new')

@section('content')
    <div class="row" id="app">
        <input type="hidden" name="user_id" value="{{$user->id}}">
        <div class="col-xs-12 col-md-6">
            <refuel-form :userid="userId"></refuel-form>
        </div>
        <div class="col-xs-12 col-md-6">
            <history></history>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('js/customer/refuel.js', $hasHttps) }}" charset="utf-8"></script>
@endpush
