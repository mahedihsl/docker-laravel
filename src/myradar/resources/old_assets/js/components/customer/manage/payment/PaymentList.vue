<template>
  <div class="col-md-12">
    <table class="paymentTable table table-striped">
      <thead>
        <tr class="paymentrow row">
          <th class="col-md-1 col-lg-1">#</th>
          <th class="col-md-2 col-lg-2">Name</th>
          <th class="col-md-1 col-lg-2">Vehicle No.</th>
          <th class="col-md-1 col-lg-2">Paid on</th>
          <th class="col-md-1 col-lg-2">Input on</th>
          <th class="col-md-1 col-lg-1">Method</th>
          <th class="col-md-2 col-lg-2">Amount</th>
          <th class="col-md-1 col-lg-1">Spare(Tk)</th>
          <th class="col-md-2 col-lg-2">Valid Months</th>
        </tr>
      </thead>
      <tbody>
        <tr class="row" v-for="(payment,i) in modifiedPay">
          <td v-bind:class="{ auto: isAuto(payment), bkash: isBkash(payment) }">{{i+1}}</td>
          <td>{{payment.user.name}}</td>
          <td>{{payment.car.reg_no}}</td>
          <td>{{payment.paid_on}}</td>
					<td>{{payment.input_on}}</td>
          <td>{{payment.method}}</td>
          <td>{{payment.pay.toFixed(1)}} Taka</td>
          <td>
          	<span v-if="isExtra(payment)" class="label label-primary">extra = {{payment.extraAmount}}tk</span>
						<span v-if="isWaived(payment)" class="label label-primary">waived = {{payment.waivedAmount}}tk</span><br>
						<button v-if="payment.note" class="btn btn-link" @click="showNote(payment.note)">Note</button>
          </td>
          <td>
            <span class="month-label label label-primary">
              {{months[payment.mon[0]]}}'{{payment.mon[1]}}
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import EventBus from '../../../../util/EventBus';
import PaymentApi from '../../../../api/PaymentApi';
import CustomerApi from '../../../../api/CustomerApi';
import Swal from 'sweetalert2';
import moment from 'moment';
export default {
  props: ['customer'],
  name: "",
  data: () => ({
    payments:[],
    modifiedPayList:[],
    months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    types: [
      {id: 1, label: 'Cash'},
      {id: 2, label: 'bKash'},
      {id: 3, label: 'bKash Personal'},
      {id: 4, label: 'Rocket'},
      {id: 5, label: 'Rocket Personal'},
      {id: 6, label: 'Bank'},
      {id: 7, label: 'Visa'},
      {id: 8, label: 'MasterCard'},
      {id: 9, label: 'bKash (907)'},
      {id: 10, label: 'bKash (909)'},
    ],
  }),
  mounted(){
    EventBus.$on('payment-list-found',this.paymentListFound.bind(this));
    let api= new PaymentApi(EventBus);
    api.paymentList(this.customer.id).then(data => {
      this.paymentListFound(data);
    },error => {});
  },
  computed:{
    modifiedPay(){
      return this.modifiedPayList;
    }
  },
  methods:{
    paymentListFound(data)
    {
      //console.log(this.payments);
      this.payments=data;
      //console.log(data);
      for(let i in this.payments)
      {
        this.payments[i].method = '--';
        if (!!this.payments[i].type && this.payments[i].type > 0) {
          this.payments[i].method = this.types[this.payments[i].type - 1].label;
        }
        this.payments[i].paid_on=moment(this.payments[i].paid_on).format('DD MMM YY');
				this.payments[i].input_on=moment(this.payments[i].created_at).format('DD MMM YY');
        //console.log(this.payments[i].amount);
        if(this.payments[i].extra)
          this.payments[i].amount -= this.payments[i].extra;
        else if(this.payments[i].waive)
          this.payments[i].amount += this.payments[i].waive;

        //console.log(this.payments[i].amount);

        for(let j in this.payments[i].months)
        {

          this.payments[i].months[j][1]%=100;  //valid month 2018->18
          var obj = this.payments[i];

          var length = 1;
          obj["mon"] = this.payments[i].months[j];
          if(Array.isArray(this.payments[i].months)){
            length = this.payments[i].months.length;
          }
          else{
            length = Object.keys(this.payments[i].months).length;
          }
          obj["pay"] = this.payments[i].amount / length;

          if(this.payments[i].extra && j == this.payments[i].months.length-1){
            obj["pay"] += this.payments[i].extra;
            obj["isExtra"] = true;
            obj["extraAmount"] = this.payments[i].extra;
          }

          if(this.payments[i].waive && j == this.payments[i].months.length-1){
            obj["pay"] -= this.payments[i].waive;
            obj["isWaived"] = true;
            obj["waivedAmount"] = this.payments[i].waive;
          }

          this.modifiedPayList.push(JSON.parse(JSON.stringify(obj)));
        }
      }

      //console.log(this.modifiedPayList);
      this.modifiedPayList = this.modifiedPayList.sort(function(a,b){
                               if (a.mon[1] < b.mon[1] || a.mon[1] == b.mon[1] && a.mon[0] < b.mon[0])
                                  return 1;
                               else if (a.mon[1] == b.mon[1] && a.mon[0] == b.mon[0])
                                  return 0;
                               else
                                  return -1;
                             });
    },
    isAuto(payment)
    {
      return Object.keys(payment).includes('auto');
    },
    isBkash(payment)
    {
      return Object.keys(payment).includes('bkash');
    },
    isExtra(payment)
    {
      return Object.keys(payment).includes('isExtra');
    },
    isWaived(payment)
    {
      return Object.keys(payment).includes('isWaived');
    },
		showNote(msg) {
			Swal.fire({
			  title: 'Note',
				text: msg,
			  showClass: {
			    popup: 'animated fadeInDown faster'
			  },
			  hideClass: {
			    popup: 'animated fadeOutUp faster'
			  }
			})
		}

  }
}
</script>
<style lang="scss" scoped>
.paymentTable{
  width: 100%;
}
.month-label{
  margin-left: 5%;
}
.paymentrow{
  border-bottom:20px;
}

.auto{
  border-left: 2px solid #2B7AAB;
  color: #2B7AAB;
}
.bkash{
  border-left: 2px solid #e53935;
  color: #e53935;
}
.extra{
  background-color: blue;
}
td,th{
    text-align: center;
}
</style>
