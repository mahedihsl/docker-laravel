export default class SettingsApi {
    constructor() {
      //
    }

    static getSettings(id) {
      //console.log("kelu ",id[1]);
      let userId = id[1];
      let carId = id[0];
      return new Promise((resolve, reject) => {
        Vue.http.get(`/enterprise/settings/${userId}/${carId}`).then(response =>
          resolve(response.body.data), error=> reject())
      })

    }

    static updateSettings(data) {
        return new Promise((resolve, reject) => {
          Vue.http.post(`/enterprise/settings/change`, data).then(response =>
            resolve(response.body.data), error=> reject())
        })
    }

    static getCars(id){
      return new Promise((resolve, reject) => {
        Vue.http.get(`/enterprise/car/list/${id}`).then(response =>
          resolve(response.body.data), error=> reject())
      })
    }
}
