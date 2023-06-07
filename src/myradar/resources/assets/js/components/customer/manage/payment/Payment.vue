<template>
  <div>
    <h3 class="ash-divider">
      {{title}}

     <button v-show="!current" class="btn btn-primary pull-right" @click="changeView(1)">
       New Payment
      </button>
      <button v-show="!current" class="btn btn-primary pull-right" @click="getMsgContent()">
         Payment SMS
      </button>
      <button v-show="!current" class="btn btn-primary pull-right" @click="getPaymentMethod()">
        Payment Method
      </button>

      <button v-show="current" class="btn btn-default pull-right" @click="changeView(0)">
        <i class="fa fa-arrow-left"></i> Back
      </button>

      <div class="pull-right" style="font-size: 16px;">
        Total Due: <span class="text-error">{{totalDue}} Taka </span> 
      </div>

    </h3>
     <component :is="currentView" :customer="customer" v-bind="currProps"></component>

     <modal name="info" :scrollable="true" height="auto">
       <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12 modal-title">
         <h3>Message</h3>
       </div>
       <div class="col-xs-12 modal-content">
         <textarea id="textarea1"
                   class="col-sm-12 col-lg-12 col-xs-12 col-md-12 "
                   v-model="paymentSMS"
                   rows="15"
                   placeholder="Enter something">
        </textarea>
       </div>
       <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12 modal-footer">
         <button @click="hide" class="btn btn-default" type="button" name="button">Cancel</button>
         <button @click="send" class="btn btn-primary" type="button" name="button">
           <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Send
         </button>
       </div>
       <!-- <p>{{paymentSMS}}</p> -->
     </modal>
  </div>
</template>

<script>
import store from '../../../../customer/index/store.js';
import EventBus from '../../../../util/EventBus';
import PaymentApi from '../../../../api/PaymentApi';
import PaymentForm from './PaymentForm.vue';
import PaymentList from './PaymentList.vue';

export default {
    props: ['customer'],
    store,
    components: {
        PaymentForm,
        PaymentList
    },
    data: () => ({
        paymentSMS: "",
        totalDue: '',
        //current: 'payment-form',
    }),
    computed: {
        current(){
          return this.$options.store.state.current;
        },
        currentView(){
          return this.current ? PaymentForm : PaymentList;
        },
        title(){
          return this.current ? 'Payment Form' : 'Payment History';
        },
        currProps() {
            if (this.current == 1) {
                return {phone: this.customer.phone};
            }
        },
    },
    mounted() {
      //EventBus.$on('get-message-content-start',this.onMessageSendStart.bind(this));
      EventBus.$on('message-content-received',this.onMessageContentReceived.bind(this));
      EventBus.$on('total-due-received', this.onTotalDueReceived.bind(this));

      let api = new PaymentApi(EventBus);
      api.getTotalDue(this.customer.id);
    },
    methods: {
      changeView(k){
        this.$options.store.commit('changeView',k);
      },
      getMsgContent(){
        let api= new PaymentApi(EventBus);
        api.getMsgContent(this.customer.id);
      },
      send(){
        let api= new PaymentApi(EventBus);
        api.sendMessage(this.customer.id, this.paymentSMS);
        toastr.success('Message Sent successfully!');
      },
      getPaymentMethod(){
        let api= new PaymentApi(EventBus);
        api.getPaymentMethod(  this.customer.id);
      },
      onTotalDueReceived(total) {
        this.totalDue = total;
      },
      onMessageContentReceived(data){
        this.paymentSMS = data;
        this.$modal.show('info');

      },
      hide(){
        this.$modal.hide('info');
      },

    }
}
</script>
<style lang="scss" scoped>
  .btn-primary{
    margin-left: 3px;
  }
  .modal-title{
    text-align: center;
    color: #ffffff;
    background-color: #2F87BF;
  }
  .modal-title h3{
    margin-top: 0px;
    margin-bottom: 0px;
    padding-top: 10px;
    padding-bottom: 5px;
  }
  .modal-content{
    margin: 4px;
  }
  .modal-content textarea{
    border-radius: 1em;
    overflow: hidden;
    resize: none;
  }
  .modal-footer{
    text-align: center;
  }
  .modal-footer button{
    margin-left: 5px;
    margin-right: 5px;
  }


</style>
