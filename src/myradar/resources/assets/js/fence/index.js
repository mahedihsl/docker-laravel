require('../bootstrap');

import EventBus from '../util/EventBus';
import Api from '../api/FenceApi';

import FenceLogList from '../components/fence/FenceLogList';
import CustomFence from '../components/fence/CustomFence';
import SearchFence from '../components/fence/SearchFence';

new Vue({
    el: '#app',
    components: {
        'fence-list': FenceLogList,
        'search-fence': SearchFence,
        'custom-fence': CustomFence,
    },
    data: {
        current: 'fence-list',
    },
    computed: {

    },
    mounted() {
        EventBus.$on('add-new-click', this.showListChooser.bind(this));
        EventBus.$on('go-back-click', this.showFenceHistory.bind(this));
    },
    methods: {
        showFenceHistory() {
            this.current = 'fence-list';
        },

        showListChooser() {
            this.current = 'search-fence';
        },

        showMapChooser() {
            this.current = 'custom-fence';
        },
    },
})
