require('../bootstrap');

import History from '../components/customer/refuel/RefuelHistory.vue';
import RefuelForm from '../components/customer/refuel/RefuelForm.vue';

import EventBus from '../util/EventBus';
import Api from '../api/CustomerApi';

new Vue({
    el: '#app',
    components: {
        History,
        RefuelForm,
    },
    data: {
        userId: null,
    },
    computed: {

    },
    beforeMount() {
        this.userId = $('input[name="user_id"]').val();
    },
    mounted() {

    },
    methods: {

    }
});
