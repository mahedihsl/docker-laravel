import Vue from 'vue';
import Vuex from 'vuex';

import ZoneApi from '../../api/enterprise/ZoneApi';
import CarApi from '../../api/enterprise/CarApi';
import PrivateCarApi from '../../api/CarApi';
import EventBus from '../../util/EventBus';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        userId: null,
        cars: [],
        zones: [],
        allCars:[],
    },
    getters: {
        cars(state) {
            return state.cars
        },
        zones(state) {
            return state.zones
        },
        userId(state) {
            return state.userId
        },
        allCars(state){
          console.log(state.allCars);
            return state.allCars;
        }
    },
    mutations: {
        setCars(state, list) {
            state.cars = list
        },
        setZones(state, list) {
            state.zones = list;
        },
        userId(state, id) {
            state.userId = id;
        },
        setAllCarsList(state, list){
          state.allCars = list;
        }
    },
    actions: {
        getCars({commit}, zoneId) {
            CarApi.list(zoneId).then(list => {
                commit('setCars', list);
                EventBus.$emit('car-list-found', list);
            })
        },
        getZones({commit, state}) {
            ZoneApi.list(state.userId)
                .then(list => commit('setZones', list))
                .catch(() => {})
        },
        getAllCars({commit,state}){
          PrivateCarApi.getAllCarsWithDeviceId(state.userId)
            .then(list => commit('setAllCarsList', list))
            .catch(() => {})
        },
    }
})
