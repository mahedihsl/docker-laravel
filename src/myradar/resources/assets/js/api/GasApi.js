export default class GasApi {
    constructor(bus) {
        this.EventBus = bus;
    }

    latest(deviceId) {
        Vue.http.get(`/gas/latest/${deviceId}`).then(response => {
            if (response.body.status > 0) {
                this.EventBus.$emit('latest-gas-found', response.body.data);
            }
        }, error => {})
    }

    async latestAsync(deviceId) {
        const res = await Vue.http.get(`/gas/latest/${deviceId}`)
        return res.body.data
    }

    history(deviceId, days) {
        Vue.http.get(`/gas/history/${deviceId}/${days}`).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('gas-chart-found', response.body.data.items);
            }
        }, error => {})
    }
}
