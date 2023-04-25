require('../bootstrap');

import EventBus from '../util/EventBus';
import store from './store/employee';

import EmployeeList from '../components/enterprise/employee/EmployeeList.vue';
import EmployeeCreate from '../components/enterprise/employee/EmployeeCreate.vue';
import EmployeeEdit from '../components/enterprise/employee/EmployeeEdit.vue';

new Vue({
    el: '#app',
    store,
    components: {
        EmployeeList, EmployeeCreate, EmployeeEdit
    },
    data: {
        temp: null,
        current: EmployeeList,
    },
    computed: {
        props() {
            if (this.current == EmployeeEdit) {
                return {employee: this.temp};
            }
            return null;
        }
    },
    beforeMount() {
      let userId = $('input[name="user_id"]').val();
      this.$store.commit('userId', userId);
    },
    mounted() {
        EventBus.$on('add-employee-click', () => this.current = EmployeeCreate);
        EventBus.$on('add-employee-close', () => this.current = EmployeeList);
        EventBus.$on('edit-employee-close', () => this.current = EmployeeList);
        EventBus.$on('edit-employee-click', employee => {
            this.temp = employee;
            this.current = EmployeeEdit;
        });

        EventBus.$on('employee-update-ok', () => toastr.success('Information Updated'));
        EventBus.$on('employee-delete-ok', () => toastr.success('Employee Deleted'));
    },
    methods: {

    }
})
