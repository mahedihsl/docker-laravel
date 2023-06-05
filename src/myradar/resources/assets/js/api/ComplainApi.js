export default class ComplainApi {
    constructor(bus) {
        this.EventBus = bus;
    }



    static getComplains(page, user_id = '') {
      return new Promise(function(resolve, reject){
        Vue.http.get(`/complain/list?page=${page}&user_id=${user_id}`).then(response => {
           resolve(response.body)
        }, error => {})
      })
    }

    static search(data) {
      let params ={
        name  : data.name,
        reg_no: data.reg_no,
        token : data.token,
      };
      return new Promise(function(resolve, reject){
        Vue.http.get(`/complain/search`,{params}).then(response => {
           resolve(response.body.data)
        }, error => {})
      })
    }

    static save(data) {

      return new Promise(function(resolve, reject) {
        Vue.http.post('/save/complain', data).then(
          response =>resolve(response.body),
          error => reject())
      })
    }

    static addComment(data) {
      return new Promise(function(resolve, reject) {
        Vue.http.post('/complain/add/comment', data).then(
          response =>resolve(response.body),
          error => reject())
      })
    }

    // paymentList(userId){
    //   return new Promise((resolve, reject) => {
    //     Vue.http.get(`/payment/paymentlist/${userId}`).then(response =>
    //       response.body.status ? resolve(response.body.data): reject(), error => reject())
    //   })
    // }
    //

}
