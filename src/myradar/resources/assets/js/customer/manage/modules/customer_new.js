import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        common: {
            title: "",
            message: ""
        },
        saveFlag: {
            customer: null,
            car: null,
            bindServices: null
        },
        customer: {
            name: "",
            phone: "",
            nid: "",
            email: "",
            //  password: '',
            //  password2: '',
            address: "",
            type: "0",
            note: "",
            types: []
        },
        car: {
            name: "",
            maker: "0",
            makers: [],
            model: "",
            reg_no: "",
            engine_no: "",
            chesis_no: "",
            reg_date: "",
            tax_date: "",
            fitness_date: "",
            insurance_date: "",
            color: "0",
            colors: [],
            type: "0",
            types: [],
            fuel: "0",
            fuels: [],
            engine_cc: "",
            seat_count: "",
            cng: "",
            note: ""
        },
        service: {
            commercialId: "",
            selected: [],
            items: [],
            test: [],
            serviceCheckFlag: false
        },

        response: {
            msg: ""
        }
    },
    getters: {
        pageTitle(state) {
            return state.common.title;
        },

        successMessage(state) {
            return state.common.message;
        },

        customerName(state) {
            return state.customer.name;
        },

        customerPhone(state) {
            return state.customer.phone;
        },

        customerNid(state) {
            return state.customer.nid;
        },

        customerEmail(state) {
            return state.customer.email;
        },

        //customerPassword(state){
        // return state.customer.password,

        // },

        //customerPassword2(state){
        // return state.customer.password2,

        // },

        customerAddress(state) {
            return state.customer.address;
        },

        customerType(state) {
            return state.customer.type;
        },

        customerNote(state) {
            return state.customer.note;
        },

        customerTypes(state) {
            return state.customer.types;
        },

        carName(state) {
            return state.car.name;
        },

        carMaker(state) {
            return state.car.maker;
        },

        carModel(state) {
            return state.car.model;
        },

        carRegno(state) {
            return state.car.reg_no;
        },

        carEngineNo(state) {
            return state.car.engine_no;
        },

        carChesisNo(state) {
            return state.car.chesis_no;
        },

        carRegdateDate(state) {
            return state.car.reg_date;
        },

        carTaxDate(state) {
            return state.car.tax_date;
        },

        carFitnessDate(state) {
            return state.car.fitness_date;
        },

        carInsuranceDate(state) {
            return state.car.insurance_date;
        },

        carColor(state) {
            return state.car.color;
        },

        carColors(state) {
            return state.car.colors;
        },

        carType(state) {
            return state.car.type;
        },

        carTypes(state) {
            return state.car.types;
        },

        carFuel(state) {
            return state.car.fuel;
        },

        carFuels(state) {
            return state.car.fuels;
        },

        carEngineCC(state) {
            return state.car.engine_cc;
        },

        carSeatCount(state) {
            return state.car.seat_count;
        },

        carCng(state) {
            return state.car.cng;
        },

        carNote(state) {
            return state.car.note;
        },

        saveCustomerFlag(state) {
            return state.saveFlag.customer;
        },

        saveCarFlag(state) {
            return state.saveFlag.car;
        },

        saveBindServiceFlag(state) {
            return state.saveFlag.bindServices;
        },

        setServiceErrorMsg(state) {
            return state.response.msg;
        },

        setServiceCheck(state) {
            return state.service.test;
        },

        setServiceCheckFlag(state) {
            return state.service.serviceCheckFlag;
        }
    },
    actions: {
        getCustomer({ commit }) {
            Vue.http.get("/customer/types/api").then(
                response => {
                    commit("setCustomerTypes", response.body);
                },
                error => {}
            );
        },

        saveForm({ dispatch }) {
            dispatch("saveCustomer");
        },

        saveCustomer({ commit, dispatch }) {
            Vue.http
                .post("/customers/add/api", {
                    name: state.customer.name,
                    phone: state.customer.phone,
                    nid: state.customer.nid,
                    email: state.customer.email,
                    //  'password': state.customer.password,
                    //  'password_confirmation': state.customer.password2,
                    address: state.customer.address,
                    type: state.customer.type,
                    note: state.customer.note
                })
                .then(
                    response => {
                        let USER = response.body.user_id;
                        commit("setCustomerSaveFlag", true);
                        dispatch("saveCar", USER);
                    },
                    error => {
                        commit("setCustomerSaveFlag", false);
                    }
                );
        },
        saveCar({ commit, dispatch }, USER) {
            Vue.http
                .post("/cars/add/api", {
                    name: state.car.name,
                    maker: state.car.maker,
                    model: state.car.model,
                    reg_no: state.car.reg_no,
                    engine_no: state.car.engine_no,
                    chesis_no: state.car.chesis_no,
                    reg_date: state.car.reg_date,
                    tax_date: state.car.tax_date,
                    fitness_date: state.car.fitness_date,
                    insurance_date: state.car.insurance_date,
                    color: state.car.color,
                    type: state.car.type,
                    fuel: state.car.fuel,
                    engine_cc: state.car.engine_cc,
                    seat_count: state.car.seat_count,
                    cng: state.car.cng,
                    note: state.car.note,
                    user_id: USER
                })
                .then(
                    response => {
                        let CAR = response.body.car_id;
                        let user = response.body.user_id;
                        console.log(user);
                        commit("setCarSaveFlag", true);
                        dispatch("bindServices", {
                            car: CAR,
                            user: user
                        });
                    },
                    error => {
                        //deleting customer if saving the info of car is failed
                        Vue.http.post("/customers/delete/api", {
                            id: USER
                        });
                        commit("setCarSaveFlag", false);
                        commit("setBindServiceSaveFlag", false);
                    }
                );
        },

        bindServices({ commit }, { car, user }) {
            Vue.http
                .post("/bind-services/api", {
                    com_id: state.service.commercialId,
                    selected: state.service.selected,
                    car_id: car,
                    user_id: user
                })
                .then(
                    response => {
                        console.log(car);
                        console.log(user);
                        if (response.body.status == 0) {
                            context.commit("setBindServiceSaveFlag", false);
                            Vue.http.get("/cars/delete/api/" + car);
                            Vue.http.post("/customers/delete/api", {
                                id: user
                            });
                            commit("setServiceErrorMsg", response.body.msg);
                        } else {
                            //now check services ...
                            //
                            setTimeout(function() {
                                commit("setBindServiceSaveFlag", true);
                                //    Vue.http.post('/api/check-services-data', {
                                //          'user_id': user
                                //          }).then(function (response) {
                                //
                                // context.commit('setServiceCheck',response.body.msg);
                                // context.commit('setServiceCheckFlag',true);
                                //          });
                            }, 120000);

                            Vue.http
                                .post("/customers/sendCredential/api", {
                                    user: user
                                })
                                .then(function(response) {
                                    console.log(response);
                                });
                        }
                    },
                    error => {
                        //  Vue.http.get('/cars/delete/api/'+CAR);
                        //  Vue.http.post('/customers/delete/api',{
                        //        'id': USERsetServiceChecResponse
                        //        });
                        console.log("eerrr");
                        commit("setBindServiceSaveFlag", false);
                    }
                );
        }
    },
    mutations: {
        setPageTitle(state, s) {
            state.common.title = s;
        },
        setSuccessMessage(state, s) {
            state.common.message = s;
        },
        updateCustomerInfo(state, { key, val }) {
          console.log('customer from store state', state.customer, key, val)
            state.customer[key] = val;
        },
        setCustomerTypes(state, items) {
            state.customer.types = items;
        },

        updateCarInfo(state, { key, val }) {
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
            state.saveFlag.customer = flag;
        },
        setServiceErrorMsg(state, MSG) {
            state.response.msg = MSG;
        },
        setCarSaveFlag(state, flag) {
            state.saveFlag.car = flag;
        },
        setBindServiceSaveFlag(state, flag) {
            console.log("service check");
            state.saveFlag.bindServices = flag;
        },

        setServiceCheck(state, data) {
            console.log("services...");
            state.service.test = data;
        },
        setServiceCheckFlag(state, data) {
            state.service.serviceCheckFlag = data;
        }
    }
})
