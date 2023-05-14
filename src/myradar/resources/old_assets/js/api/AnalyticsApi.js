export default class AnalyticsApi {
    constructor(bus) {
        this.EventBus = bus;
    }

    static getLoginStats(id) {
        return new Promise(function(resolve, reject) {
          Vue.http.get(`/activity/login/stats/${id}`).then(response => {
              resolve(response.body.data.items);
          }, error => reject())
        })
    }

    static getRequestStats(id) {
        return new Promise(function(resolve, reject) {
          Vue.http.get(`/activity/request/stats/${id}`).then(response => {
              resolve(response.body.data.items);
          }, error => reject())
        })
    }
}
