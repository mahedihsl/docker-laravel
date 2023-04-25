import Vue from 'vue';
import Vuex from 'vuex';

import EventBus from '../../util/EventBus';
import {driving} from './modules/driving';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        driving,
    },
    state: {
        userId: null,
    },
    getters: {
        userId(state) {
            return state.userId
        },
    },
    mutations: {
        setUserId(state, id) {
            state.userId = id
        },
    },
    actions: {

    }
})
