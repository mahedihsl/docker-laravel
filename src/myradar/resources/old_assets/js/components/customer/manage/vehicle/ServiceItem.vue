<template>
    <li class="text-primary">
        <i class="fa fa-check-circle"></i>
        <span>{{service.label}}</span>
        <i class="fa fa-spinner fa-spin text-primary pull-right" v-if="status == 0"></i>
        <i class="fa fa-thumbs-up text-success pull-right" v-if="status == 1"></i>
    </li>
</template>
<script>
import EventBus from '../../../../util/EventBus';
import DeviceApi from '../../../../api/DeviceApi';

export default {
    props: ['service', 'carId'],
    data: () => ({
        device_id: null,
        status: -1,
        interval: 5000,
    }),
    mounted() {
        EventBus.$on('car-bind-done', this.onBindComplete.bind(this));
        EventBus.$on('service-check-done', this.onServiceCheckDone.bind(this));
    },
    methods: {
        onBindComplete(id) {
            this.device_id = id;
            this.status = 0;
            setTimeout(this.checkForServiceData.bind(this), this.interval);
        },
        checkForServiceData() {
            let api = new DeviceApi(EventBus);
            api.checkServiceData(this.carId, this.service.tag);
        },
        onServiceCheckDone(data) {
            if (data.id == this.service.tag) {
                if (data.status == 1) {
                    this.status = 1;
                } else {
                    setTimeout(this.checkForServiceData.bind(this), this.interval);
                }
            }
        }
    }
}
</script>
<style lang="scss" scoped>
</style>
