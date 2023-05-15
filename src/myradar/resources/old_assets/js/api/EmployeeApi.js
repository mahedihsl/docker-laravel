import Error from '../util/Error';

export default class EmployeeApi {
    constructor() {

    }

    static list(userId) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/employee/list/${userId}`).then(response => {
                resolve(response.body.data.items || []);
            }, error => reject(error))
        })
    }

    static save(data) {
        return new Promise((resolve, reject) => {
            Vue.http.post(`/employee/save`, {
                name: data.name,
                phone: data.phone,
                user_id: data.userId,
            }).then(response => {
                if (response.body.status == 1) {
                    resolve(response.body.data);
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
            Vue.http.post(`/employee/update`, {
                id: data.id,
                name: data.name,
                phone: data.phone,
            }).then(response => {
                if (response.body.status == 1) {
                    resolve(response.body.data);
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
            Vue.http.post(`/employee/delete`, {id}).then(
                response => {response.body.status ? resolve() : reject()},
                error => reject()
            )
        })
    }
}
