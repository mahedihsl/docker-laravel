export default class DeviceApi {
    constructor(bus) {
        this.EventBus = bus;
    }

    checkServiceData(carId, serviceId) {
        Vue.http.get(`/service/data/status/${carId}/${serviceId}`).then(response => {
            this.EventBus.$emit('service-check-done', response.body);
        }, error => {})
    }

    generateNewId() {
        Vue.http.get('/device/newid').then(response => {
            this.EventBus.$emit('com-id-found', response.body.data.com_id);
        }, error => {})
    }

    create(com_id, phone, version, imei) {
        Vue.http.post('/device/create', {
            com_id, phone, version, imei,
        }).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('device-create-ok', response.body.data);
            } else {
                this.EventBus.$emit('device-create-error', response.body.data.message);
            }
        }, error => {
            if (error.status == 422) {
                this.EventBus.$emit('device-create-error', error.body.phone[0]);
            }
        })
    }

    getRecentDevices(skip) {
        Vue.http.get(`/devices/recent/${skip}`).then(response => {
            this.EventBus.$emit('device-list-found', response.body.data);
        })
    }

    updatePhone(car_id, phone) {
        Vue.http.post('/device/update/phone', { car_id, phone }).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('device-phone-updated');
            } else {
                this.EventBus.$emit('device-phone-update-error', response.body.data.message);
            }
        }, error => {})
    }

    updateVersion(com_id, version){
      console.log('came to update version');
      Vue.http.post('/device/update/version', {com_id, version}).then(response => {
        if(response.body.status == 1){
          this.EventBus.$emit('device-version-updated');
        } else {
          this.EventBus.$emit('device-version-update-error', response.body.data.message);
        }
      }, error => {})
    }
}
