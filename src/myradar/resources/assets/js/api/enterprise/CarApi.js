export default class CarApi {
    constructor() {

    }

    /**

     * Get list of cars (including shared cars) of an enterprise user
     * @param  String   id  User ID
     * @return Promise
     */
    static all(id) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/enterprise/car/list/${id}`)
                .then(response => resolve(response.body.data.items || []))
        })
    }

    /**
     * Get list of cars inside a zone
     * @param  String   id  Zone ID
     * @return Promise
     */
    static list(id) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/zone/car/list/${id}`)
                .then(response => resolve(response.body.data || []))

        })
    }

    /**
     * Get current assignment of a car
     * @param  String   id      Device id of car
     * @param  Object   carry   Data of Car last location
     * @return Promise
     */
    static assignment(id, carry) {
        return new Promise((resolve, reject) => {
            $.get(`/car/current/assignment/${id}`, response => {
                if (response.status == 1) {
                    resolve({data: carry, ass: response.data});
                } else {
                    resolve({data: carry, ass: null});
                }
            })
        })
    }
}
