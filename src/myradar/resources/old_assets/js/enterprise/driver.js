require('../bootstrap');
import {mapGetters} from 'vuex';
import EventBus from '../util/EventBus';
import store from './store/driver';

import DriverList from '../components/enterprise/driver/DriverList.vue';
import DriverCreate from '../components/enterprise/driver/DriverCreate.vue';
import DriverEdit from '../components/enterprise/driver/DriverEdit.vue';
import Assignment from '../components/enterprise/driver/Assignment.vue';

new Vue({
    el: '#app',
    store,
    components: {
        DriverList, DriverCreate, DriverEdit
    },
    data: {
        temp: null,
        current: DriverList,
    },
    computed: {
        ...mapGetters(['previousPage']),
        props() {
            if (this.current == DriverEdit || this.current == Assignment) {
                return {driver: this.temp};
            }
            return null;
        }
    },
    beforeMount() {
      let userId = $('input[name="user_id"]').val();
      let previousPage = $('input[name="previous"]').val();
      //console.log(userId);
      this.$store.commit('userId', userId);
      this.$store.commit('previousPage',previousPage);
      this.$store.dispatch('getCarList');
      this.$store.dispatch('getEmployeeList');
    },
    mounted() {
        EventBus.$on('add-driver-click', () => this.current = DriverCreate);
        EventBus.$on('add-driver-close', () => this.current = DriverList);
        EventBus.$on('edit-driver-close', () => this.current = DriverList);
        EventBus.$on('edit-driver-click', driver => {
            this.temp = driver;
            this.current = DriverEdit;
        });

        EventBus.$on('assign-driver-close', () => {
          if(this.previousPage == null)
            this.current = DriverList
          else if(this.previousPage == "tracker"){
            window.location.href = '/text/tracker';
          }
          else if(this.previousPage == "map"){
            window.location.href = '/map/search';
          }

          });
        EventBus.$on('assign-driver-click', driver => {
            this.temp = driver;
            this.current = Assignment;
        });

        EventBus.$on('driver-update-ok', () => toastr.success('Information Updated'));
        EventBus.$on('driver-delete-ok', () => toastr.success('Driver Deleted'));
    },
    methods: {

    }
});
