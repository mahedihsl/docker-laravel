export default class MileageApi {
    constructor() {
        //
    }

    static month(carId, month, year) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/mileage/sum/${carId}`, {params: {month, year}})
                .then(response => resolve(response.body.data))
        })
    }

    static daily(carId, month, year) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/mileage/report/${carId}`, {params: {month, year}})
                .then(response => resolve(response.body.data || []))
        })
    }
}
