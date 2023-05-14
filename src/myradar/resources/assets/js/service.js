import ServiceList from './components/service/ServiceList.vue';
require('./bootstrap');

new Vue({
    el: '#app',
    components: {
        'service-list': ServiceList,
    }
});
