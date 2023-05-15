<template>
  <div class="col-xs-12 col-md-6 col-md-offset-3">
    <h5><strong>Change Speed Limit</strong></h5>
    <hr>
    <table class="table">
      <thead>
        <tr>
          <th class="col-xs-5"><strong>Type</strong></th>
          <th class="col-xs-5"><strong>Limit</strong></th>
          <th class="col-xs-2"><strong>Status</strong></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Soft Limit</td>
          <td>
            <input type="text" class="form-control" v-model="soft.value">
          </td>
          <td>
            <i class="fa clickable" :class="{'fa-square-o': !soft.flag, 'fa-check-square-o': soft.flag, 'text-success': soft.flag}" @click="soft.flag = !soft.flag"></i>
          </td>
        </tr>
        <tr>
          <td>Hard Limit</td>
          <td>
            <input type="text" class="form-control" v-model="hard.value">
          </td>
          <td>
            <i class="fa clickable" :class="{'fa-square-o': !hard.flag, 'fa-check-square-o': hard.flag, 'text-success': hard.flag}" @click="hard.flag = !hard.flag"></i>
          </td>
        </tr>
      </tbody>
      <button class="btn btn-default pull-right" @click="close">
        <i class="fa fa-times"></i> Close
      </button>
      <button class="btn btn-success pull-right" @click="update">
        <i class="fa fa-save"></i> Update
      </button>
    </table>
  </div>
</template>
<script>
import EventBus from '../../../../util/EventBus';
import SpeedApi from '../../../../api/SpeedApi';

export default {
  props: ['vehicle'],
  data: () => ({
    soft: {
      value: '',
      error: '',
      flag: false,
    },
    hard: {
      value: '',
      error: '',
      flag: false,
    },
  }),
  mounted() {
    this.getValue();
  },
  methods: {
    getValue() {
      SpeedApi.fetch(this.vehicle.id).then(data => {
        this.soft = data.soft;
        this.hard = data.hard;
      })
    },
    update() {
      if (this.validate()) {
        SpeedApi.update({
          id: this.vehicle.id,
          soft: this.soft,
          hard: this.hard,
        }).then(response => {
          toastr.success('Speed Limit Updated');
          this.close();
        })
      } else {
        toastr.error('Invalid Limit');
      }
    },
    validate() {
      let val = parseInt(this.soft.value);
      if (!this.soft.value || val < 20 || val > 200) {
        this.soft.error = 'Invalid Limit';
        console.log('returning false');
        return false;
      }
      val = parseInt(this.hard.value);
      if (!this.hard.value || val < 20 || val > 200) {
        this.hard.error = 'Invalid Limit';
        return false;
      }
      return true;
    },
    close() {
      EventBus.$emit('show-car-list');
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
