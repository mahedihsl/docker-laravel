<template>
    <tr>
      <td>{{serial}}</td>
      <td>{{bus.reg_no}}</td>
      <td>{{bus.start}}</td>
      <td>{{bus.dest}}</td>
      <td v-if="bus.startId == null"> <button class="btn btn-primary" @click="onNewRouteClick(0, bus._id)" type="button" name="button"><i class="fa fa-plus" aria-hidden="true"></i> New Route</button></td>
      <td v-if="bus.startId != null"> <button class="btn btn-danger" @click="onDeleteClick([bus._id, bus.startId, bus.destId])" style="padding-left: 32px; padding-right:32px;" type="button" name="button"> Delete</button></td>
    </tr>
</template>
<script>

import store from '../../bus/store';
import {mapGetters} from 'vuex';
import EventBus from '../../util/EventBus';
export default {
  props:['bus','serial'],
  name: "",
  data: () => ({

  }),
  computed:{
    ...mapGetters({SelectedCompany:'SelectedCompany'}),
  },
  methods: {
    onNewRouteClick(val, reg_no) {
      //console.log(reg_no);
      this.$store.commit('selectedBus',reg_no);
      this.$store.commit("changeView", val);
    },
    onDeleteClick(data){
      this.$store.dispatch("deleteRoute", data);
      EventBus.$emit('company-changed',this.SelectedCompany);
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
