<template lang="html">
    <div class="col-md-12">
        <div class="col-md-6 col-md-offset-3">
            <img v-bind:src="info.image" alt="" class="img img-circle profile-pic-md">
        </div>
        <div class="col-md-6 col-md-offset-3 m-bottom-lg">
            <h4 class="text-center">{{info.name}}</h4>
            <h5 class="text-center">{{info.phone}}</h5>
        </div>
        <div class="col-md-12">
            <component v-bind:is="statusView"></component>
        </div>
    </div>
</template>

<script>
import Spinner from './Spinner';
import Success from './Success';
import Error from './Error';

import EventBus from '../../util/EventBus';

export default {
    props: ['info'],
    components: {
        Spinner, Success, Error
    },
    data: () => ({
        statusView: '',
    }),
    mounted: function() {
        EventBus.$on('save-start', this.onSaveStart.bind(this));
        EventBus.$on('save-finish', this.onSaveFinish.bind(this));
    },
    methods: {
        onSaveStart() {
            this.statusView = 'spinner';
        },
        onSaveFinish(flag) {
            this.statusView = flag ? 'success' : 'error';
        },
    }
}
</script>

<style lang="css">
.m-bottom-lg {
    margin-bottom: 10px;
}
</style>
