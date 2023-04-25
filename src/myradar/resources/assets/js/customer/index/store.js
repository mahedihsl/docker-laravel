import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import EventBus from '../../util/EventBus';
import CustomerApi from '../../api/CustomerApi';
import PaymentApi from '../../api/PaymentApi';
export default new Vuex.Store({
    state: {
        current: 0,
        customers: [],
        pagination: {
            total: 0,
            per_page: 15,
            total_pages: 0,
            current_page: 1,
        },
        error: {
          name: '',
          phone: '',
          email: '',
          password: '',
        },
        loader: {
            list: true,
            create: false,
            message:false,
        }
    },
    getters: {
        customers(state) {
            return state.customers;
        },
        pagination(state) {
            return state.pagination;
        },
        serial: (state) => (i) => {
            return (state.pagination.current_page - 1) * state.pagination.per_page + 1 + i;
        },
        loader(state) {
            return state.loader;
        },
        error(state) {
            return state.error;
        }
    },
    mutations: {
        changeView(state, k) {
            state.current = k;
        },
        setCustomers(state, list) {
            state.customers = list;
        },
        setPagination(state, data) {
            state.pagination = data;
        },
        setListLoading(state, flag) {
            state.loader.list = flag;
        },
        setCreateLoading(state, flag) {
            state.loader.create = flag;
        },
        setMessageLoading(state, flag) {
          state.loader.message = flag;
        },
        setError(state, error) {
            state.error = error;
        },
        setMessageError(state, error) {
            state.error = error;
        }

    },
    actions: {
        fetch({commit}, data) {
            commit('setListLoading', true);
            CustomerApi.search(data).then(({list, pagination}) => {
                commit('setListLoading', false);
                commit('setCustomers', list);
                commit('setPagination', pagination);
            }, error => {});
        },
        save({commit}, data) {
            commit('setCreateLoading', true);
            CustomerApi.save(data).then(result => {
                commit('setCreateLoading', false);
                EventBus.$emit('customer-save-done', result);
            }, error => {
                commit('setCreateLoading', false);
                commit('setError', error);
            });
        },
        sendPaymentMessage({commit}){
          let api= new PaymentApi(EventBus);
          commit('setMessageLoading',true);
          api.sendMessageAll().then(result => {
              commit('setMessageLoading', false);
              EventBus.$emit('message-send-done', result);
          }, error => {
              commit('setMessageLoading', false);
              commit('setMessageError', error);
          });
        },
        sendPaymentMethod({commit}){
          let api= new PaymentApi(EventBus);

          api.sendMethodAll().then(result => {
              if(result == 1){
                EventBus.$emit('message-send-done', result);
              }
          }, error => {
              commit('setMessageError', error);
          });
        },
    }
})
