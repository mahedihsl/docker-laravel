<template lang="html">
    <div class="row">
        <div class="col-md-12">
            <span class="list-title">Add New Geofence</span>
            <button class="btn btn-default pull-right" v-on:click="goBackToMyList">
                <i class="fa fa-arrow-left"></i> Go Back
            </button>
            <hr>
        </div>
        <div class="col-md-12">
            <div class="form">
                <div class="col-md-6">
                    <div class="form-group">
                      <label>Select District</label>
                      <v-select :value.sync="district" :options="districts" :on-change="onDistrictChanged"></v-select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label>Select Thana</label>
                      <v-select :value.sync="thana" :options="thanas" :on-change="onThanaChanged"></v-select>
                    </div>
                </div>
            </div>
        </div>
        <spinner extra-height="true" v-show="showSpinner"></spinner>
        <div class="col-md-6 col-md-offset-3" v-show="!showSpinner">
            <fence v-for="(item, i) in fences" :fence="item" :key="i"></fence>
        </div>
    </div>
</template>

<script>
import Spinner from '../util/Spinner';
import Fence from './Fence';
import vSelect from "vue-select";

import FenceApi from '../../api/FenceApi';
import EventBus from '../../util/EventBus';

export default {
    components: {
        Spinner,
        Fence,
        vSelect,
    },
    data: function() {
        return {
            districts: [],
            thanas: [],
            fences: [],
            district: null,
            thana: null,
            showSpinner: true,
        };
    },
    mounted() {
        EventBus.$on('district-list-found', this.onDistrictListFound.bind(this));
        EventBus.$on('thana-list-found', this.onThanaListFound.bind(this));
        EventBus.$on('fence-list-found', this.onFenceListFound.bind(this));
        this.getDistrictList();
    },
    watch: {

    },
    methods: {
        getDistrictList() {
            let api = new FenceApi(EventBus);
            api.getDistrictList();
        },

        goBackToMyList() {
            EventBus.$emit('go-back-click');
        },

        getThanaList(districtId) {
            let api = new FenceApi(EventBus);
            api.getThanaList(districtId);
        },

        getFenceList(thanaId) {
            let api = new FenceApi(EventBus);
            api.getFenceList(thanaId);
        },

        onDistrictChanged(val) {
            this.district = val;
            this.getThanaList(val.value);
            this.showSpinner = true;
        },

        onThanaChanged(val) {
            this.thana = val;
            this.getFenceList(val.value);
            this.showSpinner = true;
        },

        onDistrictListFound(list) {
            this.districts = list.map(item => {
                return {value: item.id, label: item.name};
            });
            this.district = this.districts[0];
        },

        onThanaListFound(list) {
            this.thanas = list.map(item => {
                return {value: item.id, label: item.name};
            });
            this.thana = this.thanas[0];
            this.getFenceList(this.thana.value);
        },

        onFenceListFound(list) {
            this.fences = list;
            this.showSpinner = false;
        },
    }
}
</script>

<style lang="css">
</style>
