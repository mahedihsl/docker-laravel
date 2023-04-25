import EventBus from '../../../util/EventBus';
import ZoneApi from '../../../api/enterprise/ZoneApi';

export const zone = {
    namespaced: true,
    state: {
        zones: [],
        error: {
            name: '',
            lat: '',
            lng: '',
            radius: '',
        }
    },
    getters: {
        zones(state) {
            return state.zones
        },
        count(state) {
            return state.zones.length
        },
        error(state) {
            return state.error
        },
    },
    mutations: {
        set(state, list) {
            list.sort((a, b) => a.name.localeCompare(b.name));
            state.zones = list;
        },
        add(state, zone) {
            state.zones.push(zone);
        },
        remove(state, id) {
            let i = state.zones.findIndex(o => o.id == id);
            state.zones.splice(i, 1);
        },
        error(state, data) {
            if (data == null) {
                for (let k in state.error) {
                    if (state.error.hasOwnProperty(k)) {
                        state.error[k] = '';
                    }
                }
                return;
            }

            state.error = data;
        }
    },
    actions: {
        list({commit, rootGetters}) {
            ZoneApi.list(rootGetters.customer.id).then(list => commit('set', list))
        },
        save({commit, rootGetters}, data) {
            EventBus.$emit('zone-save-start');
            ZoneApi.save(rootGetters.customer.id, data)
                .then(zone => {
                    commit('add', zone);
                    commit('error', null);
                    EventBus.$emit('zone-form-close');
                })
                .catch(error => {
                    commit('error', error);
                    EventBus.$emit('zone-save-fail');
                })
        },
        delete({commit}, id) {
            ZoneApi.remove(id).then(() => commit('remove', id))
        },
    }
}
