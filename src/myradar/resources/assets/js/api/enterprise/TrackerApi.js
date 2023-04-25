export default class TrackerApi{

  constructor(){

  }

  static list(userId) {
      return new Promise((resolve, reject) => {
          Vue.http.get(`text-tracker/car/list/${userId}`)
                      .then(response => resolve(response.body.data), error => reject())
      })
  }

  static locations(carId){
    return new Promise((resolve, reject) => {
        Vue.http.get(`text-tracker/location/list/${carId}`)
                    .then(response => resolve(response.body.data), error => reject())
    })
  }

  static thanalist(districtId){
    return new Promise((resolve, reject) =>{
      Vue.http.get(`text-tracker/thana/list/${districtId}`).then(response => resolve(response.body.data), error => reject())
    })
  }

  static assignmentInfo(driverId){
    return new Promise((resolve,reject) => {
      Vue.http.get(`driver/assignment/info/${driverId}`).then(response => resolve(response.body.data), error => reject())
    })
  }

  static route(deviceId, date) {
      return new Promise((resolve, reject) => {
          Vue.http.get(`/enterprise/car/route/${deviceId}`, {params: {date}}).then(response => resolve(response.body.data), error => reject())
      })
  }

}
