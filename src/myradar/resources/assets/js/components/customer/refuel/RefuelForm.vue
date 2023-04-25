<template>
    <div class="form">
        <div class="col-xs-12 input-row">
            <div class="form-group">
                <label for="car">Select Car</label>
                <v-select :value.sync="selectedCar" :options="cars" :on-change="onCarChanged"></v-select>
            </div>
        </div>
        <div class="col-xs-12 input-row">
            <strong>Select Refuel Type</strong><br>
            <div class="col-xs-6 icon-box" :class="{selected: type == 0}" @click="selectType(0)">
                <img src="/images/fuel.png" alt="" class="img img-responsive icon-image">
                <span class="icon-label text-center">FUEL</span>
            </div>
            <div class="col-xs-6 icon-box" :class="{selected: type == 1}" @click="selectType(1)">
                <img src="/images/gas.png" alt="" class="img img-responsive icon-image">
                <span class="icon-label text-center">GAS</span>
            </div>
        </div>
        <div class="col-xs-12 input-row">
            <label for="car">Select Method</label>
            <v-select :value.sync="selectedMethod" :options="method" :on-change="onMethodChanged"></v-select>
        </div>
        <div class="col-xs-12 input-row">
            <div class="form-group">
                <label for="data">{{prompt}}</label>
                <input type="text" class="form-control" id="data" v-model="amount">
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-md-offset-3 input-row">
            <button class="btn btn-success btn-block" @click="saveLog">
                <i class="fa fa-refresh fa-spin" v-show="loading"></i> Save
            </button>
        </div>
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
        type: 0,
        method: 0,
        amount: '',
        loading: false,
        cars: [],
        method: [
            {id: 0, label: 'Refuel'},
            {id: 1, label: 'Reserve'},
        ],
        selectedCar: null,
        selectedMethod: null,
    }),
    computed: {
        prompt: function() {
            let messages = [[
                    'How many Liter you took ?',
                    'What is fuel meter percentage ?',
                ], [
                    'How much money you spent for gas refueling ?',
                    'How many Green Lights are on gas meter ?'
                ]
            ];
            let j = !this.selectedMethod ? 0 : this.selectedMethod.id;
            return messages[this.type][j];
        }
    },
    mounted() {
        EventBus.$on('refuel-log-saved', this.onSuccess.bind(this));
        EventBus.$on('refuel-log-not-saved', this.onError.bind(this));
        EventBus.$on('customer-data-found', this.onUserDataFound.bind(this));

        this.selectedMethod = this.method[0];

        let api = new CustomerApi(EventBus);
        api.data(this.userid);
    },
    methods: {
        saveLog() {
            this.loading = true;
            let api = new RefuelApi(EventBus);
            let data = {
                type: this.type,
                method: this.selectedMethod.id,
                amount: this.amount,
                car_id: this.selectedCar.id,
            };
            api.saveLog(data);
        },

        selectType(t) {
            this.type = t;
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

        onMethodChanged(val) {
            this.selectedMethod = val;
        },
    }
}
</script>
<style scoped>
.icon-box {
    border: 1px solid #E0E0E0;
    border-radius: 3px;
    padding: 0;
    cursor: pointer;
}
.icon-image {
    width: 50%;
    height: auto;
    display: block;
    margin: 10px auto 10px auto;
}
.icon-label {
    width: 100%;
    display: block;
    font-weight: bold;
    color: #3F51B5;
    font-size: 14px;
    padding: 10px 0;
    border-top: 1px solid #E0E0E0;
}
.selected {
    background: #EEEEEE;
}
.selected > span {
    background: #3F51B5;
    color: #fafafa;
}
.input-row {
    margin: 12px 0;
}
</style>
