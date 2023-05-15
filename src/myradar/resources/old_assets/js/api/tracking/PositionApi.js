export default class PositionApi {
    constructor() {

    }

    /**
     * get the last position of a car
     * @param  String  id   Device id of the car
     * @return Promise
     */
    static last(id) {
        return new Promise((resolve, reject) => {
            $.get(`/car/last/position/${id}`, response => {
                if (response.status == 1) {
                    resolve(response.data);
                } else {
                    reject();
                }
            })
        })
    }
}
