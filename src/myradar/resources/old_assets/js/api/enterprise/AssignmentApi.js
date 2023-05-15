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
                response.body.status == 1 ? resolve() : reject()
            }, error => reject())
        })
    }

    static getAssignments(id) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/driver/assignmentList/${id}`).then(response => resolve(response.body.data || []), error => reject())
        })
    }
}
