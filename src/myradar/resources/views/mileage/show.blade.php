@extends('layouts.app')

@section('css')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">
                    Mileage Report
                    <input type="hidden" name="userid" value="{{$user->id}}">
                </h3>
              </div>
              <div class="panel-body">
                  <filter-form></filter-form>
                  <component v-bind:is="content" v-bind="currentProps"></component>
              </div>
              <div class="panel-footer">

              </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{asset('js/chart.min.js')}}" charset="utf-8"></script>
<script src="{{asset('js/mileage/show.js')}}" charset="utf-8"></script>
@endsection
