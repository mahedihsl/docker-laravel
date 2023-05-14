import Vue from 'vue';
import Vuex from 'vuex';
import VueMaterial from 'vue-material';

import EventBus from '../../util/EventBus';
import DriverApi from '../../api/DriverApi';
import EmployeeApi from '../../api/EmployeeApi';
import CarApi from '../../api/CarApi';
import AssignmentApi from '../../api/enterprise/AssignmentApi';

Vue.use(Vuex);
Vue.use(VueMaterial);
export default new Vuex.Store({
    state: {
        cars: [],
        drivers: [],
        employees: [],
        userId: null,   // enterprise user id
        loading: false,
        selected: null, // selected id of employee during assignment
        message: '',    // message to send for logistics assignment
        firstLoad: true,
        previousPage: null, //from whichpage assign button clicked
        assignmentlist: null,
    },
    getters: {
        cars(state) {
            return state.cars
        },
        drivers(state) {
            return state.drivers
        },
        employees(state) {
            return state.employees
        },
        loading(state) {
            return state.loading
        },
        userId(state) {
          //console.log(userId);
            return state.userId
        },
        selected(state) {
            return state.selected
        },
        message(state) {
            return state.message
        },
        firstLoad(state) {
            return state.firstLoad;
        },
        previousPage(state){
          return state.previousPage;
        },
        assignmentList(state){
          return state.assignmentlist;
        }
    },
    mutations: {
        userId(state, id) {
            console.log(id);
            state.userId = id;
        },
        previousPage(state, previousPage){
          if(previousPage!=""){
            state.previousPage = previousPage;
          }

          console.log(previousPage);
        },
        set(state, list) {
            state.drivers = list;
            EventBus.$emit('driver-list-found', list);
        },
        add(state, driver) {
            state.drivers.unshift(driver)
        },
        update(state, data) {
            let driver = data.curr.data;
            let i = state.drivers.findIndex(item => item.id == driver.id);
            state.drivers[i] = driver;

            if (data.prev) {
                i = state.drivers.findIndex(item => item.id == data.prev);
                state.drivers[i].car = null;
            }
        },
        remove(state, id) {
            let i = state.drivers.findIndex(item => item.id == id);
            state.drivers.splice(i, 1);
        },
        loading(state, flag) {
            state.loading = flag
        },
        select(state, id) {
            state.selected = id
        },
        setCars(state, list) {
            state.cars = list
        },
        setEmployees(state, list) {
            state.employees = list
        },
        message(state, msg) {
            state.message = msg;
        },
        setFirstLoad(state, flag) {
            state.firstLoad = flag;
        },
        setAssignments(state, list){
          state.assignmentlist =list;
        }
    },
    actions: {
        getCarList({commit, state}) {
            CarApi.getCarsOfUser(state.userId).then(list => commit('setCars', list));
        },
        getEmployeeList({commit, state}) {
            EmployeeApi.list(state.userId).then(list => commit('setEmployees', list));
        },
        getDriverList({commit}, id) {
            commit('loading', true);
            DriverApi.list(id)
                .then(list => commit('set', list))
                .catch(error => {})
                .then(() => commit('loading', false))
        },
        saveDriver({commit}, data) {
            commit('loading', true);
            DriverApi.save(data)
                .then(driver => {
                    commit('add', driver);
                    EventBus.$emit('driver-save-ok');
                })
                .catch(error => EventBus.$emit('driver-save-fail', error))
                .then(() => commit('loading', false))
        },
        updateDriver({commit}, data) {
            commit('loading', true);
            DriverApi.update(data)
                .then(driver => {
                    commit('update', driver);
                    EventBus.$emit('driver-update-ok');
                })
                .catch(error => {})
                .then(() => commit('loading', false))
        },
        deleteDriver({commit}, id) {
            commit('loading', true);
            DriverApi.delete(id)
                .then(() => {
                    commit('remove', id);
                    EventBus.$emit('driver-delete-ok');
                })
                .catch(() => {})
                .then(() => commit('loading', false))
        },
        assign({commit}, data) {
            commit('loading', true);
            AssignmentApi.assign(data).then(() => {
                EventBus.$emit('assign-driver-close');
            })
            .catch(() => {})
            .then(() => commit('loading', false))

        },
        getAssignments({commit}, id){
          AssignmentApi.getAssignments(id).then(list => commit('setAssignments', list));
        }
    }
})
