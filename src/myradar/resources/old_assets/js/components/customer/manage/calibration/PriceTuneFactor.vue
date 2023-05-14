<template>
  <div class="">
    <div class="col-xs-12">
      <div class="form">
        <table class="table">
          <thead>
            <tr>
              <th class="col-xs-2">Serial</th>
              <th class="col-xs-5">Gas Peak Value</th>
              <th class="col-xs-5">Price Tune Factor</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, i) in factors">
              <td><strong>{{i + 1}}.</strong></td>
              <td><input type="text" class="form-control" v-model="item.value" placeholder="Gas Peak Value"></td>
              <td><input type="text" class="form-control" v-model="item.factor" placeholder="Price Tune Factor"></td>
            </tr>
          </tbody>
        </table>
        <div class="material-switch pull-left relaxed">
          <strong class="relaxed">Enable Tuning</strong>
          <input id="tuneenabler" type="checkbox" v-model="status"/>
          <label for="tuneenabler" class="label-success"></label>
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
  }),
  computed: {
    title() {
      return this.type == 1 ? 'Fuel Price Tune Factor' : 'Gas Price Tune Factor';
    }
  },
  mounted() {
    EventBus.$on('price-tune-factor-found', this.onFactorFound.bind(this));
    EventBus.$on('price-tune-factor-updated', this.onFactorUpdated.bind(this));

    for (let i = 0; i < 3; i++) {
      this.factors.push({
        value: '',
        factor: '',
        // TODO: declare error property
      });
    }

    let api = new CalibrationApi(EventBus);
    api.getPriceTuneFactor(this.carId);
  },
  methods: {
    onFactorFound(val) {
      let arr = this.type == 1 ? val.fuel : val.gas;
      if (arr == null) return;

      this.status = arr.status ? 1 : 0;
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
      toastr.success('Price tuning factor updated');
      this.onFactorFound(data);
    },

    update() {
      if (this.validate()) {
        let api = new CalibrationApi(EventBus);
        api.updatePriceTuneFactor({
          id      : this.carId,
          factors : this.factorJson(),
          type    : this.type,
          status  : this.status,
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
