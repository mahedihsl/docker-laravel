import Vue from 'vue';
import Vuex from 'vuex';

import EventBus from '../../util/EventBus';
import EmployeeApi from '../../api/EmployeeApi';
import DriverApi from '../../api/DriverApi';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        employees: [],
        drivers: [],
        userId: null,
        loading: false,
    },
    getters: {
        employees(state) {
            return state.employees;
        },
        userId(state) {
            return state.userId;
        },
        loading(state) {
            return state.loading;
        },
    },
    mutations: {
        userId(state, id) {
            state.userId = id;
        },
        loading(state, flag) {
            state.loading = flag;
        },
        set(state, list) {
            state.employees = list;
        },
        add(state, item) {
            state.employees.unshift(item);
        },
        update(state, item) {
            let i = state.employees.findIndex(o => o.id == item.id);
            state.employees[i] = item;
        },
        remove(state, id) {
            let i = state.employees.findIndex(o => o.id == id);
            state.employees.splice(i, 1);
        }
    },
    actions: {
        getEmployeeList({commit, state}) {
            commit('loading', true);
            EmployeeApi.list(state.userId)
                .then(list => commit('set', list))
                .catch(error => {})
                .then(() => commit('loading', false))
        },

        saveEmployee({commit, state}, data) {
            commit('loading', true);
            EmployeeApi.save({...data, userId: state.userId})
                .then(item => {
                    commit('add', item);
                    EventBus.$emit('employee-save-ok');
                })
                .catch(error => EventBus.$emit('employee-save-fail', error))
                .then(() => commit('loading', false))
        },

        updateEmployee({commit}, data) {
            commit('loading', true);
            EmployeeApi.update(data)
                .then(item => {
                    commit('update', item);
                    EventBus.$emit('employee-update-ok');
                })
                .catch(error => {})
                .then(() => commit('loading', false))
        },

        deleteEmployee({commit}, id) {
            commit('loading', true);
            EmployeeApi.delete(id)
                .then(() => commit('remove', id))
                .catch(() => {})
                .then(() => commit('loading', false))
        }
    }
})
