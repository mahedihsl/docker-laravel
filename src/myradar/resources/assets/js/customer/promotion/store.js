import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import EventBus from '../../util/EventBus';


export default new Vuex.Store({
  state:{
    current: 0,
    
  },
  getters:{

  },
  mutations:{
    changeView(state, val){
      state.current = val;
    },
  },
  actions:{

  },
})
