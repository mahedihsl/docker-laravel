require('../../bootstrap');

import CustomerForm from '../../components/customer/CustomerForm';
import CustomerList from '../../components/customer/CustomerList';
import EventBus from '../../util/EventBus';
import AccountApi from '../../api/AccountApi';
import store from './store';

new Vue({
    el: '#app',
    store,
    components: {
        CustomerForm,
        CustomerList,
    },
    data: {
      access:{},
    },
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
      EventBus.$on('message-send-done',this.onMessageSendDone.bind(this));
      EventBus.$on('message-access-found',this.onMessageAccessFound.bind(this));
      let api = new AccountApi(EventBus);
      api.messageAccess();
    },
    methods: {
        changeView(k) {
            this.$options.store.commit('changeView', k);
        },
        sendPaymentMessage(){
          if(this.access['bulkMessage']){
            const instance = this;
            $.confirm({
              title: 'Are You Sure ?',
              content: 'Payment message will be sent to every customer',
              type: 'red',
              theme: 'material',
              buttons: {
                confirm: {
                  btnClass: 'btn-red',
                  text: 'Yes, Send',
                  action: function () {
                    instance.$options.store.dispatch('sendPaymentMessage');
                  },
                },
                cancel: function () {

                }
              }
            });
          }
          else{
            this.onAccessDenied();
          }
        },
        sendPaymentMethod(){
          if(this.access['bulkMessage'])
          {
            const instance = this;
            $.confirm({
              title: 'Are You Sure ?',
              content: 'Payment method message will be sent to every customer',
              type: 'red',
              theme: 'material',
              buttons: {
                confirm: {
                  btnClass: 'btn-red',
                  text: 'Yes, Send',
                  action: function () {
                    instance.$options.store.dispatch('sendPaymentMethod');
                  },
                },
                cancel: function () {

                }
              }
            });
          }
          else{
            this.onAccessDenied();
          }

        },
        onMessageSendDone(){
          toastr.success('Message Sent successfully!');
        },
        onMessageAccessFound(data){
          this.access=data;
          //console.log(this.access);
        },
        onAccessDenied(){
          toastr.error('Sorry! you dont have access');
        }
    }
});
