import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import { car } from './modules/car';
import { rms } from './modules/rms';
import { zone } from './modules/zone';
import { share } from './modules/share';
import { event } from './modules/event';

export default new Vuex.Store({
    modules: {
        car,
        rms,
        zone,
        share,
        event,
    },
    state: {
        customer: null,
    },
    getters: {
        customer(state) {
            return state.customer
        }
    },
    mutations: {
        customer(state, info) {
            state.customer = info;
        }
    },
    actions: {

    }
})
