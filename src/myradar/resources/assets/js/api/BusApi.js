export default class BusApi{
  constructor(bus){
    this.EventBus = bus;
  }


  static allCompanies(){
    return new Promise(function(resolve, reject){
      Vue.http.get(`/bus/company/names`).then(response => {
          resolve(response.body.data);
      }, error => reject())
    })
  }

  static getBusList(userId){
    return new Promise(function(resolve, reject){
      Vue.http.get(`/bus/list/${userId}`).then(response => {
          resolve(response.body.data);
      }, error => reject())
    })
  }

  static saveRoute(route){

    //Vue.http.post(`/bus/route/save`, route)

    return new Promise(function(resolve, reject){
      Vue.http.post(`/bus/route/save`, route).then(response => {
          resolve(response.body.data);
      }, error => reject())
    })
  }

  static deleteRoute(data){
    //Vue.http.post(`/bus/route/delete`, data)
    return new Promise(function(resolve, reject){
      Vue.http.post(`/bus/route/delete`, data).then(response => {
          resolve(response.body.data);
      }, error => reject())
    })
  }
}
