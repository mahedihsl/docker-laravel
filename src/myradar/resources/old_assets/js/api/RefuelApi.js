export default class RefuelApi {
    constructor(bus) {
        this.EventBus = bus;
    }

    getLog(carId, type) {
        let url = '/refuel/feed/log/' + carId + (type === undefined ? '' : '/' + type);
        Vue.http.get(url).then(response => {
            if (response.body.data.items) {
                this.EventBus.$emit('refuel-log-found', response.body.data.items);
            } else {
                this.EventBus.$emit('refuel-log-error');
            }
        }, error => {});
    }

    saveLog(data) {
        Vue.http.post('/refuel/feed/save', data).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('refuel-log-saved');
            } else {
                this.EventBus.$emit('refuel-log-not-saved');
            }
        }, error => {
            this.EventBus.$emit('refuel-log-not-saved');
        });
    }
}
