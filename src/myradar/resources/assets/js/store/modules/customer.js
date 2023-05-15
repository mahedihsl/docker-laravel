const state = {
  common: {
    title: '',
    message: '',
  },
  saveFlag: {
    customer: null,
    car: null,
    bindServices: null
  },
  customer: {
    name: '',
    phone: '',
    nid: '',
    email: '',
  //  password: '',
  //  password2: '',
    address: '',
    type: '0',
    note: '',
    types: [],
  },
  car: {
    name: '',
    maker: '0',
    makers: [],
    model: '',
    reg_no: '',
    engine_no: '',
    chesis_no: '',
    reg_date: '',
    tax_date: '',
    fitness_date: '',
    insurance_date: '',
    color: '0',
    colors: [],
    type: '0',
    types: [],
    fuel: '0',
    fuels: [],
    engine_cc: '',
    seat_count: '',
    cng: '',
    note: ''
  },
  service: {
    commercialId: '',
    selected: [],
    items: [],
    test:[],
    serviceCheckFlag:false
  },

  response:{
     msg:''
  }
};

const getters = {
  pageTitle: state => state.common.title,
  successMessage: state => state.common.message,

  customerName: state => state.customer.name,
  customerPhone: state => state.customer.phone,
  customerNid: state => state.customer.nid,
  customerEmail: state => state.customer.email,
  //customerPassword: state => state.customer.password,
  //customerPassword2: state => state.customer.password2,
  customerAddress: state => state.customer.address,
  customerType: state => state.customer.type,
  customerNote: state => state.customer.note,
  customerTypes: state => state.customer.types,

  carName: state => state.car.name,
  carMaker: state => state.car.maker,
  carModel: state => state.car.model,
  carRegno: state => state.car.reg_no,
  carEngineNo: state => state.car.engine_no,
  carChesisNo: state => state.car.chesis_no,
  carRegdateDate: state => state.car.reg_date,
  carTaxDate: state => state.car.tax_date,
  carFitnessDate: state => state.car.fitness_date,
  carInsuranceDate: state => state.car.insurance_date,
  carColor: state => state.car.color,
  carColors: state => state.car.colors,

  carType: state => state.car.type,
  carTypes: state => state.car.types,
  carFuel: state => state.car.fuel,
  carFuels: state => state.car.fuels,
  carEngineCC: state => state.car.engine_cc,
  carSeatCount: state => state.car.seat_count,
  carCng: state => state.car.cng,
  carNote: state => state.car.note,


  saveCustomerFlag: state => state.saveFlag.customer,
  saveCarFlag: state => state.saveFlag.car,
  saveBindServiceFlag: state => state.saveFlag.bindServices,
  setServiceErrorMsg: state =>state.response.msg,
  setServiceCheck: state =>state.service.test,
  setServiceCheckFlag: state =>state.service.serviceCheckFlag
};

