export const car = {
    namespaced: true,
    state: {
        cars: [],
        selectedCarLocation: null
    },
    getters: {
        cars(state) {
            return state.cars;
        },
        location(state) {
            return state.selectedCarLocation;
        }
    },
    mutations: {
        SET_CARS(state, list) {
            list = list.map(item => ({ ...item, location: null }));
            state.cars = list;
        },
        SET_SELECTED_CAR_LOCATION(state, location) {
            state.selectedCarLocation = location;
        }
    },
    actions: {
        async getCarsOfUser({ commit }, user_id) {
            const res = await Vue.http.get(`/user/car/list/${user_id}`);
            commit("SET_CARS", res.body.data);
        },
        async getLastLocation({ commit }, car_id) {
            try {
                const res = await Vue.http.get(
                    `/user/car/last-location?car_id=${car_id}`
                );
                commit("SET_SELECTED_CAR_LOCATION", res.body.location);
            } catch (error) {
                commit("SET_SELECTED_CAR_LOCATION", null);
            }
        }
    }
};
