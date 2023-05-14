import Error from '../util/Error';

export default class CustomerApi {
    constructor(bus) {
        this.EventBus = bus;
    }

    static search(data) {
        return new Promise(function(resolve, reject) {
            let params = {
                page    : data.page,
                name    : data.name,
                phone   : data.phone,
                reg_no  : data.reg_no,
                ref_no  : data.ref_no,
            };
            Vue.http.get('/customers/api', {params}).then(
                response => resolve({
                    list: response.body.data,
                    pagination: response.body.meta.pagination
                }),
                error => reject(error));
        })
    }

    static save(data) {
        // console.log('save request dispatched');
        
        return new Promise(function(resolve, reject) {
            Vue.http.post('/customer/save', data).then(response => {
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

    static getToggleHistory(id) {
        return new Promise(function(resolve, reject) {
            Vue.http.get(`/customer/toggle-history/${id}`).then(response => {
                if (response.body.status == 1) {
                    resolve(response.body.data)
                }
            }, error => {})
        })
    }

    update(info) {
        let data = {
            id: info.id,
            name: info.name,
            email: info.email,
            phone: info.phone,
            address: info.address,
            type: info.type,
            ref_no: info.ref_no,
            status: info.status,
        };
        Vue.http.post(`/customer/update`, data).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('profile-update-done', response.body.data);
            } else {
                this.EventBus.$emit('profile-update-error', 200, 'Error, Try Again');
            }
        }, error => {
            if (error.status == 422) {
                let res = new Error(error);
                this.EventBus.$emit('profile-update-error', 422, res.validationError());
            }

        })
    }

    password(id, pass1, pass2) {
        let data = {
            id,
            password: pass1,
            password_confirmation: pass2,
        };
        Vue.http.post(`/customer/password/change`, data).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('password-update-done');
            } else {
                this.EventBus.$emit('password-update-error', 200, 'Error, Try Again');
            }
        }, error => {
            if (error.status == 422) {
                let res = new Error(error);
                this.EventBus.$emit('password-update-error', 422, res.validationError());
            }

        })
    }

    info(id) {
        Vue.http.get(`/customer/info/${id}`).then(response => {
            this.EventBus.$emit('customer-info-found', response.body.data);
        }, error => {})
    }

    data(id) {
        Vue.http.get(`/customer/data/${id}`).then(response => {
            this.EventBus.$emit('customer-data-found', response.body.data);
        }, error => {});
    }

    getSettings(id) {
        Vue.http.get(`/customer/settings/${id}`).then(response => {
            this.EventBus.$emit('customer-settings-found', response.body.data);
        }, error => {})
    }

    updateSettings(data) {
        Vue.http.post(`/customer/settings/change`, data).then(response => {
            this.EventBus.$emit('customer-settings-changed');
        }, error => {})
    }

    cars(userId) {
        Vue.http.get(`/user/car/names/${userId}`).then(response => {
            this.EventBus.$emit('car-names-found', response.body.data);
        }, error => {})
    }

    customerIds(){
      Vue.http.get(`/customer/ids`).then(response => {
          this.EventBus.$emit('customer-ids-found', response.body.data);
      }, error => {})
    }

}
