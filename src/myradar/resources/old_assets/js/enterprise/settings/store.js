import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import EventBus from '../../util/EventBus';
import SettingsApi from '../../api/enterprise/SettingsApi';
import {fence} from './modules/fence';
export default new Vuex.Store({
  modules:{
    fence,
  },
  state:{
    userId: null,
    settingsList: [],
  },
  getters:{
    userId(state) {
        return state.userId
    },
    settingsList(state){
      return state.settingsList
    }
  },
  mutations:{
    userId(state, id) {
        state.userId = id
    },
    settingsList(state, data){
       state.settingsList = data
    }
  },
  actions:{

    getSettings({commit, state}, Id) {
        SettingsApi.getSettings(Id).then(data => {
            commit('settingsList', data);
            EventBus.$emit('settings-list-found', data);
        })
    },
    updateSettings({commit, state}, data) {
      SettingsApi.updateSettings(data).then(data => {
          EventBus.$emit('settings-list-changed');
      })
    },

    getCars({commit, state}, userId){
      SettingsApi.getCars(userId).then(data => {
          EventBus.$emit('car-list-found', data);
      })
    }


  }
})
