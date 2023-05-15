require('./bootstrap');

import store from './store';
import CustomerList from './components/customer/CustomerList.vue';
import CreateCustomer from './components/customer/CreateCustomer.vue';

new Vue({
    el: '#app',
    store,
    components: {
        'customer-list': CustomerList,
        'create-customer': CreateCustomer,
    },
    data: {
        pageState: 0,
        currentView: 'customer-list',
    },
    computed: {
        title: function() {
            return store.getters.pageTitle;
        }
    },
    mounted: function() {
        this.setPageTitle();
    },
    methods: {
        setPageTitle() {
            store.commit('setPageTitle', 'All Customers');
        },
        showNewCustomerForm() {
            this.pageState = 1;
            this.currentView = 'create-customer';
        },
        hideNewCustomerForm() {
            this.pageState = 0;
            this.currentView = 'customer-list';
            this.setPageTitle();
        }
    }
});
