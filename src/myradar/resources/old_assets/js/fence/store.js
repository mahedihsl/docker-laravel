import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    geofences: [],
    templates: [],
    cars: [],
    allCars: [],
  },
  getters: {
    geofences(state) {
      return state.geofences
    },
    templates(state) {
      return state.templates
    },
    cars(state) {
      return geofenceId => {
        const geofence = state.geofences.find(m => m.id === geofenceId)
        return state.cars.map(car => {
          const isSubscribed =
            geofence.cars.findIndex(c => c.id === car.id) != -1
          return { ...car, subscribed: isSubscribed }
        })
      }
    },
    allCars(state) {
      return state.allCars
    },
  },
  mutations: {
    SET_GEOFENCES(state, list) {
      state.geofences = list
    },

    ADD_GEOFENCE(state, item) {
      state.geofences.unshift(item)
    },

    REMOVE_GEOFENCE(state, id) {
      const index = state.geofences.findIndex(m => m.id === id)
      if (index != -1) {
        state.geofences.splice(index, 1)
      }
    },

    REMOVE_TEMPLATE(state, id) {
      const index = state.templates.findIndex(m => m.id === id)
      if (index != -1) {
        state.templates.splice(index, 1)
      }
    },

    UPDATE_TEMPLATE(state, { id, name, coordinates }) {
      const index = state.templates.findIndex(m => m.id === id)
      if (index != -1) {
        const model = state.templates[index]
        model.name = name
        model.coordinates = coordinates
        state.templates.splice(index, 1, model)
      }
    },

    UPDATE_GEOFENCE(state, { id, name, coordinates }) {
      const index = state.geofences.findIndex(m => m.id === id)
      if (index != -1) {
        const model = state.geofences[index]
        model.name = name
        model.coordinates = coordinates
        state.geofences.splice(index, 1, model)
      }
    },

    SET_TEMPLATES(state, list) {
      state.templates = list
    },

    SET_CARS(state, list) {
      state.cars = list
    },

    SET_ALL_CARS(state, list) {
      state.allCars = list.map(car => ({ ...car, selected: false }))
    },

    UPDATE_SUBSCRIPTIONS(state, subscribers) {
      state.allCars = state.allCars.map(car => {
        car.selected = subscribers.indexOf(car.id) !== -1
        return car
      })
    },

    SUBSCRIBE_CAR(state, { geofence, car }) {
      const index = state.geofences.findIndex(m => m.id === geofence.id)
      const target = state.geofences[index]
      target.cars.push(car)
      state.geofences.splice(index, 1, target)
    },

    UNSUBSCRIBE_CAR(state, { geofence, car }) {
      const index = state.geofences.findIndex(m => m.id === geofence.id)
      const target = state.geofences[index]
      const carIndex = target.cars.findIndex(c => c.id === car.id)
      target.cars.splice(carIndex, 1)
      state.geofences.splice(index, 1, target)
    },
  },
  actions: {
    async fetchAllCars({ commit }) {
      const res = await Vue.http.get(`/car/everything`)
      commit('SET_ALL_CARS', res.body)
    },

    async fetchCars({ commit }, userId) {
      const res = await Vue.http.get(`/user/car/list/${userId}`)
      commit('SET_CARS', res.body.data.items)
    },

    async fetch({ commit }, userId) {
      const res = await Vue.http.get(`/geofence/fetch?user_id=${userId}`)
      commit('SET_GEOFENCES', res.body.data)
    },

    async templates({ commit }) {
      const res = await Vue.http.get('/geofence/templates')
      commit('SET_TEMPLATES', res.body.data)
    },

    async attachTemplate({ commit }, { templateId, userId }) {
      const res = await Vue.http.post('/geofence/attach/template', {
        user_id: userId,
        template_id: templateId,
      })
      commit('ADD_GEOFENCE', res.body.data)
    },

    async save({ commit }, { name, coordinates, user_id }) {
      const res = await Vue.http.post('/geofence/save', {
        name,
        coordinates,
        user_id,
      })
    },

    async update({ commit }, { id, name, coordinates }) {
      const res = await Vue.http.post('/geofence/update', {
        id,
        name,
        coordinates,
      })
    },

    async remove({ commit }, id) {
      await Vue.http.post('/geofence/remove', {
        id,
      })
      commit('REMOVE_TEMPLATE', id)
      commit('REMOVE_GEOFENCE', id)
    },

    async syncSubscriptions({ commit }, { geofence_id, car_ids }) {
      await Vue.http.post('/geofence/sync-subscriptions', {
        geofence_id,
        car_ids,
      })
    },

    async fetchSubscriptions({ commit }, geofence_id) {
      const res = await Vue.http.get(
        `/geofence/fetch-subscriptions?geofence_id=${geofence_id}`
      )
      commit('UPDATE_SUBSCRIPTIONS', res.body)
    },

    async subscribe({ commit }, { geofence, car }) {
      await Vue.http.post('/geofence/subscribe', {
        geofence_id: geofence.id,
        car_id: car.id,
        reg_no: car.reg_no,
      })

      commit('SUBSCRIBE_CAR', { geofence, car })
    },

    async unsubscribe({ commit }, { geofence, car }) {
      await Vue.http.post('/geofence/unsubscribe', {
        geofence_id: geofence.id,
        car_id: car.id,
        reg_no: car.reg_no,
      })

      commit('UNSUBSCRIBE_CAR', { geofence, car })
    },
  },
})
