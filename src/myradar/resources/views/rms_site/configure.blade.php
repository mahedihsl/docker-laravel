@extends('layouts.new')

@push('style')

@endpush

@section('title')
{{ $site['name'] }}
@endsection

@section('action')

@endsection

@section('content')
<input type="hidden" value="{{ $site['id'] }}" name="site_id" id="site_id" />
<div class="tw-w-full" id="app">
    <div class="tw-w-full tw-flex tw-flex-col tw-gap-y-10" v-if="!!site">
        <div class="tw-w-full tw-border-b tw-border-gray-300" v-for="(dev, i) in site.com_ids" :key="i">
            <h4>Device Com. ID: @{{ dev }}</h4>
            <div class="tw-w-full tw-flex tw-flex-col tw-gap-y-3">
                <pin-header></pin-header>
                <pin-config 
                    v-for="(conf, j) in pinConfigsOfDevice(dev)" 
                    :key="conf.id" 
                    :config="conf">
                </pin-config>
                <div v-if="!pinConfigFormVisibility(+dev)"
                    class="tw-w-full tw-flex tw-flex-row tw-justify-end tw-my-4">
                    <div class="tw-w-2/12 tw-flex tw-flex-row tw-justify-center">
                        <button class="btn btn-primary btn-sm" @click="showPinConfigForm(+dev)">
                            <i class="fa fa-plus"></i>
                            Add Pin
                        </button>
                    </div>
                </div>
                <pin-config-form 
                    v-if="pinConfigFormVisibility(+dev)" 
                    :site-id="site_id" 
                    :com-id="dev"
                    @close="onPinConfigFormClosed">
                </pin-config-form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('js/rms/configure.js', true) }}" charset="utf-8"></script>
@endpush