export default class EventApi {
    constructor() {

    }

    static list(carId, page) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/event/list/${carId}`, {params: {page}}).then(response => {
                resolve({
                    list: response.body.data.data || [],
                    pagination: response.body.data.meta.pagination,
                });
            }, error => reject());
        })
    }
    static recent(deviceId, limit, type) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/api/event/recent/${deviceId}`,{params: {limit, type}}).then(response => {
                resolve(response.body.data.items || []);
            }, error => reject());
        })
    }

}
