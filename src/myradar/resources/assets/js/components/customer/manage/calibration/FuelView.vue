<template>
  <div>
    <div class="col-xs-12" style="margin-top: 20px">
      <p>
        <span style="font-size: 16px;">
          Fuel Calibration for <strong>Car: {{vehicle.reg_no}}</strong>, <strong>Device: {{vehicle.state.label}}</strong>
        </span>
        <button class="btn btn-link pull-right" @click="onBackClick">
          <i class="fa fa-arrow-left"></i> Back
        </button>
        <button class="btn btn-default pull-right" @click="onEditClick" v-show="!showEdit">
          <i class="fa fa-pencil"></i> Update Calibration
        </button>
      </p>
    </div>
    <div class="col-xs-6">
      <factor :type="1" :car-id="vehicle.id"></factor>
      <log :log="current" v-if="!showEdit"></log>
      <edit :log="current" :vehicle="vehicle" v-if="showEdit"></edit>
    </div>
    <div class="col-xs-6">
      <refuel-log :type="0"></refuel-log>
    </div>
    <div class="col-xs-6" v-for="log in userLogs">
      <user-fuel-log :log="log"></user-fuel-log>
    </div>
    <div class="col-xs-6" v-for="log in logs">
      <log :log="log"></log>
    </div>
  </div>
</template>
<script>
import Log from './FuelLog.vue';
import Edit from './FuelEdit.vue';
import Factor from './PriceFactor.vue';
import UserFuelLog from './UserFuelLog.vue';
import RefuelLog from '../../refuel/RefuelHistory.vue';

import CalibrationApi from '../../../../api/CalibrationApi';
import EventBus from '../../../../util/EventBus';

export default {
  props: ['vehicle'],
  components: {Log, Edit, Factor, RefuelLog, UserFuelLog},
  data: () => ({
    current: null,
    logs: [],
    userLogs:[],
    showEdit: false,
  }),
  mounted() {
    EventBus.$on('fuel-calibration-found', this.onDataFound.bind(this));
    EventBus.$on('user-fuel-calibration-found', this.onUserDataFound.bind(this));
    EventBus.$on('fuel-edit-done', this.onEditDone.bind(this));
    EventBus.$on('fuel-log-deleted', this.onLogDeleted.bind(this));
    EventBus.$on('calibration-insert-cancel', this.onBackClick.bind(this));
    EventBus.$emit('get-refuel-logs', this.vehicle.id);

    this.getFuelLogs();
    this.getUserFuelLogs();
  },
  methods: {
    getFuelLogs() {
      let api = new CalibrationApi(EventBus);
      api.fuelCalibrationLog(this.vehicle.id);
    },

    getUserFuelLogs(){
      let api = new CalibrationApi(EventBus);
      api.userFuelCalibrationLog(this.vehicle.id);
    },

    onDataFound(items) {
      if (items.length) {
        this.current = items[0];
        this.logs = items.slice(1);
      } else {
        this.current = null;
        this.logs = [];
      }
    },

    onUserDataFound(items) {
      if (items.length) {
        this.userLogs = items;
      } else {
        this.userLogs = [];
      }
    },
    onEditClick() {
      this.showEdit = true;
      if (this.current) {
        this.logs.unshift(this.current);
      }
    },

    onBackClick() {
      if (this.showEdit == false) {
        EventBus.$emit('show-car-list');
        return;
      }

      this.showEdit = false;
      this.onDataFound(this.logs);
    },

    onEditDone() {
      this.showEdit = false;
      this.onDataFound(this.logs);
      this.getFuelLogs();
    },

    onLogDeleted(id) {
      if (this.current.id == id) {
        this.onDataFound(this.logs);
      } else {
        let i = _.findIndex(this.logs, ['id', id]);
        this.logs.splice(i, 1);
      }
    }
  }
}
</script>
<style scoped>
</style>
