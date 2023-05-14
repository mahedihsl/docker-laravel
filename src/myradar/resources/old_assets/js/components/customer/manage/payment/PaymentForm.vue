<template lang="html">
  <div class="form col-md-8 col-md-offset-2">
      <div class="form-group">
        <label for="car">Select Car</label>
        <small class="pull-right sm-info">monthly bill: <span class="text-red"><b>{{carBill}}</b></span> </small>
        <small class="pull-right sm-info">prev extra: <span class="text-blue"><b>{{prevExtra}}</b></span> </small>
				<select class="form-control" v-model="selectedCar">
					<option v-for="c in cars" :value="{id: c.id, label: c.label}">{{c.label}}</option>
				</select>
      </div>

      <div class="form-group">
        <label for="amount">Payment Amount (Tk)</label>
        <input type="text" class="form-control" id="amount" v-model="amount" placeholder="Payment Amount in Taka">
        <p class="help-block"></p>
      </div>

      <div class="form-group">
        <label for="amount">Spare Amount (Tk)</label>
        <div class="form-inline">

          <input type="text" class="form-control" id="spare-amount" v-model="spareAmount" placeholder="spareAmount" readonly/>

          <input type="radio" id="extra" value="extra" v-model="spareType">
          <label for="extra">Extra</label>

          <input type="radio" id="waive" value="waive" v-model="spareType">
          <label for="waive">Waive</label>
        </div>


        <p class="help-block"></p>
      </div>

      <div class="form-group">
        <label for="date">Payment Date</label>
        <datepicker v-model="date" :highlighted="[new Date()]" name="uniquename" placeholder="Pick Date" input-class="form-control"></datepicker>
        <p class="help-block"></p>
      </div>

			<div class="form-group">
        <label for="note">Note</label>
        <input type="text" name="note" class="form-control" v-model="note" value="">
        <p class="help-block"></p>
      </div>

      <div class="form-group">
        <label for="car">Payment Type</label>
				<select class="form-control" v-model="paymentType">
					<option v-for="c in types" :value="{id: c.id, label: c.label}">{{c.label}}</option>
				</select>
        <!-- <v-select :value.sync="paymentType" :options="types" :on-change="onTypeChanged"></v-select> -->
      </div>

      <div class="form-group">
        <label for="car">Select Year</label>
				<select class="form-control" v-model="selectedYear">
					<option v-for="c in years" :value="c">{{c}}</option>
				</select>
        <!-- <v-select :value.sync="selectedYear" :options="years" :on-change="onYearChanged"></v-select> -->
      </div>

      <div class="form-group">
        <p>Activation Date: <span class="text-red">{{activationDate}}</span></p>
      </div>

      <div class="row no-gutter">
          <div  class="col-md-2" v-for="(month, i) in months" v-on:click="toggleMonth(i)">
              <button class="btn btn-primary btn-sm btn-block disabled" disabled v-show="isPaid(i)">
                  <i class="fa fa-check-circle"></i> {{month}}
              </button>
              <button class="btn btn-default btn-sm btn-block" v-show="!isChecked(i) && !isPaid(i)">
                  <i class="fa fa-circle-thin"></i> {{month}}
              </button>
              <button class="btn btn-primary btn-sm btn-block" v-show="isChecked(i) && !isPaid(i)">
                  <i class="fa fa-check-circle"></i> {{month}}
              </button>
          </div>
      </div>

      <button type="button" class="btn btn-success pull-right save-button" v-on:click="save" :disabled="isDisabled">
          <i class="fa fa-save"></i> Save
      </button>
  </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
// import vSelect from "vue-select";
import store from '../../../../customer/index/store.js';
import moment from 'moment';

import PaymentApi from '../../../../api/PaymentApi';
import EventBus from '../../../../util/EventBus';

