<template>
    <div class="form">
        <div class="form-group">
            <label for="car">Select Car</label>
            <v-select :value.sync="selectedCar" :options="cars" :on-change="onCarChanged"></v-select>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="">Select Fuel Type</label>
                <div class="radio">
                    <label><input type="radio" value="0" v-model="type">Fuel</label>
                </div>
                <div class="radio">
                    <label><input type="radio" value="1" v-model="type">Gas</label>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="">Select Input Type</label>
                <div class="radio">
                    <label><input type="radio" value="0" v-model="method">Refuel</label>
                </div>
                <div class="radio">
                    <label><input type="radio" value="1" v-model="method">Reserve</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="data">{{prompt}}</label>
            <input type="text" class="form-control" id="data" v-model="amount">
        </div>
        <button class="btn btn-success" @click="saveLog">
            <i class="fa fa-refresh fa-spin" v-show="loading"></i> Save
        </button>
    </div>
</template>
<script>
import vSelect from "vue-select";

import EventBus from '../../../util/EventBus';
import RefuelApi from '../../../api/RefuelApi';
import CustomerApi from '../../../api/CustomerApi';

export default {
    props: ['userid'],
    components: {
      vSelect,
  },
    data: () => ({
        type: '0',
        method: '0',
        amount: '',
        loading: false,
        cars: [],
        selectedCar: null,
    }),
    computed: {
        prompt: function() {
            let messages = [[
                    'How Many Liter did you refueled ?',
                    'What is your remaining fuel percentage ?',
                ], [
                    'How much money you spent for gas refueling ?',
                    'How many Lights are On at your gas meter ?'
                ]
            ];
            return messages[parseInt(this.type)][parseInt(this.method)];
        }
    },
    mounted() {
        EventBus.$on('refuel-log-saved', this.onSuccess.bind(this));
        EventBus.$on('refuel-log-not-saved', this.onError.bind(this));
        EventBus.$on('customer-data-found', this.onUserDataFound.bind(this));

        let api = new CustomerApi(EventBus);
        api.data(this.userid);
    },
    methods: {
        saveLog() {
            this.loading = true;
            let api = new RefuelApi(EventBus);
            let data = {
                type: this.type,
                method: this.method,
                amount: this.amount,
                car_id: this.selectedCar.id,
            };
            api.saveLog(data);
        },

        onUserDataFound(user) {
            this.cars = user.cars;
            if (this.cars.length) {
                this.selectedCar = this.cars[0];
            }
        },

        onSuccess() {
            this.loading = false;
            EventBus.$emit('get-refuel-logs', this.selectedCar.id);
        },

        onError() {
            this.loading = false;
        },

        onCarChanged(val) {
            this.selectedCar = val;
            EventBus.$emit('get-refuel-logs', this.selectedCar.id);
        },
    }
}
</script>
<style scoped>
</style>
