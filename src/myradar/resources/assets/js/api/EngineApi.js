export default class EngineApi {
    constructor(bus) {
        this.EventBus = bus;
    }

    getStatus(id) {
        Vue.http.get(`/device/status/${id}`).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('engine-status-found', response.body.data);
            }
        }, error => {})
    }

    toggleStatus(id, status) {
        Vue.http.post('/lock/status/toggle', {device_id: id, lock_status: status}).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('lock-status-found', response.body.data.lock_status);
            }
            else if(response.body.status == 0){
              this.EventBus.$emit('lock-status-unchanged');
            }
        }, error => {})
    }
}
