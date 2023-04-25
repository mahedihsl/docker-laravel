import Vue from 'vue';
import Vuex from 'vuex';

import EventBus from '../../util/EventBus';
import {duty} from './modules/duty';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        duty,
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
