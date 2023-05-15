<template>
  <div id="">
    <div class="busList">
      <table class="table table-striped">
        <thead>
          <tr>
            <th class="col-xs-1">#</th>
            <th class="col-xs-2">Reg No.</th>
            <th class="col-xs-2">Start Location</th>
            <th class="col-xs-2">End Location</th>
            <th class="col-xs-1">task</th>
          </tr>
        </thead>
        <tbody>
          <BusItem v-for="(row,i) in busList" :key="i" :bus="row" :serial="i+1"></BusItem>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>

import store from '../../bus/store';
import {mapGetters} from 'vuex';
import BusItem from './BusItem.vue';
import EventBus from '../../util/EventBus';


export default {
  store,
  props: ['company'],
  components: {
    BusItem,
  },
  name: "",
  data: () => ({

  }),
  mounted() {
    //this.$store.dispatch('getBusList',this.SelectedCompany);
    //EventBus.$on('bus-list-found');
    EventBus.$on('company-changed', this.getNewBusList.bind(this));
    EventBus.$on('route-save-done', this.onSaveDone.bind(this));
    EventBus.$on('route-deleted', this.onDeleteDone.bind(this));
  },
  computed:{
    ...mapGetters({
      SelectedCompany:'SelectedCompany',
      busList: 'busList',
    }),
  },
  methods: {

    getNewBusList(id){
      //console.log('came in buslist');
      this.$store.dispatch('getBusList',id);

    },

    onSaveDone(){
      toastr.success('Route saved successfully!');
    },

    onDeleteDone(){
      toastr.success('Route deleted successfully!');
    }
  }
}
</script>
<style lang="scss" scoped>
.busList table {
  text-align: center;
}
th, td{
  text-align: center;
}
</style>
