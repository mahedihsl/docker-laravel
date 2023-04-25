export default class MileageApi {
    constructor(bus) {
        this.EventBus = bus;
    }

    getRecords(carId, days) {
        this.EventBus.$emit('fetch-start');
        Vue.http.get(`/mileage/records/${carId}/${days}`).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('mileage-data-found', response.body.data);
            }
        }, error => {})
    }

    getCars(userId) {
        Vue.http.get(`/user/car/list/${userId}`).then(response => {
            this.EventBus.$emit('cars-found', response.body.data);
        }, error => {})
    }
}
