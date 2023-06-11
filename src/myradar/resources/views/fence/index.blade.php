@extends('layouts.app')

@section('css')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">Geofence Manager</h3>
              </div>
              <div class="panel-body">
                  <div class="row row-eq-height">
                      <div class="col-md-10 col-md-offset-1">
                          <component :is="current"></component>
                      </div>
                  </div>
              </div>
              <div class="panel-footer">

              </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{ asset('js/fence/index.js', $hasHttps) }}" charset="utf-8"></script>
@endsection
