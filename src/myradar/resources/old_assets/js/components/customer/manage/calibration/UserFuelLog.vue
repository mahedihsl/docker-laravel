<template>
  <div class="col-xs-12 log-list v-margin">
    <h5 class="text-center" v-if="!log">No Log Found</h5>
    <!-- <h5 v-if="!!log">
      {{log.time}} <i class="fa fa-times text-danger pull-right clickable" @click="onDelete"></i>
    </h5> -->
    <h5 class="text-center">User Input</h5>
    <table class="table table-responsive table-striped text-center" v-if="!!log">
      <thead>
        <tr>
          <th class="col-xs-6">Percentage</th>
          <th class="col-xs-6">Value</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="o in log.data">
          <td>{{o.perc}} %</td>
          <td>{{o.value}}</td>
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
              api.deleteFuel(instance.log.id);
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
