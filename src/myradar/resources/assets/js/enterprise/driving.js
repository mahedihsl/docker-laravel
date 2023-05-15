require('../bootstrap');

import EventBus from '../util/EventBus';
import store from './store/driving';

import DrivingReport from '../components/enterprise/driving/Table.vue';
import Chart from '../components/enterprise/Chart.vue';

new Vue({
    el: '#app',
    store,
    components: {
        DrivingReport, Chart,
    },
    data: {
        type: null,
        record: null,
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
                    record: this.record,
                };
            }
        },
    },
    mounted() {
        EventBus.$on('show-chart', this.onReportClick.bind(this));
    },
    methods: {
        onReportClick(type, record) {
            this.type = type;
            this.record = record;
            this.current = Chart;
        },

        dismiss() {
            this.current = DrivingReport;
        }
    }
});
