<template>
  <div class="">
    <h4>Select Employee</h4>
    <table class="table table-hover">
      <thead>
        <tr>
          <th class="col-xs-2">#</th>
          <th class="col-xs-4">Name</th>
          <th class="col-xs-3">Phone</th>
          <th class="col-xs-3">Car</th>
        </tr>
      </thead>
      <tbody>
        <employee v-for="(e, i) in employees"
                  :employee="e"
                  :assignable="true"
                  :serial="i + 1"
                  :key="i">
        </employee>
      </tbody>
    </table>
  </div>
</template>
<script>
import {mapGetters} from 'vuex';
import EventBus from '../../../util/EventBus';

import Employee from '../employee/Employee.vue';

export default {
  components: {
    Employee,
  },
  data: () => ({

  }),
  computed: {
    ...mapGetters(['employees']),
  },
  mounted() {
    EventBus.$on('employee-selected', this.onSelected.bind(this));
  },
  methods: {
    onSelected(employee) {
      this.$store.commit('select', employee.id);
      EventBus.$emit('employee-focused');
    },
  }
}
</script>
<style lang="scss" scoped>
</style>
