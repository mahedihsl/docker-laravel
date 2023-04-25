import EventBus from '../../../util/EventBus';
import ZoneApi from '../../../api/enterprise/FenceApi';

export const fence = {
    namespaced: true,
    state: {
        zones: [],
        error: {
            name: '',
            lat: '',
            lng: '',
            radius: '',
        },
        selectedCarId: null,
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
        selectedCarId(state){
            return state.selectedCarId
        }
    },
    mutations: {
        set(state, list) {
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
        },
        selectedCarId(state, id){
            console.log('selected car is', id);
          state.selectedCarId = id;
        }
    },
    actions: {
        list({commit, rootGetters}, carId) {
            ZoneApi.list(carId).then(list => {
              commit('set', list);
              console.log(list);
            })
        },
        save({state, commit, rootGetters}, data) {
            EventBus.$emit('zone-save-start');

            ZoneApi.save(state.selectedCarId, data)
                .then(zone => {
                    //commit('add', zone);
                    commit('error', null);
                    EventBus.$emit('zone-form-close');
                })
                .catch(error => {
                    commit('error', error);
                    EventBus.$emit('zone-save-fail');
                })
        },
        delete({state,commit}, id) {
            ZoneApi.remove(state.selectedCarId, id).then(
              () => {
                //commit('remove', id);
                EventBus.$emit('fence-deleted');
              })
        },
    }
}
