require('../../bootstrap');

import Selector from '../../components/device/lastPulse/Selector.vue';
import PerfChart from '../../components/device/lastPulse/Chart.vue';
import DeviceList from '../../components/device/lastPulse/List.vue';

import store from './store';

new Vue({
    el: '#app',
    store,
    components: {
        Selector,
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
