import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import EventBus from '../../util/EventBus';
import LastPulseApi from '../../api/device/LastPulseApi';

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
            LastPulseApi.stats(state.day).then(data => {
                commit('stats', data);
                EventBus.$emit('perf-stats-found', data);
            })
        },
        getList({commit, state}, tag) {
            commit('setTag', tag);
            commit('setLoading', true);
            LastPulseApi.list(tag, state.day).then(list => {
                EventBus.$emit('perf-list-found', list, tag);
                commit('list', {tag, list});
            })
        },
		updateResetCall({commit, state}, {id, ring}) {
			LastPulseApi.updateResetCall(id, ring).then(res => {
				if (res.status == 1) {
					//commit('resetCallMade', {id, tag});
					let data = Object.assign(res.data, {ring});
					EventBus.$emit('reset-call-made', id, data);
				}
            })
		}
    }
})
