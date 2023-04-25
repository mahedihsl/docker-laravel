@extends('layouts.new')

@push('style')
<style type="text/css">
    #common-map {
        width: 100%;
        min-height: 520px;
    }
</style>
@endpush

@section('title')
Area Geofence Library
@endsection

@section('content')
<div class="row" id="app">
    <input type="hidden" name="customer_id" value="{{ Auth::user()->id }}" />
    <modal name="area-builder" width="65%" height="auto" draggable="#builder-header">
        <area-builder @cancel="closeAreaBuilder"></area-builder>
    </modal>
    <modal name="car-chooser" width="50%" height="80%" draggable="#chooser-header">
        <car-chooser :geofence="currentGeofence" @cancel="closeCarChooser"></car-chooser>
    </modal>
    <modal name="area-editor" width="65%" height="auto" draggable="#editor-header">
        <area-editor @cancel="closeAreaEditor" :geofence="currentGeofence"></area-editor>
    </modal>
    <div class="col-md-12" v-if="!templates.length">
        <no-area-found @create="showAreaBuilder"></no-area-found>
    </div>
    <div class="col-md-12" v-show="templates.length">
        <div class="row row-eq-height">
            <div class="col-md-3"
                style="display: flex; flex-direction: column; justify-content: space-between; padding-right: 5px;">
                <div class="flex-grow: 1; display: flex; flex-direction: column; overflow: scroll;">
                    <area-list :items="templates" @item-click="onGeofenceClick">
                    </area-list>
                </div>

                <button class="btn btn-primary" style="flex-shrink: 0" @click="showAreaBuilder">
                    <i class="fa fa-plus mr-4"></i> Add Geofence
                </button>
            </div>
            <div class="col-md-9" style="padding-left: 5px;">
                <div style="position: relative; padding-left: 0; padding-right: 0;">
                    <div id="common-map"></div>
                    <geofence-info :geofence="currentGeofence" :choose-car="true" @chooser="showCarChooser"
                        @close="currentGeofence = null" @edit="onGeofenceEdit" v-if="!!currentGeofence">
                    </geofence-info>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAf9yCy5ZZ6iEo0EyOWjUg4EpUHIeuZVWQ&libraries=geometry">
</script>
<script src="{{ asset('js/fence/polygon.js', true) }}" charset="utf-8"></script>
@endpush