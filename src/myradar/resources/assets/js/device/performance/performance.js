require('../../bootstrap');

import Timeline from '../../components/device/performance/Timeline.vue';
import PerfChart from '../../components/device/performance/Chart.vue';
import DeviceList from '../../components/device/performance/List.vue';

import store from './store';

new Vue({
    el: '#app',
    store,
    components: {
        Timeline,
        PerfChart,
        DeviceList,
    },
    data: {

    },
    computed: {

    },
    mounted() {
        this.$options.store.commit('setDay', $('input[name="day"]').val());
    },
    methods: {

    }
});
