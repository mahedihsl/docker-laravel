<template>
  <tr class="clickable" @click="showReport">
    <td>{{serial}}</td>
    <td>{{car.name}}</td>
    <td>{{car.driver ? car.driver.name : '--'}}</td>
    <td>{{car.driver ? car.driver.phone : '--'}}</td>
    <td>
      <span class="badge" :class="color" v-if="hasInfo">{{car.info.time}} Hrs</span>
      <i class="fa fa-spinner fa-pulse" v-if="!hasInfo"></i>
    </td>
    <td>
      <span v-if="hasInfo">{{car.info.month}}</span>
      <i class="fa fa-spinner fa-pulse" v-if="!hasInfo"></i>
    </td>
  </tr>
</template>
<script>
import EventBus from '../../../util/EventBus';
import {mapActions} from 'vuex';

export default {
  props: ['car', 'serial'],
  data: () => ({

  }),
  computed: {
    hasInfo() {
      return !!this.car.info;
    },
    color() {
      if (this.car.info.time < 2) {
        return 'bg-black';
      } else if (this.car.info.time < 4) {
        return 'bg-fuchsia';
      } else if (this.car.info.time < 6) {
        return 'bg-orange';
      } else if (this.car.info.time < 8) {
        return 'bg-purple';
      }
      return 'bg-red';
    }
  },
  beforeMount() {
    //do something before mounting vue instance
    EventBus.$on('month-filter-changed', () => {
      this.car.info = null;
      this.getDrivingHourSum(this.car.id);
    });
  },
  mounted() {
    this.getDrivingHourSum(this.car.id);
  },
  methods: {
    ...mapActions('driving', ['getDrivingHourSum', 'getDrivingHourReport']),
    showReport() {
      this.getDrivingHourReport(this.car.id);

      EventBus.$emit('show-chart', 1, this.car);
    }
  }
}
</script>
<style lang="scss" scoped>
tr {
  text-align: center;
}
tr:hover{
  font-weight: bold;
  border-left: 4px solid #3c8dbc;
  color: #3c8dbc;
  background: #3c8dbc;
  
}
</style>
