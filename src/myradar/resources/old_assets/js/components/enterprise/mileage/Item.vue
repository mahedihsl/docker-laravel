<template>
  <tr class="clickable" @click="showReport">
    <td>{{serial}}</td>
    <td>{{car.name}}</td>
    <td>{{car.driver ? car.driver.name : '--'}}</td>
    <td>{{car.driver ? car.driver.phone : '--'}}</td>
    <td>
      <span class="badge" :class="color" v-if="hasInfo">{{car.info.mileage}} Km</span>
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
      if (this.car.info.mileage < 5) {
        return 'bg-black';
      } else if (this.car.info.mileage < 10) {
        return 'bg-fuchsia';
      } else if (this.car.info.mileage < 20) {
        return 'bg-orange';
      } else if (this.car.info.mileage < 30) {
        return 'bg-purple';
      }
      return 'bg-red';
    }
  },
  beforeMount() {
    //do something before mounting vue instance
    EventBus.$on('month-filter-changed', () => {
      this.car.info = null;
      this.getMileageSum(this.car.id);
    });
  },
  mounted() {
    this.getMileageSum(this.car.id);
  },
  methods: {
    ...mapActions('mileage', ['getMileageSum', 'getMileageReport']),
    showReport() {
      this.getMileageReport(this.car.id);

      EventBus.$emit('show-chart', 3, this.car);
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
