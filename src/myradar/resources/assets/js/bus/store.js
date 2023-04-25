import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import EventBus from '../util/EventBus';
import BusApi from '../api/BusApi';

export default new Vuex.Store({
  state:{
    current: 1,
    allCompanies: null,
    busList: null,
    SelectedCompany: null,
    selectedBus: null,
  },
  getters:{
    allCompanies(state){
      return state.allCompanies;
    },
    SelectedCompany(state){
      return state.SelectedCompany;
    },
    busList(state){
      return state.busList;
    },
    selectedBus(state){
      return state.selectedBus;
    }
  },
  mutations:{
    changeView(state, val){
      state.current = val;
    },
    setAllCompanies(state, list){
      state.allCompanies = list;
    },
    setBusList(state, list){
      state.busList = list;
    },
    selectedBus(state, id){
      state.selectedBus = id;
    },
    SelectedCompany(state, id){
      state.SelectedCompany = id;
    }
  },
  actions:{
    getCompanies({commit}){

      BusApi.allCompanies().then(list => commit('setAllCompanies', list))
    },

    getBusList({commit}, id){
      //console.log("came here");
      BusApi.getBusList(id).then(list => {
        commit('setBusList', list);
        EventBus.$emit('bus-list-found', list);
      })
    },

    saveRoute({commit}, route){
      //console.log(route);
      BusApi.saveRoute(route).then(result => {
          //commit('setCreateLoading', false);
          EventBus.$emit('route-save-done');
      }, error => {
          //commit('setCreateLoading', false);
          //commit('setError', error);
      });
    },

    deleteRoute({commit}, id){
      BusApi.deleteRoute(id).then(result =>{
        EventBus.$emit('route-deleted', result);
      })
    }
  },
})
