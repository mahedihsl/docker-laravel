import Vue from 'vue';
import Vuex from 'vuex';

import EventBus from '../../util/EventBus';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        items: [
            {reg: '27-1045', driver: 'Hashem', phone: '01753451245', time: 2, month: 'February'},
            {reg: '24-9956', driver: 'Kalam', phone: '01784652587', time: 12, month: 'February'},
            {reg: '25-2826', driver: 'Abdul', phone: '01798955512', time: 1, month: 'February'},
            {reg: '23-8785', driver: 'Rahim', phone: '01750036454', time: 0, month: 'February'},
            {reg: '23-3627', driver: 'Jahangir', phone: '01720230654', time: 5, month: 'February'},
            {reg: '23-7529', driver: 'Kutub', phone: '01778987715', time: 10, month: 'February'},
            {reg: '25-4144', driver: 'Kamal', phone: '01751466266', time: 2, month: 'February'},
            {reg: '26-6283', driver: 'Jamal', phone: '01787790225', time: 3, month: 'February'},
            {reg: '22-5318', driver: 'Jasim', phone: '01765661980', time: 0, month: 'February'},
            {reg: '22-5433', driver: 'Shofik', phone: '01744628559', time: 1, month: 'February'},
            {reg: '23-7685', driver: 'Rounok', phone: '01754548820', time: 8, month: 'February'},
        ],
        loading: false,
        timeSort: 0,
    },
    getters: {
        items(state) {
            return (search, compare, value) => {
                if (state.loading) {
                    return [];
                }
                
                let list = state.items;

                if (search) {
                    list = list.filter(val => {
                      return val.reg.toLowerCase().indexOf(search) != -1 ||
                              val.driver.toLowerCase().indexOf(search) != -1;
                    });
                }

                if (compare != 0 && value) {
                    list = list.filter(val => {
                      return compare == 1 ? (val.time > value) : (val.time < value);
                    });
                }

                return list;
            };
        },
        loading(state) {
            return state.loading;
        },
        timeSort(state) {
            return state.timeSort;
        }
    },
    mutations: {
        setLoading(state, flag) {
            state.loading = flag;
        },
        changeTimeSort(state) {
            state.timeSort = (state.timeSort == 0 || state.timeSort == -1) ? 1 : -1;
            state.items.sort((a, b) => {
                if (a.time < b.time) {
                  return state.timeSort == 1 ? -1 : 1;
                }

                if (b.time < a.time) {
                  return state.timeSort == 1 ? 1 : -1;
                }

                return 0;
            });
        }
    },
    actions: {
        getRecords({commit}) {
            commit('setLoading', true);
            setTimeout(function() {
                commit('setLoading', false);
            }, 2000);
        }
    }
})
