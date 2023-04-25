export default class SpeedApi {
    constructor() {

    }

    static fetch(id) {
        return new Promise(function(resolve, reject) {
            Vue.http.get(`/car/speed-limit/get/${id}`).then(response => {
                if (response.body.status == 1) {
                    resolve(response.body.data);
                } else {
                    reject(response.body.data.message);
                }
            })
        })
    }

    static update(data) {
        return new Promise(function(resolve, reject) {
            Vue.http.post(`/car/speed-limit/update`, {
                id: data.id,
                soft_limit: data.soft.value,
                soft_flag: data.soft.flag,
                hard_limit: data.hard.value,
                hard_flag: data.hard.flag,
            }).then(response => {
                if (response.body.status == 1) {
                    resolve();
                } else {
                    reject(response.body.data.message);
                }
            })
        })
    }
}
