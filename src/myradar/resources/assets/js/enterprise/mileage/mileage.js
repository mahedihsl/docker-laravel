require('../../bootstrap');

import EventBus from '../../util/EventBus';
import store from './store';

import MileageReport from '../../components/enterprise/mileage/Table.vue';
import Chart from '../../components/enterprise/Chart.vue';

new Vue({
    el: '#app',
    store,
    components: {
        MileageReport, Chart,
    },
    data: {
        type: null,
        car: null,
        current: MileageReport,
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

        this.$options.store.commit('setUserId', $('input[name="user_id"]').val());
    },
    methods: {
        onReportClick(type, car) {
            this.type = type;
            this.car = car;
            this.current = Chart;
        },

        dismiss() {
            this.current = MileageReport;
        }
    }
});
