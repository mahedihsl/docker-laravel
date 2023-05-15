<template>
  <div class="col-xs-12 log-list v-margin">
    <table class="table table-responsive table-striped">
      <thead>
        <tr>
          <th class="col-xs-1">#</th>
          <th class="col-xs-3">Percentage</th>
          <th class="col-xs-6">Value</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(o, i) in items">
          <td>%</td>
          <td><input type="text" class="form-control" v-model="o.perc"></td>
          <td><input type="text" class="form-control" v-model="o.value"></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td>
            <button class="btn btn-success" @click="update">
              <i class="fa fa-refresh fa-spin" v-show="loading"></i> Add Fuel Calibration
            </button>
            <button class="btn default" @click="cancel">
              <i class="fa fa-times"></i> Cancel
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import EventBus from '../../../../util/EventBus';
import CalibrationApi from '../../../../api/CalibrationApi';

export default {
  props: ['log', 'vehicle'],
  data: () => ({
    items: [
      {perc: '', value: ''},
      {perc: '', value: ''},
      {perc: '', value: ''},
      {perc: '', value: ''},
      {perc: '', value: ''},
      {perc: '', value: ''},
    ],
    loading: false,
  }),
  mounted() {
    EventBus.$on('fuel-log-saved', this.onSuccess.bind(this));
  },
  methods: {
    update() {
      this.loading = true;

      let api = new CalibrationApi(EventBus);
      console.log('vehicle id: ' + this.vehicle.id);
      api.updateFuel(this.vehicle.id, this.items);
    },

    onSuccess() {
      this.loading = false;
      EventBus.$emit('fuel-edit-done');
    },

    onError() {
      this.loading = false;
    },

    cancel() {
      EventBus.$emit('calibration-insert-cancel');
    }
  }
}
</script>
<style scoped>
</style>
