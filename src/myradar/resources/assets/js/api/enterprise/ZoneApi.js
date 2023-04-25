import Error from '../../util/Error';

export default class ZoneApi {
    constructor() {

    }

    static list(userId) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/zone/list/${userId}`)
                .then(response => resolve(response.body.data.items || []))
                    .catch(error => reject())
        })
    }

    static save(userId, data) {
        return new Promise((resolve, reject) => {
            Vue.http.post(`/zone/save`, {
                ...data, user_id: userId,
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

    static remove(id) {
        return new Promise((resolve, reject) => {
            Vue.http.post(`/zone/delete`, {id})
                .then(response => resolve())
                    .catch(error => reject())
        })
    }
}
