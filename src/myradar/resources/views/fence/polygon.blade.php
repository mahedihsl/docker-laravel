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
Area Geofence <strong> - {{ $customer->name }}</strong>
@endsection

@section('content')
<div class="row" id="app">
    <input type="hidden" name="customer_id" value="{{ $customer->id }}" />
    <modal name="area-builder" width="50%" height="auto" draggable="#builder-header">
        <area-builder @cancel="closeAreaBuilder"></area-builder>
    </modal>
    {{-- <div class="col-md-12" v-if="!geofences.length">
        <no-area-found @create="showAreaBuilder"></no-area-found>
    </div> --}}
    <div class="col-md-12">
        <div class="row row-eq-height">
            <div class="col-md-3"
                style="display: flex; flex-direction: column; justify-content: space-between; padding-right: 5px;">
                <div class="flex-grow: 1; display: flex; flex-direction: column; overflow: scroll;">
                    <area-list :items="geofences" @item-click="onGeofenceClick"></area-list>

                    <div style="display: flex; flex-direction: column;">
                        <strong>Geofence Library</strong>
                        <span>You can add geofence from this predefined list</span>
                    </div>

                    <template-list :items="templates" @item-click="onTemplateClick">
                    </template-list>
                </div>

                <button class="btn btn-primary" style="flex-shrink: 0" @click="showAreaBuilder">
                    <i class="fa fa-plus mr-4"></i> Add Geofence
                </button>
            </div>
            <div class="col-md-9" style="padding-left: 5px;">
                <div style="position: relative; padding-left: 0; padding-right: 0;">
                    <div id="common-map"></div>
                    <geofence-info :geofence="currentGeofence" @close="currentGeofence = null" v-if="!!currentGeofence">
                    </geofence-info>
                    <template-info v-if="!!currentTemplate" :geofence="currentTemplate" @close="currentTemplate = null"
                        @attach="onTemplateAdd">
                    </template-info>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAf9yCy5ZZ6iEo0EyOWjUg4EpUHIeuZVWQ&libraries=geometry">
</script>
<script src="{{ asset('js/fence/polygon.js', $hasHttps) }}" charset="utf-8"></script>
@endpush
