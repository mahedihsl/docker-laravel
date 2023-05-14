import Vue from 'vue';
import Vuex from 'vuex';
import VueResource from 'vue-resource';
import VeeValidate from 'vee-validate';



import customer from './modules/customer';

Vue.use(Vuex);
Vue.use(VueResource);
Vue.use(VeeValidate);

export default new Vuex.Store({
    actions: {},
    getters: {},
    modules: {
        customer,
    },
});
