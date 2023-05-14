<template>
  <div class="">
    <div class="col-xs-12">
      <div class="form">
        <table class="table">
          <thead>
            <tr>
              <th class="col-xs-2">Serial</th>
              <th class="col-xs-5">Gas Value</th>
              <th class="col-xs-5">Price Factor</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, i) in factors">
              <td><strong>{{i + 1}}.</strong></td>
              <td><input type="text" class="form-control" v-model="item.value" placeholder="Gas Value"></td>
              <td><input type="text" class="form-control" v-model="item.factor" placeholder="Price Factor"></td>
            </tr>
          </tbody>
        </table>
        <div class="material-switch pull-left relaxed" style="margin-bottom:10px;">
          <strong class="relaxed" style="margin-right:40px;">Notify Event</strong>
          <input id="CustomerEnabler" type="checkbox" v-model="event_status"/>
          <label for="CustomerEnabler" class="label-success"></label>
        </div>
        <div class="material-switch pull-left relaxed">
          <strong class="relaxed" style="padding-right:7px;">Notify Amount</strong>
          <input id="enabler" type="checkbox" v-model="status"/>
          <label for="enabler" class="label-success"></label>
        </div>
        <button type="button" class="btn btn-success btn-sm pull-right" @click="update()">
          <i class="fa fa-save"></i> Update
        </button>
      </div>
    </div>
  </div>
</template>
<script>
import EventBus from '../../../../util/EventBus';
import CalibrationApi from '../../../../api/CalibrationApi';

export default {
  props: ['type', 'carId'],
  data: () => ({
    id: '',
    factors: [],
    status: 0,
    event_status: 0,
  }),
  computed: {
    title() {
      return this.type == 1 ? 'Fuel Price Factor' : 'Gas Price Factor';
    }
  },
  mounted() {
    EventBus.$on('price-factor-found', this.onFactorFound.bind(this));
    EventBus.$on('price-factor-updated', this.onFactorUpdated.bind(this));

    for (let i = 0; i < 3; i++) {
      this.factors.push({
        value: '',
        factor: '',
        // TODO: declare error property
      });
    }

    let api = new CalibrationApi(EventBus);
    api.getPriceFactor(this.carId);
  },
  methods: {
    onFactorFound(val) {
      let arr = this.type == 1 ? val.fuel : val.gas;
      this.status = arr.status ? 1 : 0;
      this.event_status = arr.event_status ? 1 : 0;
      for (let i = 0; i < 3; i++) {
        if (i < arr.data.length) {
          this.factors[i].value = arr.data[i].value;
          this.factors[i].factor = arr.data[i].factor;
        } else {
          this.factors[i].value = '';
          this.factors[i].factor = '';
        }
      }
    },

    onFactorUpdated(data) {
      toastr.success('Pricing factor updated');
      this.onFactorFound(data);
    },

    update() {
      if (this.validate()) {
        let api = new CalibrationApi(EventBus);
        api.updatePriceFactor({
          id          : this.carId,
          factors     : this.factorJson(),
          type        : this.type,
          status      : this.status,
          event_status  :this.event_status,
        });
      }
    },

    factorJson() {
      let arr = [];
      for (let i = 0; i < this.factors.length; i++) {
        if (this.factors[i].value && this.factors[i].factor) {
          arr.push(this.factors[i]);
        }
      }
      return JSON.stringify(arr);
    },

    validate() {
      // TODO: write valid logic
      return true;

      // let val = parseFloat(this.factor.value);
      //
      // if (!val || val <= 0 || val > 5) {
      //   this.error = 'Invalid Number';
      //   return false;
      // }
      //
      // this.error = '';
      // return true;
    }
  }
}
</script>
<style lang="css" scoped>
.relaxed {
  margin-right: 20px;
}
</style>
