import Vue from 'vue';
import Vuex from 'vuex';

import EventBus from '../../util/EventBus';
import {mileage} from '../mileage/modules/mileage';
import {driving} from '../driving/modules/driving';
import {duty} from '../duty/modules/duty';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        mileage,
        driving,
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
            console.log('setting root userId', id);
            state.userId = id
        },
    },
    actions: {

    }
})
