import EventBus from '../../../util/EventBus';
import ShareApi from '../../../api/enterprise/ShareApi';

export const share = {
    namespaced: true,
    state: {
        car: null,
        users: [],
        result: [],
        loading: {
            shared: true, // loading for shared user list
            search: false, // loading for search result
        },
    },
    getters: {
        car(state) {
            return state.car
        },
        users(state) {
            return state.users
        },
        result(state) {
            return state.result
        },
        loading(state) {
            return state.loading
        },
    },
    mutations: {
        setCar(state, car) {
            state.car = car;
        },
        setUsers(state, list) {
            state.users = list;
        },
        removeUser(state, id) {
            let i = state.users.findIndex(v => v.id == id);
            if (i != -1) {
                state.users.splice(i, 1);
            }
        },
        setResult(state, list) {
            state.result = list;
        },
        removeResult(state, id) {
            let i = state.result.findIndex(v => v.id == id);
            if (i != -1) {
                state.result.splice(i, 1);
            }
        },
        sharedLoading(state, flag) {
            state.loading.shared = flag;
        },
        searchLoading(state, flag) {
            state.loading.search = flag;
        },
    },
    actions: {
        getSharedUsers({commit, state}) {
            commit('sharedLoading', true);
            ShareApi.sharedUsers(state.car.id)
                    .then(list => commit('setUsers', list))
                        .catch(() => {})
                            .then(() => commit('sharedLoading', false))
        },
        searchUser({commit, state}, params) {
            commit('searchLoading', true);
            ShareApi.searchUser(state.car.id, params)
                    .then(list => commit('setResult', list))
                        .catch(() => {})
                            .then(() => commit('searchLoading', false))
        },
        share({commit, state}, userId) {
            ShareApi.share(state.car.id, userId)
                    .then(() => {
                        commit('removeResult', userId);
                        EventBus.$emit('car-share-success', userId);
                    })
                    .catch(message => EventBus.$emit('car-share-failed', userId, message))
                        .then(() => {})
        },
        revoke({commit, state}, userId) {
            ShareApi.revoke(state.car.id, userId)
                    .then(() => {
                        commit('removeUser', userId);
                        EventBus.$emit('car-unshare-success', userId)
                    })
                    .catch(message => EventBus.$emit('car-unshare-failed', userId, message))
                        .then(() => {})
        }
    }
}
