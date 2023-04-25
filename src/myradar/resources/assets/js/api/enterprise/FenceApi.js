import Error from '../../util/Error';

export default class FenceApi {
    constructor() {

    }

    static list(carId) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/enterprise/fence/list/${carId}`)
                .then(response => resolve(response.body.data.items || []))
                    .catch(error => reject())
        })
    }

    static save(carId, data) {
        return new Promise((resolve, reject) => {
            Vue.http.post(`/fence/save`, {
                ...data, car_id: carId,
            })
            .then(response => resolve(response.body.data))
            .catch(error => {
                if (error.status == 422) {
                    let res = new Error(error);
                    reject(res.validationError());
                }
            })
        })
    }

    static remove(car_id,fence_id) {
        return new Promise((resolve, reject) => {
            Vue.http.post(`/fence/delete`, {car_id, fence_id})
                .then(response => resolve())
                    .catch(error => reject())
        })
    }
}
