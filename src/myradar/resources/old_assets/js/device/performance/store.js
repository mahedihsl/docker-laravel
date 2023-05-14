import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import EventBus from '../../util/EventBus';
import PerformanceApi from '../../api/device/PerformanceApi';

export default new Vuex.Store({
    state: {
        stats: null,
        tag: null,
        day: '',
        list: {
            good: [],
            bad: [],
            worst: [],
        },
        loading: false,
    },
    getters: {
        stats(state) {
            return state.stats
        },
        good(state) {
            return state.list.good
        },
        bad(state) {
            return state.list.bad
        },
        worst(state) {
            return state.list.worst
        },
        tag(state) {
            return state.tag
        },
        loading(state) {
            return state.loading
        },
        day(state) {
            return state.day
        }
    },
    mutations: {
        stats(state, data) {
            state.stats = data
        },
        list(state, data) {
            state.list[data.tag] = data.list
        },
        setDay(state, day) {
            state.day = day;
        },
        setTag(state, tag) {
            state.tag = tag
        },
        setLoading(state, flag) {
            state.loading = flag
        }
    },
    actions: {
        getStats({commit, state}) {
            PerformanceApi.stats(state.day).then(data => {
                commit('stats', data);
                EventBus.$emit('perf-stats-found', data);
            })
        },
        getList({commit, state}, tag) {
            commit('setTag', tag);
            commit('setLoading', true);
            PerformanceApi.list(tag, state.day).then(list => {
                EventBus.$emit('perf-list-found', list, tag);
                commit('list', {tag, list});
            })
        }
    }
})
