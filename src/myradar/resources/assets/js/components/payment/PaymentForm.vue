<template lang="html">
    <div class="form">
        <div class="form-group">
          <label for="phone">Phone Number</label>
          <input type="text" class="form-control" name="phone" v-model="phone" id="phone" placeholder="Type Customer Phone">
          <p class="help-block"></p>
        </div>
        <div class="form-group">
          <label for="car">Select Car</label>
          <v-select :value.sync="selectedCar" :options="cars" :on-change="onCarChanged"></v-select>
        </div>
        <div class="form-group">
          <label for="amount">Payment Amount (Tk)</label>
          <input type="text" class="form-control" id="amount" v-model="amount" placeholder="Payment Amount in Taka">
          <p class="help-block"></p>
        </div>
        <div class="form-group">
          <label for="date">Payment Date</label>
          <datepicker v-model="date" name="uniquename" placeholder="Pick Date" input-class="form-control"></datepicker>
          <p class="help-block"></p>
        </div>
        <div class="row no-gutter">
            <div  class="col-md-2" v-for="(month, i) in months" v-on:click="toggleMonth(i)">
                <button class="btn btn-default btn-sm btn-block" v-if="!isChecked(i)">
                    <i class="fa fa-circle-thin"></i> {{month}}
                </button>
                <button class="btn btn-primary btn-sm btn-block" v-if="isChecked(i)">
                    <i class="fa fa-check-circle"></i> {{month}}
                </button>
            </div>
        </div>
        <button type="button" class="btn btn-success pull-right save-button" v-on:click="save">
            <i class="fa fa-save"></i> Save
        </button>
    </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
import vSelect from "vue-select";

import PaymentApi from '../../api/PaymentApi';
import EventBus from '../../util/EventBus';

export default {
    components: {
        Datepicker,
        vSelect,
    },
    data: function () {
        return {
            userId: null,
            phone: '',
            months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            checked: [],
            amount: '',
            cars: [],
            date: '',
            selectedCar: null,
        };
    },
    mounted: function () {
        EventBus.$on('user-found', this.onUserFound.bind(this));
    },
    watch: {
        phone: function (val) {
            if (val.length >= 11) {
                EventBus.$emit('search-user', this.phone);
            }
        }
    },
    methods: {
        save() {
            let api = new PaymentApi(EventBus);
            api.savePayment({
                amount: this.amount,
                months: JSON.stringify(this.checked),
                user_id: this.userId,
                car_id: this.selectedCar.id,
                date: moment(this.date).unix() + (6*3600),
            });
        },

        isChecked(i) {
            return this.checked.indexOf(i) != -1;
        },

        toggleMonth(i) {
            let index = this.checked.indexOf(i);
            if (index == -1) {
                this.checked.push(i);
            } else {
                this.checked.splice(index, 1);
            }
        },

        onUserFound(user) {
            this.userId = user.id;
            this.cars = user.cars;
            if (this.cars.length) {
                this.selectedCar = this.cars[0];
            }
        },

        onCarChanged(val) {
            this.selectedCar = val;
        }
    }
}
</script>

<style lang="css">
.save-button {
    padding-left: 24px;
    padding-right: 24px;
}
</style>
