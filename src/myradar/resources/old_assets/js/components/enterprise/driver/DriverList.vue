<template>
  <div>
    <h4>
      Driver List
      <button class="btn btn-primary pull-right" @click="onAddClick">
        <i class="fa fa-plus"></i> Add
      </button>
    </h4>
    <hr>
    <spinner v-show="loading"></spinner>
    <no-data v-if="!loading && !drivers.length"></no-data>
    <table class="table table-striped table-hover" v-show="!loading && drivers.length">
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
        <driver class="driver" v-for="(d, i) in drivers" :driver="d" :serial="i + 1" :key="i"></driver>
      </tbody>
    </table>
  </div>
</template>
<script>
import EventBus from '../../../util/EventBus';
import Url from '../../../util/Url';
import {mapGetters, mapMutations} from 'vuex';

import NoData from '../../util/NoItemFound.vue';
import Spinner from '../../util/Spinner.vue';
import Driver from './Driver.vue';

export default {
  components: {
    Driver, Spinner, NoData,
  },
  data: () => ({

  }),
  computed: {
    ...mapGetters(['drivers', 'loading', 'userId', 'firstLoad']),
  },
  mounted() {
    EventBus.$on('driver-list-found', this.onListFound.bind(this));
    this.$store.dispatch('getDriverList', this.userId);
  },
  methods: {
    ...mapMutations(['setFirstLoad']),
    onAddClick() {
      EventBus.$emit('add-driver-click');
    },

    onListFound(list) {
      if (this.firstLoad) {
        let url = new Url();
        let assignable = url.getParameterByName('assign');
        if (assignable) {
          let ind = list.findIndex(item => item.id == assignable);
          if (ind > -1) {
            EventBus.$emit('assign-driver-click', list[ind]);
          }
        }

        this.setFirstLoad(false);
      }

    }
  }
}
</script>
<style lang="css" scoped>
.colored-header{
  background-color: #0095BF;
}

</style>
