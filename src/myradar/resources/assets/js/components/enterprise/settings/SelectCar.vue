<template>
  <div id="">
    <form class="form" id="car-chooser">
      <div class="form-group">
        <label>Choose Car</label>
        <select class="form-control" name="device_id" @change="onSelectChange()" v-model="selectedCar">
          <option v-for="car in this.carList" :value="car.id">{{car.name}}</option>
        </select>
      </div>
      <div class="">
      </div>
    </form>
  </div>
</template>
<script>

import EventBus from '../../../util/EventBus';
import SettingsApi from '../../../api/enterprise/SettingsApi.js';
import {mapGetters, mapActions, mapMutations} from 'vuex';
import store from '../../../enterprise/settings/store';
export default {
  store,
  name: "",
  data: () => ({
    carList:[],
    selectedCar: null,
  }),
  computed:{
    ...mapGetters({
      userId: 'userId',
    }),

  },
  mounted() {
    //do something after mounting vue instance
    EventBus.$on('car-list-found', this.onCarListFound.bind(this));
    this.$store.dispatch('getCars', this.userId);
  },
  methods: {
    ...mapActions('fence', ['list', 'save']),
    ...mapMutations('fence', ['selectedCarId']),
    onCarListFound(data) {
      this.carList = data.items;
      this.selectedCar = data.items[0].id;
      this.$store.dispatch('getSettings',[this.selectedCar, this.userId]);
      this.list(this.selectedCar);
      this.selectedCarId(this.selectedCar);
    },
    onSelectChange(){
      this.$store.dispatch('getSettings',[this.selectedCar, this.userId]);
      this.list(this.selectedCar);
      this.selectedCarId(this.selectedCar);
    }
  }


}
</script>
<style lang="scss" scoped>
</style>
