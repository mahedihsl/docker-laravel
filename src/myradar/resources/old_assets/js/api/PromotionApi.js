export default class PromotionApi{
  constructor(bus){
    this.EventBus = bus;
  }


  message(data){
    //console.log(data);
    return new Promise((resolve, reject) => {
      Vue.http.post(`/promotion/sms`,data)
                  .then(response => response.body.status ? resolve(response.body.data): reject(), error => reject())
    })
    // Vue.http.post(`/promotion/sms`,data).then(response => {
    //     this.EventBus.$emit('message-sent', response.body);
    // }, error => {})
  }


  notification(id, title, body){
    Vue.http.post(`/promotion/notification`, {id, title, body}).then(response => {
        this.EventBus.$emit('notification-sent', response.body.data);
    }, error => {})
  }

  saveScheme(data){
    this.EventBus.$emit('scheme-save-start');
    Vue.http.post('/save/scheme', data).then(response => {
        this.EventBus.$emit('scheme-save-finish', response.body.status == 1);
    }, error => {})
  }

  savePromo(data){
    Vue.http.post('/save/promo', data).then(response => {
        this.EventBus.$emit('promo-save-finish', response.body.status == 1);
    }, error => {})
  }

  promoSchemeList(){
    Vue.http.get(`/promotion/schemelist`).then(response => {
      this.EventBus.$emit('scheme-list-found',response.body.data);
    }, error => {})
  }

  promoCodeList(page){
    let url = `/promo/code/list?page=${page}`;
    Vue.http.get(url).then(response => {
      this.EventBus.$emit('promo-code-list-found',response.body.data);
    }, error => {})
  }

   generatePromoCode(){
    return new Promise((resolve, reject) => {
        Vue.http.get(`/generate/promo`)
                    .then(response => response.body.data ? resolve(response.body.data) : reject(), error => reject())
    })
  }

  // generatePromoCode(){
  //   Vue.http.get(`/generate/promo`).then(response => {
  //     this.EventBus.$emit('promo-code-found',response.body.data);
  //   }, error => {})
  // }
}
