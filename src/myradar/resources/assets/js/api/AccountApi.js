export default class AccountApi {
    constructor(bus) {
        this.EventBus = bus;
    }

    info(id) {
        Vue.http.get(`/user/account/info/${id}`).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('account-info-found', response.body);
            }
        }, error => {});
    }

    toggleEnabled(id) {
        Vue.http.post('/user/account/toggle', {id}).then(response => {
            this.EventBus.$emit('account-info-updated', response.body);
        })
    }

    myCustomerAccess() {
        Vue.http.get(`/customer/access/of/user`).then(response => {
            this.EventBus.$emit('customer-acces-found', response.body.data);
        }, error => {});
    }

    messageAccess() {
        Vue.http.get(`/message/access/of/user`).then(response => {
           // console.log('From AccountApi',response.body.bulkMessage)
            this.EventBus.$emit('message-access-found', response.body.bulkMessage);
        }, error => {});
    }
}