const actions = {
  getCustomerTypes(context) {
    Vue.http.get('/customer/types/api').then(response => {
      context.commit('setCustomerTypes', response.body);
    }, error => {});
  },

  saveForm(context) {
    context.dispatch('saveCustomer');
  },

  saveCustomer(context) {
    Vue.http.post('/customers/add/api', {

      'name': state.customer.name,
      'phone': state.customer.phone,
      'nid': state.customer.nid,
      'email': state.customer.email,
    //  'password': state.customer.password,
    //  'password_confirmation': state.customer.password2,
      'address': state.customer.address,
      'type': state.customer.type,
      'note': state.customer.note


    }).then(response => {
      let USER = response.body.user_id;
      context.commit('setCustomerSaveFlag', true);
      context.dispatch('saveCar', USER);

    }, error => {
      context.commit('setCustomerSaveFlag', false);
    });


  },
  saveCar(context, USER) {
    Vue.http.post('/cars/add/api', {
      'name': state.car.name,
      'maker': state.car.maker,
      'model': state.car.model,
      'reg_no': state.car.reg_no,
      'engine_no': state.car.engine_no,
      'chesis_no': state.car.chesis_no,
      'reg_date': state.car.reg_date,
      'tax_date': state.car.tax_date,
      'fitness_date': state.car.fitness_date,
      'insurance_date': state.car.insurance_date,
      'color': state.car.color,
      'type': state.car.type,
      'fuel': state.car.fuel,
      'engine_cc': state.car.engine_cc,
      'seat_count': state.car.seat_count,
      'cng': state.car.cng,
      'note': state.car.note,
      'user_id': USER

    }).then(response => {
      let CAR = response.body.car_id;
      let user = response.body.user_id;
      console.log(user);
      context.commit('setCarSaveFlag', true);
      context.dispatch('bindServices', {car:CAR,user:user})
    }, error => {
      //deleting customer if saving the info of car is failed
      Vue.http.post('/customers/delete/api', {
        'id': USER
      });
      context.commit('setCarSaveFlag', false);
      context.commit('setBindServiceSaveFlag', false)
    });

  },

  bindServices(context,{car,user}) {
    Vue.http.post('/bind-services/api', {
      'com_id': state.service.commercialId,
      'selected': state.service.selected,
      'car_id' :car,
      'user_id':user
    }).then(response => {
      console.log(car);
      console.log(user);
      if (response.body.status == 0) {
        context.commit('setBindServiceSaveFlag', false);
         Vue.http.get('/cars/delete/api/'+car);
         Vue.http.post('/customers/delete/api',{
               'id': user
               });
        context.commit('setServiceErrorMsg',response.body.msg);
      } else {

        //now check services ...
        //
      setTimeout(function(){
        context.commit('setBindServiceSaveFlag', true);
       //    Vue.http.post('/api/check-services-data', {
       //          'user_id': user
       //          }).then(function (response) {
       //
       // context.commit('setServiceCheck',response.body.msg);
       // context.commit('setServiceCheckFlag',true);
       //          });

       },
         120000);

       Vue.http.post('/customers/sendCredential/api',{
             'user': user
               }).then(function (response) {

              console.log(response);
            });

      }
    }, error => {
      //  Vue.http.get('/cars/delete/api/'+CAR);
      //  Vue.http.post('/customers/delete/api',{
      //        'id': USERsetServiceChecResponse
      //        });
      console.log("eerrr");
      context.commit('setBindServiceSaveFlag', false)
    });
  }
};

const mutations = {
  setPageTitle(state, s) {
    state.common.title = s;
  },
  setSuccessMessage(state, s) {
    state.common.message = s;
  },
  updateCustomerInfo(state, {
    key,
    val
  }) {
    state.customer[key] = val;
  },
  setCustomerTypes(state, items) {
    state.customer.types = items;
  },

  updateCustomerInfo(state, {
    key,
    val
  }) {
    state.customer[key] = val;

  },
  updateCarInfo(state, {
    key,
    val
  }) {
    state.car[key] = val;

  },
  updateCommercialId(state, com_id) {
    state.service.commercialId = com_id;

  },
  updateSelectedServices(state, services) {
    state.service.selected = services;

  },
  setServiceList(state, items) {
    state.service.items = items;
  },

  setCustomerSaveFlag(state, flag) {
    state.saveFlag.customer = flag
  },
  setServiceErrorMsg(state,MSG){

    state.response.msg = MSG
  },
  setCarSaveFlag(state, flag) {
    state.saveFlag.car = flag
  },
  setBindServiceSaveFlag(state, flag) {
    console.log('service check')
    state.saveFlag.bindServices = flag
  },

  setServiceCheck(state,data){
    console.log('services...')
    state.service.test =data;
  },
  setServiceCheckFlag(state,data){
    state.service.serviceCheckFlag =data;
  }
};

export default {
  state,
  getters,
  actions,
  mutations,
};
