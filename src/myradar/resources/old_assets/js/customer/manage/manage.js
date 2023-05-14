require('../../bootstrap');

import Sidebar from '../../components/customer/manage/Sidebar';
import ManageContent from '../../components/customer/manage/ManageContent';

import EventBus from '../../util/EventBus';
import store from './store';

new Vue({
    el: '#app',
    store,
    components: {
        Sidebar,
        ManageContent,
    },
    data: {

    },
    computed: {

    },
    mounted() {

    },
    methods: {

    }
});
