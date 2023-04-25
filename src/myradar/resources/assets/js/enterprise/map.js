require('../bootstrap');

import store from './store/map';

import MapView from '../components/enterprise/map/MapView.vue';

new Vue({
    el: '#app',
    store,
    components: {
        MapView,
    },
    data: {
        userId: null,
    },
    computed: {

    },
    beforeMount() {
      this.userId = $('input[name="user_id"]').val();
      this.$options.store.commit('userId', this.userId);
    },
    mounted() {

    },
    methods: {

    }
});
