export default class MileageApi {
    constructor(bus) {
        this.EventBus = bus;
    }

    getRecords(carId, days) {
        this.EventBus.$emit("fetch-start");
        Vue.http.get(`/mileage/records/${carId}/${days}`).then(
            response => {
                if (response.status == 200) {
                    this.EventBus.$emit("mileage-data-found", response.body);
                }
            },
            error => {}
        );
    }

    getCars(userId) {
        Vue.http.get(`/user/car/list/${userId}`).then(
            response => {
                this.EventBus.$emit("cars-found", response.body.data);
            },
            error => {}
        );
    }
}
