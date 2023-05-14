<template>
  <div>
    <div class="col-xs-12" style="margin-top: 20px">
      <p>
        <span style="font-size: 16px;">
          Gas Calibration for <strong>Car: {{vehicle.reg_no}}</strong>, <strong>Device: {{vehicle.state.label}}</strong><br>
          <small class="text-primary" v-show="type">CNG Type: {{type == 1 ? 'A' : 'B'}}</small>
        <small style="margin-left: 7%; color:#546E7A;">minimum value</small>
        <input type="text" class="" style="width:7%; margin-top:1%;" v-model="gas_min"/>
        <button type="button" @click="onSaveGasMinClick" class="btn btn-primary btn-xs" style="margin-left:1%" name="button">Save</button>
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
      <factor :type="2" :car-id="vehicle.id"></factor>
      <log :log="current" v-if="!showEdit"></log>
      <edit :log="current" :type="type" :vehicle="vehicle" v-if="showEdit"></edit>
    </div>
    <div class="col-xs-6">
      <price-tune :type="2" :car-id="vehicle.id"></price-tune>
      <refuel-log :type="1"></refuel-log>
    </div>
    <div class="col-xs-6">
      <gas-refuel-input :log="gasRefuelInputs"></gas-refuel-input>
    </div>
    <div class="col-xs-6" v-for="log in logs">
      <log :log="log"></log>
    </div>
  </div>
</template>
<script>
import Log from './GasLog.vue';
import Edit from './GasEdit.vue';
import GasRefuelInput from './GasRefuelInput';
import Factor from './PriceFactor.vue';
import PriceTune from './PriceTuneFactor.vue';
import RefuelLog from '../../refuel/RefuelHistory.vue';

import CalibrationApi from '../../../../api/CalibrationApi';
import EventBus from '../../../../util/EventBus';

export default {
  props: ['vehicle'],
  components: {Log, GasRefuelInput, Edit, Factor, RefuelLog, PriceTune},
  data: () => ({
      current: null,
      logs: [],
      gasRefuelInputs:[],
      type: 0,
      showEdit: false,
      gas_min: null,
  }),
  mounted() {
      EventBus.$on('gas-calibration-found', this.onDataFound.bind(this));
      EventBus.$on('gas-edit-done', this.onEditDone.bind(this));
      EventBus.$on('gas-log-deleted', this.onLogDeleted.bind(this));
      EventBus.$on('calibration-insert-cancel', this.onBackClick.bind(this));
      EventBus.$on('gas-min-found', this.onGasMinFound.bind(this));
      EventBus.$on('gas-min-saved', this.onGasMinSaved.bind(this));
      EventBus.$on('gas-refuel-input-found', this.onGasRefuelInputFound.bind(this));

      EventBus.$emit('get-refuel-logs', this.vehicle.id);

      this.getGasLogs();
      this.getGasMin();
      this.getRefuelInput();
  },
  methods: {
    getGasLogs() {
      let api = new CalibrationApi(EventBus);
      api.gasCalibrationLog(this.vehicle.id);
    },
    getGasMin(){
      let api = new CalibrationApi(EventBus);
      api.getGasMin(this.vehicle.id);
    },
    getRefuelInput(){
      let api = new CalibrationApi(EventBus);
      api.getRefuelInput(this.vehicle.id);
    },
    onDataFound(items, type) {
      this.type = type;
      if (items.length) {
        this.current = items[0];
        this.logs = items.slice(1);
      } else {
        this.current = null;
        this.logs = [];
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
      this.getGasLogs();
    },

    onLogDeleted(id) {
      if (this.current.id == id) {
        this.onDataFound(this.logs);
      } else {
        let i = _.findIndex(this.logs, ['id', id]);
        this.logs.splice(i, 1);
      }
    },
    onGasMinFound(value){
      this.gas_min = value.gas_min;
    },
    onGasRefuelInputFound(data){
      this.gasRefuelInputs = data;
      //console.log(this.gasRefuelInputs);
    },
    onSaveGasMinClick(){
      let api = new CalibrationApi(EventBus);
      api.saveGasMin(this.vehicle.id, this.gas_min);
    },
    onGasMinSaved(){
      toastr.success("Gas minimum value saved successfully");
    }
  }
}
</script>
<style scoped>
</style>
