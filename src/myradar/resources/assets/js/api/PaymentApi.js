export default class PaymentApi {
    constructor(bus) {
        this.EventBus = bus;
    }

    findCustomer(phone) {
        Vue.http.get(`/find/customer/${phone}`).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('user-found', response.body);
            } else {
                this.EventBus.$emit('not-found');
            }
        }, error => {})
    }

    getPayments(userId) {
        Vue.http.get(`/get/payments/${userId}`).then(response => {
            this.EventBus.$emit('payments-found', response.body.data);
        }, error => {})
    }

    savePayment(data) {
        this.EventBus.$emit('bill-save-start');
        Vue.http.post('/save/payment', data).then(response => {
            this.EventBus.$emit('bill-save-finish', response.body.status == 1);
        }, error => {})
    }

    paymentList(userId){
      return new Promise((resolve, reject) => {
        Vue.http.get(`/payment/paymentlist/${userId}`).then(response =>
          response.body.status ? resolve(response.body.data): reject(), error => reject())
      })
    }

    getMsgContent(userId){
      this.EventBus.$emit('get-message-content-start');
      Vue.http.get(`/payment/message/${userId}`).then(response => {
        this.EventBus.$emit('message-content-received',response.body.data);
      }, error => {})
    }

    getTotalDue(userId){
      Vue.http.get(`/payment/total-due/${userId}`).then(response => {
        this.EventBus.$emit('total-due-received',response.body.data.total);
      }, error => {})
    }

    sendMessage(userId, content){
      this.EventBus.$emit('message-send-start');
      Vue.http.post(`/payment/sms/send`,{id:userId, content:content}).then(response => {
        console.log(response.body);
        this.EventBus.$emit('message-send-done',response.body.data);
      }, error => {})
    }

    sendMessageAll(){
      return new Promise(function(resolve, reject) {
          Vue.http.get('/payment/message').then(response => {
              if (response.body.status == 1) {
                  resolve(response.body.data);
              }
          }, error => {
              if (error.status == 422) {
                  let res = new Error(error);
                  reject(res.validationError());
              }
          });
      })
    }

    getPaymentMethod(userId){
      this.EventBus.$emit('message-send-start');
      Vue.http.get(`/payment/method/sms/${userId}`).then(response => {
        this.EventBus.$emit('message-content-received',response.body.data);
      }, error => {})
    }

    sendMethodAll(){
      return new Promise(function(resolve,reject){
        Vue.http.get('/payment/method/sms').then(response => {
            if (response.body.status == 1) {
                resolve(response.body.status);
            }
        }, error => {
            if (error.status == 422) {
                let res = new Error(error);
                reject(res.validationError());
            }
        });
      })
    }
}
