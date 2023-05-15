<template>
    <div class="col-xs-12">
        <div class="row" v-if="!notFound">
            <div class="col-xs-12 log-item" v-for="(o, i) in logs">
                <strong>{{i + 1}}. {{o.amount}}</strong> <small>{{o.time}}</small>
            </div>
        </div>
        <div class="row" v-if="notFound">
            <div class="col-xs-12 log-list v-margin">
                <h5 class="text-center">No User Data Found</h5>
            </div>
        </div>
    </div>
</template>
<script>
import EventBus from '../../../util/EventBus';
import RefuelApi from '../../../api/RefuelApi';

export default {
    props: ['type'],
    data: () => ({
        logs: [],
        notFound: false,
    }),
    mounted() {
        EventBus.$on('get-refuel-logs', this.getLogs.bind(this));
        EventBus.$on('refuel-log-found', this.onDataFound.bind(this));
        EventBus.$on('refuel-log-error', this.onDataError.bind(this));
    },
    methods: {
        getLogs(carId) {
            let api = new RefuelApi(EventBus);
            api.getLog(carId, this.type);
        },

        onDataFound(list) {
            this.logs = list;
            this.notFound = false;
        },

        onDataError() {
            this.notFound = true;
        }
    }
}
</script>
<style scoped>
.log-item {
    border-bottom: 1px solid #BDBDBD;
    padding: 10px;
}
.log-item > strong {
    color: #616161;
}
</style>
