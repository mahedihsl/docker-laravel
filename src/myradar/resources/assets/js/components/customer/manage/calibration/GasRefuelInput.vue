<template>
  <div class="col-xs-12 refuel-input-list v-margin">
    <h5 class="text-center" v-if="!log">No Refuel Input Found</h5>
    <!-- <h5 v-if="!!log">
      {{log.time}} <i class="fa fa-times text-danger pull-right clickable" @click="onDelete"></i>
    </h5> -->
    <table class="table table-responsive table-striped" v-if="!!log">
      <caption>User Refuel Input</caption>
      <thead>
        <tr>
          <th class="col-xs-2">Magnitude</th>
          <th class="col-xs-2">Base</th>
          <th class="col-xs-2">Price</th>
          <th class="col-xs-3">Factor</th>
          <th class="col-xs-3">Date&time</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="o in log">
          <td>{{o.magnitude}}</td>
          <td>{{o.base}}</td>
          <td>{{o.price}}</td>
          <td>{{(o.factor).toFixed(2)}}</td>
          <td>{{o.time}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import EventBus from '../../../../util/EventBus';
import CalibrationApi from '../../../../api/CalibrationApi';

export default {
  props: ['log'],
  data: () => ({

  }),
  mounted() {
    console.log("fuck kelu"+this.log);
  },
  methods: {
    onDelete() {
      const instance = this;
      $.confirm({
        title: 'Are You Sure ?',
        content: 'All these data will be deleted',
        type: 'red',
        theme: 'material',
        buttons: {
          confirm: {
            btnClass: 'btn-green',
            action: function () {
              let api = new CalibrationApi(EventBus);
              api.deleteGas(instance.log.id);
            },
          },
          cancel: function () {

          }
        }
      });
    }
  }
}
</script>
<style scoped>

</style>
