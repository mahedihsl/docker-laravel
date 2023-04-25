<template>
  <div class="col-xs-12 log-list v-margin">
    <table class="table table-responsive table-striped">
      <thead>
        <tr>
          <th>Percentage</th>
          <th>Value</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(o, i) in items">
          <td>Level {{o.level}}</td>
          <td>
            <input type="text" class="form-control" v-model="o.value" :placeholder="'ex: ' + o.ex"/>
            <p class="helper-text" v-show="o.value">any value &le; {{o.value}} will show {{o.level}} green lights</p>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <button class="btn btn-success" @click="update">
              <i class="fa fa-refresh fa-spin" v-show="loading"></i> Add Gas Calibration
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
  props: ['log', 'vehicle', 'type'],
  data: () => ({
    items: [
      {level: 0, value: '', ex: 800},
      {level: 1, value: '', ex: 350},
      {level: 2, value: '', ex: 250},
      {level: 3, value: '', ex: 175},
      {level: 4, value: '', ex: 99},
    ],
    loading: false,
  }),
  mounted() {
    EventBus.$on('gas-log-saved', this.onSuccess.bind(this));

    if (this.type == 2) {
      for (let i = 0; i < this.items.length; i++) {
        this.items[i].ex = 50* (i + 1);
      }
    }
  },
  methods: {
    update() {
      this.loading = true;

      let api = new CalibrationApi(EventBus);
      api.updateGas(this.vehicle.id, this.items);
    },

    onSuccess() {
      this.loading = false;
      EventBus.$emit('gas-edit-done');
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