export default {
  props: ['phone'],
  store,
  components: {
      Datepicker,
      // vSelect,
  },
  data: () => ({
      userId: null,
      months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      checked: [],
      paid:[],
      amount: '',
      cars: [],
      date: new Date(),
			note: '',
      selectedCar: null,
      loading: false,
      types: [
        {id: 1, label: 'Cash'},
        {id: 2, label: 'bKash'},
        {id: 9, label: 'bKash (907)'},
        {id: 10, label: 'bKash (909)'},
        {id: 3, label: 'bKash Personal'},
        {id: 4, label: 'Rocket'},
        {id: 5, label: 'Rocket Personal'},
        {id: 6, label: 'Bank'},
        {id: 7, label: 'Visa'},
        {id: 8, label: 'MasterCard'},
      ],
      paymentType: null,
      years:['2018', '2019','2020','2021','2022', '2023', '2024', '2025'],
      selectedYear: '2022',
      payments:[],
      activationDate:"",
      carBill: '',
      spareMoney: 0,
      spareType:'',
      extraMoney: 0,
      waiveMoney: 0,
      prevExtra: 0,
  }),
  computed:{
    isDisabled(){
      return this.loading;
    },
    spareAmount(){
      this.spareMoney = this.carBill*this.checked.length - this.prevExtra - this.amount;
      if(this.spareMoney < 0){
        this.spareType = 'extra';
        this.spareMoney*=-1;
        this.extraMoney = this.spareMoney;
        this.waiveMoney = 0;
      }
      else{
        this.spareType = 'waive';
        this.waiveMoney = this.spareMoney;
        this.extraMoney = 0;
      }

      return this.spareMoney;
    }
  },
	watch: {
		selectedCar: function(newVal, oldVal) {
			this.changeMonthsStatus();
		},
		selectedYear: function(newVal, oldVal) {
			this.changeMonthsStatus();
		}
	},
  mounted() {
      EventBus.$on('user-found', this.onUserFound.bind(this));
      EventBus.$on('bill-save-start', this.onSaveStart.bind(this));
      EventBus.$on('bill-save-finish', this.onSaveFinish.bind(this));
      EventBus.$on('payments-found', this.onPaymentsFound.bind(this));

      if (this.phone.length >= 11) {
          let api = new PaymentApi(EventBus);
          api.findCustomer(this.phone);
      }

      this.paymentType = this.types[0];

  },
  methods: {
      save() {
          this.loading = true;
          let api = new PaymentApi(EventBus);
          api.savePayment({
              amount: this.amount,
              months: JSON.stringify(this.checked.sort((a, b) => a - b)),
              year: this.selectedYear,
              user_id: this.userId,
              car_id: this.selectedCar.id,
              date: moment(this.date).unix(),
							note: this.note,
              extra: this.extraMoney,
              waive: this.waiveMoney,
              type: this.paymentType.id,
          });
      },

      isChecked(i) {
          return this.checked.indexOf(i) != -1;
      },

      isPaid(i){
        return this.paid.indexOf(i) != -1;
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
          let api = new PaymentApi(EventBus);
          api.getPayments(this.userId);
      },

      onPaymentsFound(data){
        this.payments = data;

        this.changeMonthsStatus();
      },

      changeMonthsStatus(){
          this.paid = [];
          var payment = this.payments.find(o => o.reg_no == this.selectedCar.label);
          if(payment === undefined) return;

          this.activationDate = payment.date;
          this.carBill = payment.bill;

          this.prevExtra = payment.last_payment ? payment.last_payment.extra : 0;
          if(this.prevExtra === undefined)
            this.prevExtra = 0;


          var mon = payment.mon;
          mon.forEach(function(item){
            if(item[1] == this.selectedYear){
              this.paid.push(item[0]);
            }
          }.bind(this));


      },
      onSaveStart() {
          this.loading = true;
      },

      onSaveFinish(flag) {
          this.loading = false;
          if (flag) {
            this.$options.store.commit('changeView',0);
            toastr.success('Payment Received');
          } else {
              toastr.error('Error ! Try Again');
          }
      }
  }
}
</script>

<style lang="css">
.disabled{
  margin-top: 5px;
}
.save-button {
  padding-left: 24px;
  padding-right: 24px;
  margin-bottom: 4px;
  margin-top: 4px;
}
#extra, #waive{
  margin-left: 15px;
}

.sm-info{
  padding-left: 2px;
  padding-right: 2px;
}
</style>
