export default class EnterpriseApi {
    constructor() {

    }

    /**
     * get monthly driving hour report
     * @param  string id    userId of the enterprise user
     * @param  integer month 1-indexed
     * @return Promise
     */
    static driving(id, month, year) {
        return new Promise(function(resolve, reject) {
            Vue.http.get(`/enterprise/driving/report/${id}`, {
                month, year
            }).then(response => resolve(response), error => reject(error));
        })
    }
}
