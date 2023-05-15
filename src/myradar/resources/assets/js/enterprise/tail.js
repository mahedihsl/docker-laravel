require('../bootstrap');

import EventBus from '../util/EventBus';

import TailReport from '../components/enterprise/tail/Table.vue';
import Chart from '../components/enterprise/Chart.vue';

new Vue({
    el: '#app',
    components: {
        TailReport, Chart
    },
    data: {
        type: null,
        record: null,
        current: TailReport,
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
            this.current = TailReport;
        }
    }
});
