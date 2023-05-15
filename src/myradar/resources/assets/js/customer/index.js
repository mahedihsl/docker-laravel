require('../bootstrap');

import CustomerForm from '../components/customer/CustomerForm';
import CustomerList from '../components/customer/CustomerList';

import store from './store/index';

new Vue({
    el: '#app',
    store,
    components: {
        CustomerForm,
        CustomerList,
    },
    data: {},
    computed: {
        current() {
            return this.$options.store.state.current;
        },
        currentView() {
            return this.current ? CustomerForm : CustomerList;
        },
        title() {
            return this.current ? 'New Customer' : 'All Customers';
        }
    },
    mounted() {

    },
    methods: {
        changeView(k) {
            this.$options.store.commit('changeView', k);
        }
    }
});
