import Error from '../util/Error';

export default class DriverApi {
    constructor() {

    }

    /**
     * List of Drivers of a enterprise user
     * @param  String   id  Enterprise user id
     * @return Promise      [description]
     */
    static list(userId) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/driver/list/${userId}`).then(response => {
                resolve(response.body.data.items || []);
            }, error => reject(error))
        })
    }

    /**
     * List of drivers who are assigned to a car
     * @param  String   userId  Enterprise user id
     * @return Promise          [description]
     */
    static activeList(userId) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/driver/active/list/${userId}`).then(response => {
                resolve(response.body.data.items || []);
            }, error => reject(error))
        })
    }

    static save(data) {
        return new Promise((resolve, reject) => {
            Vue.http.post(`/driver/save`, {
                name: data.name,
                phone: data.phone,
                user_id: data.userId,
            }).then(response => {
                if (response.body.status == 1) {
                    resolve(response.body.data)
                } else {
                    reject(response.body.data.message);
                }
            }, error => {
                if (error.status == 422) {
                    let res = new Error(error);
                    reject(res.validationError());
                }
            })
        })
    }

    static update(data) {
        return new Promise((resolve, reject) => {
            Vue.http.post(`/driver/update`, data).then(response => {
                if (response.body.status == 1) {
                    resolve(response.body.data)
                } else {
                    reject(response.body.data.message);
                }
            }, error => {
                if (error.status == 422) {
                    let res = new Error(error);
                    reject(res.validationError());
                }
            })
        })
    }

    static delete(id) {
        return new Promise((resolve, reject) => {
            Vue.http.post(`/driver/delete`, {id})
                .then(response => response.body.status ? resolve() : reject(), error => {})
        })
    }
}
