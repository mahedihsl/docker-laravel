<template>
  <div>
    <h4>
      Employee List
      <button class="btn btn-primary pull-right" @click="onAddClick">
        <i class="fa fa-plus"></i> Add
      </button>
    </h4>
    <hr>
    <spinner v-show="loading"></spinner>
    <no-data v-if="!loading && !employees.length"></no-data>
    <table class="table table-striped table-hover" v-show="!loading && employees.length">
      <thead class="colored-header">
        <tr>
          <th class="col-md-1">#</th>
          <th class="col-md-3">Name</th>
          <th class="col-md-3">Phone</th>
          <th class="col-md-2">Car</th>
          <th class="col-md-3">Action</th>
        </tr>
      </thead>
      <tbody>
        <employee v-for="(e, i) in employees"
                  :employee="e"
                  :assignable="false"
                  :serial="i + 1"
                  :key="i">
        </employee>
      </tbody>
    </table>
  </div>
</template>
<script>
import EventBus from '../../../util/EventBus';
import {mapGetters} from 'vuex';

import NoData from '../../util/NoItemFound.vue';
import Spinner from '../../util/Spinner.vue';
import Employee from './Employee.vue';

export default {
  components: {
    Employee, Spinner, NoData,
  },
  data: () => ({

  }),
  computed: {
    ...mapGetters(['employees', 'loading']),
  },
  mounted() {
    this.$store.dispatch('getEmployeeList');
  },
  methods: {
    onAddClick() {
      EventBus.$emit('add-employee-click');
    }
  }
}
</script>
<style lang="scss" scoped>
.colored-header{
  background-color: #2B77A7;
  height: auto;
  font-size: 14px;
}
</style>
