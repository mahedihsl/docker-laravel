import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    generators: [],
    fuel: 0,
    history: {
      values: [],
      events: [],
    },
  },
  getters: {
    generators(state) {
      return state.generators
    },
    fuel(state) {
      return state.fuel
    },
    history(state) {
      return state.history
    },
  },
  mutations: {
    SET_GENERATORS(state, list) {
      state.generators = list
    },
    SET_FUEL(state, value) {
      state.fuel = value
    },
    SET_HISTORY(state, list) {
      state.history = list
    },
  },
  actions: {
    async fetch({ commit }) {
      const res = await Vue.http.get('/generator/list')
      commit('SET_GENERATORS', res.body)
    },

    async fetchFuel({ commit }, car_id) {
      const res = await Vue.http.get(`/fuel/latestv2?car_id=${car_id}`)
      commit('SET_FUEL', res.body.value)
    },

    async fetchHistory({ commit }, { car_id, type }) {
      const res = await Vue.http.get(
        `/fuel/historyv2?car_id=${car_id}&type=${type}`
      )
      commit('SET_HISTORY', res.body)
    },
  },
})
