<template>
    <div>
      <h3 class="ash-divider">
        Vehicle List
        <button class="btn btn-sm btn-primary pull-right" @click="showNewCarForm">
            <i class="fa fa-plus"></i> New Car
        </button>
        <button class="btn btn-sm btn-default pull-right" @click="refreshList" style="margin-right: 10px">
            <i class="fa fa-refresh"></i>
        </button>
      </h3>
      <table class="table table-hover table-striped" v-if="!refreshing">
        <thead class="colored-header">
          <tr>
            <th class="col-xs-2">Reg No.</th>
            <th class="col-xs-2">Device</th>
            <th class="col-xs-2">Phone No.</th>
            <th class="col-xs-2">Status</th>
            <th class="col-xs-2">Last Pulse</th>
            <th class="col-xs-2">More</th>
          </tr>
        </thead>
        <tbody>
          <vehicle v-for="(v, i) in vehicles"
                  :vehicle="v"
                  :user-id="customer.id"
                  :focused="v.id === focusedId"
                  :key="i">
          </vehicle>
        </tbody>
      </table>
      <div class="refresh" v-if="refreshing">
        <h1 class="text-center">
          <i class="fa fa-refresh fa-spin fa-2x"></i>
        </h1>
      </div>
    </div>
</template>
<script>
import Vehicle from './VehicleItem.vue';

import Url from '../../../../util/Url';
import EventBus from '../../../../util/EventBus';
import CarApi from '../../../../api/CarApi';

export default {
  props: ['customer'],
  components: {
    Vehicle,
  },
  data: () => ({
    vehicles: [],
    refreshing: true,
    focusedId: null, // the id of the focused car, this id is passed via url from other pages
  }),
  mounted() {
    EventBus.$on('car-list-found', this.onCarListFound.bind(this));

    this.refreshList();
  },
  methods: {
      onCarListFound(list) {
          this.vehicles = list;
          this.refreshing = false;

          let url = new Url();
          let target = url.getParameterByName('target');
          if (target) {
            this.focusedId = target;
          }
      },

      showNewCarForm() {
          EventBus.$emit('add-car-click');
      },

      refreshList() {
          this.refreshing = true;

          CarApi.getCarsOfUser(this.customer.id)
              .then(this.onCarListFound.bind(this));
      }
  }
}
</script>
<style lang="scss" scoped>
.refresh {
    padding-top: 100px;
}
</style>
