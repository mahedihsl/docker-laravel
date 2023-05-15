require('../bootstrap');

import Switcher from '../components/customer/service/Switcher.vue';
import Loader from '../components/util/Loader.vue';

import Engine from '../components/customer/service/Engine.vue';
// import Fuel from '../components/customer/service/Fuel.vue';
import Gas from '../components/customer/service/Gas.vue';
import Mileage from '../components/customer/service/Mileage.vue';

// import FuelChart from '../components/customer/service/FuelChart.vue';
// import GasChart from '../components/customer/service/GasChart.vue';
import GasView from '../components/customer/service/GasView.vue';

import EventBus from '../util/EventBus';
import CarApi from '../api/CarApi';

new Vue({
    el: '#app',
    components: {
        Switcher,
        Loader,
        Engine,
        // Fuel,
        Gas,
        Mileage,
        // FuelChart,
        // GasChart,
        GasView,
    },
    data: {
        userId: $('input[name="user_id"]').val(),
        loading: false,
        car: null,
    },
    computed: {
        engine() {
            return this.car.services.indexOf(2) != -1;
        },

        fuel() {
            return this.car.services.indexOf(3) != -1;
        },

        gas() {
            return this.car.services.indexOf(4) != -1;
        },

        mileage() {
            return this.car.services.indexOf(5) != -1;
        }
    },
    mounted() {
        EventBus.$on('car-list-empty', this.onEmptyCarList.bind(this));
        EventBus.$on('car-switched', this.onCarSwitched.bind(this));
        EventBus.$on('car-details-found', this.onCarDetailsFound.bind(this));
    },
    methods: {
        onEmptyCarList() {

        },

        onCarSwitched(car) {
            this.loading = true;
            let api = new CarApi(EventBus);
            api.find(car.id);
        },

        onCarDetailsFound(data) {
            this.car = data;
            this.loading = false;
        }
    }
});
