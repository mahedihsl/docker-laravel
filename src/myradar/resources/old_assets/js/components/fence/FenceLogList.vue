<template lang="html">
    <div class="row">
        <div class="row">
            <div class="col-md-12">
                <span class="list-title">My Geofence List</span>
                <button class="btn btn-primary pull-right" v-on:click="showSearchFence">
                    <i class="fa fa-plus"></i> Add New
                </button>
                <hr>
            </div>
        </div>
        <div class="row">
            <spinner :extra-height="true" v-show="state == 0"></spinner>
            <div class="col-md-12" v-show="state == 1">
                <fence :fence="item" v-for="(item, i) in fences" :key="i"></fence>
            </div>
            <empty v-show="state == -1"></empty>
        </div>
    </div>
</template>

<script>
import NoData from './NoData';
import Spinner from '../util/Spinner';
import Fence from './Fence';

import EventBus from '../../util/EventBus';
import Api from '../../api/FenceApi';

export default {
    components: {
        'empty': NoData,
        'spinner': Spinner,
        'fence': Fence,
    },
    data: function() {
        return {
            fences: [],
            state: 0,
        };
    },
    mounted() {
        EventBus.$on('fence-log-found', this.onListFound.bind(this));
        EventBus.$on('fetch-fence-log', this.getList.bind(this));
        EventBus.$on('no-data-found', this.onNoDataFound.bind(this));
        this.getList();
    },
    methods: {
        getList() {
            let api = new Api(EventBus);
            api.getFenceLog();
        },

        onListFound(list) {
            this.state = 1;
            this.fences = list;
        },

        onNoDataFound() {
            this.state = -1;
        },

        showSearchFence() {
            console.log('add button clicked');
            EventBus.$emit('add-new-click');
        }
    },
}
</script>

<style lang="css">
.list-title {
    font-size: 16px;
    font-style: bold;
}
</style>
