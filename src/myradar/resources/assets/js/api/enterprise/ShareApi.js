export default class ShareApi {
    constructor() {

    }

    /**
     * Search users by name/phone
     * @param  String   car_id  Car ID
     * @param  Object   data    {name, phone}
     * @return Promise
     */
    static searchUser(car_id, params) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/share/user/search`, {params: {car_id, ...params}})
                .then(response => resolve(response.body.data.items))
        })
    }

    /**
     * get list of user with whom a car is shared
     * @param  String   car_id  Car ID
     * @return Promise
     */
    static sharedUsers(car_id) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/share/shared/users`, {params: {car_id}})
                .then(response => resolve(response.body.data.items), error => reject())
        })
    }

    static sharedCars(userId) {
        // TODO:
    }

    /**
     * give share status of a car to an user
     * @param  String   car_id      Car ID
     * @param  String   user_id     User ID
     * @return Promise
     */
    static share(car_id, user_id) {
        return new Promise((resolve, reject) => {
            Vue.http.post(`/share/provide/access`, {car_id, user_id})
                .then(response => response.body.status ? resolve() : reject())
        })
    }

    /**
     * revoke share status of a car with an user
     * @param  String   car_id      Car ID
     * @param  String   user_id     User ID
     * @return Promise
     */
    static revoke(car_id, user_id) {
        return new Promise((resolve, reject) => {
            Vue.http.post(`/share/revoke/access`, {car_id, user_id})
                .then(response => response.body.status ? resolve() : reject())
        })
    }
}
