import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        site: null,
        pinConfigs: [],
    },
    getters: {
        site(state) {
            return state.site
        },
        pinConfigsOfDevice(state) {
            return comId => {
                return state.pinConfigs.filter(conf => conf.com_id === comId)
            }
        }
    },
    mutations: {
        SET_SITE(state, site) {
            state.site = site
        },
        SET_PIN_CONFIGS(state, configs) {
            state.pinConfigs = configs
        },
        REMOVE_PIN_CONFIG(state, config_id) {
            const index = state.pinConfigs.findIndex(conf => conf.id === config_id)
            if (index !== -1) {
                state.pinConfigs.splice(index, 1)
            }
        },
    },
    actions: {
        async getSiteInfo({ commit }, site_id) {
            const res = await axios.get(`/rms/site/info`, { params: { site_id } })
            commit('SET_SITE', res.data)
        },
        async fetchPinConfigs({ commit }, query) {
            const res = await axios.get(`/rms/site/pin/fetch`, { params: query })
            commit('SET_PIN_CONFIGS', res.data)
        },
        async savePinConfig({ commit }, data) {
            const res = await axios.post(`/rms/site/pin/save`, data)
        },
        async updatePinConfig({ commit }, data) {
            const res = await axios.post(`/rms/site/pin/update`, data)
        },
        async removePinConfig({ commit }, { config_id, site_id }) {
            const res = await axios.post(`/rms/site/pin/remove`, { config_id, site_id })
            commit('REMOVE_PIN_CONFIG', config_id)
        },

    }
})
