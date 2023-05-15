export default class CarApi {
    constructor(bus) {
        this.EventBus = bus;
    }

    search(page, regNo, comId, phone) {
        let url = `/vehicles/search?page=${page}`;
        if (regNo) url += `&reg=${regNo}`;
        if (comId) url += `&com=${comId}`;
        if (phone) url += `&phone=${phone}`;
        Vue.http.get(url).then(response => {
            this.EventBus.$emit('car-list-found', response.body.data, response.body.meta.pagination);
        })
    }

    find(id) {
        Vue.http.get(`/car/details/${id}`).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('car-details-found', response.body.data);
            }
        }, error => {})
    }

    save(data) {
        Vue.http.post(`/car/save`, data).then(response => {
            if(response.body.status == 1)
              this.EventBus.$emit('car-save-done', response.body.data);
            else if(response.body.status == 0)
              this.EventBus.$emit('promo-invalid', response.body.data);
        }, error => {
            if (error.status == 422) {
                this.EventBus.$emit('car-validation-failed', error.body);
            }
        })
    }

    update(data) {
        Vue.http.post(`/car/update`, data).then(response => {
            this.EventBus.$emit('car-update-done', response.body.data);
        }, error => {
            if (error.status == 422) {
                this.EventBus.$emit('car-validation-failed', error.body);
            }
        })
    }

    delete() {

    }

    bindDevice(data) {
        Vue.http.post('/car/bind/device', data).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('car-bind-done', response.body.data.message);
            } else {
                this.EventBus.$emit('car-bind-failed', response.body.data.message);
            }
        })
    }

    /**
     * get car list of user including shared cars
     * @param  string   id   User ID
     * @return Promise
     */
    static getCarsOfUser(id) {
        return new Promise(function(resolve, reject) {
            Vue.http.get(`/user/car/list/${id}`).then(
                response => resolve(response.body.data.items),
                error => reject())
        })
    }

    /**
     * get car list of user including shared cars which has device binded
     * format: {id: 'car_id', name: 'reg_no', device: 'device_id'}
     * @param  string   id  User ID
     * @return Promise
     */
    static getAllCarsWithDeviceId(id){
      return new Promise(function(resolve, reject) {
          Vue.http.get(`/user/car/names/${id}`).then(
              response => resolve(response.body.data),
              error => reject())
      })
    }

    getCarState(car_id, user_id) {
        Vue.http.get(`/car/state/${car_id}`, {params: {user_id}}).then(response => {
            this.EventBus.$emit('car-state-found', response.body.data);
        }, error => {})
    }

    /**
     * toggle car status
     * @param  string   id   Car ID
     * @return Promise
     */
    static toggleStatus(id) {
        return new Promise(function(resolve, reject) {
            Vue.http.get(`/car/toggle-status/${id}`).then(
                response => resolve(),
                error => reject())
        })
    }

    getPackages() {
        Vue.http.get(`/car/packages`).then(response => {
            this.EventBus.$emit('service-packages-found', response.body.data.items);
        }, error => {})
    }

    getServices(carId) {
        Vue.http.get(`/car/services/${carId}`).then(response => {
            this.EventBus.$emit('car-services-found', response.body.data);
        })
    }

    unbindCar(car_id) {
        Vue.http.post(`/car/unbind/device`, {car_id}).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('car-unbind-done', car_id);
            } else {
                this.EventBus.$emit('car-unbind-failed', response.body.data.message);
            }
        }, error => {})
    }
}
