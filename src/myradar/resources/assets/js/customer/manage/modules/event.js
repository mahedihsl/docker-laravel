import EventBus from '../../../util/EventBus';
import EventApi from '../../../api/EventApi';

export const event = {
    namespaced: true,
    state: {
        events: [],
        pagination: {
            total: 0,
            per_page: 50,
            total_pages: 0,
            current_page: 1,
        },
        loading: false,
    },
    getters: {
        events(state) {
            return state.events;
        },
        pagination(state) {
            return state.pagination;
        },
        loading(state) {
            return state.loading;
        },
        nothing(state) {
            return !state.events.length;
        }
    },
    mutations: {
        setEvents(state, list) {
            state.events = list;
        },
        setPagination(state, data) {
            state.pagination = data;
        },
        setLoading(state, flag) {
            state.loading = flag;
        }
    },
    actions: {
        getEvents({commit, rootGetters}, {carId, page = 1}) {
            commit('setLoading', true);
            EventApi.list(carId, page)
                    .then(data => {
                        commit('setEvents', data.list);
                        commit('setPagination', data.pagination);
                    })
                    .catch(() => {})
                    .then(() => commit('setLoading', false))
        }
    }
}
