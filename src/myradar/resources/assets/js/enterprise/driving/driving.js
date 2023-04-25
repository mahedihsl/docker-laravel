require('../../bootstrap');

import EventBus from '../../util/EventBus';
import store from './store';

import DrivingReport from '../../components/enterprise/driving/Table.vue';
import Chart from '../../components/enterprise/Chart.vue';

new Vue({
    el: '#app',
    store,
    components: {
        DrivingReport, Chart,
    },
    data: {
        type: null,
        car: null,
        current: DrivingReport,
    },
    computed: {
        backable() {
            return this.current === Chart;
        },
        props() {
            if (this.current === Chart) {
                return {
                    type: this.type,
                    car: this.car,
                };
            }
        },
    },
    mounted() {
        EventBus.$on('show-chart', this.onReportClick.bind(this));
        let userId = $('input[name="user_id"]').val();
        this.$options.store.commit('setUserId', userId);

    },
    methods: {
        onReportClick(type, car) {
            this.type = type;
            this.car = car;
            this.current = Chart;
        },

        dismiss() {
            this.current = DrivingReport;
        }
    }
});
