require('../bootstrap');

import PaymentForm from '../components/payment/PaymentForm';
import UserPlaceholder from '../components/payment/UserPlaceholder';
import UserNotFound from '../components/payment/UserNotFound';
import UserInfo from '../components/payment/UserInfo';
import Spinner from '../components/payment/Spinner';

import EventBus from '../util/EventBus';
import Api from '../api/PaymentApi';

new Vue({
    el: '#app',
    components: {
        'payment-form': PaymentForm,
        'placeholder': UserPlaceholder,
        'not-found': UserNotFound,
        'user-info': UserInfo,
        'spinner': Spinner,
    },
    data: {
        rightPanel: 'placeholder',
        user: {},
    },
    computed: {
        currentProperties: function() {
            if (this.rightPanel === 'user-info') {
                return { info: this.user };
            }
        }
    },
    mounted: function () {
        EventBus.$on('search-user', this.searchUser.bind(this));
        EventBus.$on('user-found', this.showUserInfo.bind(this));
        EventBus.$on('not-found', this.onUserNotFound.bind(this));
    },
    methods: {
        showSpinner () {
            this.rightPanel = 'spinner';
        },

        showUserInfo (data) {
            this.rightPanel = 'user-info';
            this.user = data;
        },

        onUserNotFound () {
            this.rightPanel = 'not-found';
        },

        searchUser (phone) {
            this.showSpinner();
            let api = new Api(EventBus);
            api.findCustomer(phone);
        }
    },
})
