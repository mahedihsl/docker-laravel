<template>
  <div>
    <div class="form">
      <div class="col-xs-4 col-md-3">
        <div class="form-group">
          <select class="form-control" v-model="selected">
            <option value="1">Driving Hour</option>
            <option value="2">Duty Hour</option>
            <option value="3">Mileage Report</option>
          </select>
        </div>
      </div>
      <div class="col-xs-3 col-md-2">
        <div class="form-group">
          <select class="form-control" v-model="compare">
            <option value="0">All Records</option>
            <option value="-1">Less Than</option>
            <option value="1">More Than</option>
          </select>
        </div>
      </div>
      <div class="col-xs-3">
        <div class="form-group">
          <input type="text" class="form-control" v-model="value" v-bind:placeholder="placeholder">
        </div>
      </div>
      <div class="col-xs-2" style="margin-left: 0px; padding-left: 0px;">
        <div class="form-group">
          <label style="margin-top: 8px;">{{label}}</label>
        </div>
      </div>
    </div>
    <div class="row">
      <component :is="current" v-bind="props"></component>
    </div>
  </div>
</template>
<script>
import DrivingReport from '../driving/Table.vue';
import MileageReport from '../mileage/Table.vue';
import DutyReport from '../duty/Table.vue';

export default {
  components: {
    DrivingReport,
    MileageReport,
    DutyReport,
  },
  data: () => ({
    selected: '1',
    compare: '0',
    value: '',
  }),
  computed: {
    current() {
      let comps = [DrivingReport, DutyReport, MileageReport];
      return comps[parseInt(this.selected) - 1];
    },
    label() {
      let arr = ['Hours', 'Hours', 'Km'];
      return arr[parseInt(this.selected) - 1];
    },
    placeholder() {
      let arr = ['ex: 10 Hours', 'ex: 5 Hours', 'ex: 20 Km'];
      return arr[parseInt(this.selected) - 1];
    },
    props() {
      return {
        compare: parseInt(this.compare),
        value: this.value,
      };
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
