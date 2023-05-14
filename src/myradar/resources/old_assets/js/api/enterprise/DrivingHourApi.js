export default class DrivingHourApi {
    constructor() {
        //
    }

    static month(carId, month, year) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/driving/hour/sum/${carId}`, {params: {month, year}})
                .then(response => resolve(response.body.data))
        })
    }

    static daily(carId, month, year) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/driving/hour/report/${carId}`, {params: {month, year}})
                .then(response => resolve(response.body.data || []))
        })
    }

}
