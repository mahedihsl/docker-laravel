export default class AssignmentApi {
    constructor() {

    }

    /**
     * method for assign driver to employee
     * @param  Object   data  object containing driver_id, employee_id, from time, duration,
     *                        type (employee, logistics, others), src, dest (start & destination)
     * @return Promise        [description]
     */
    static assign(data) {
        return new Promise((resolve, reject) => {
            Vue.http.post('/driver/assign', data).then(response => {
                if (response.body.status == 1)
                    resolve()
                else reject()
            }, error => reject())
        })
    }
}
