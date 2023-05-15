require('../bootstrap');

import Chart from '../components/mileage/Chart';
import Spinner from '../components/mileage/Spinner';
import NotFound from '../components/mileage/NotFound';
import FilterForm from '../components/mileage/FilterForm';

import EventBus from '../util/EventBus';
import Api from '../api/MileageApi';

new Vue({
    el: '#app',
    components: {
        'chart': Chart,
        'spinner': Spinner,
        'not-found': NotFound,
        'filter-form': FilterForm,
    },
    data: {
        content: 'spinner',
        records: [],
    },
    computed: {
        currentProps: function() {
            if (this.content === 'chart') {
                return { items: this.records };
            }
        }
    },
    mounted: function() {
        EventBus.$on('fetch-start', this.onFetchStart.bind(this));
        EventBus.$on('mileage-data-found', this.onDataFound.bind(this));
        EventBus.$on('mileage-no-data', this.onNothingFound.bind(this));
    },
    methods: {
        onFetchStart() {
            this.content = 'spinner';
        },

        onDataFound(list) {
            this.records = list;
            this.content = 'chart';
        },

        onNothingFound() {
            this.content = 'not-found';
        }
    }
});
