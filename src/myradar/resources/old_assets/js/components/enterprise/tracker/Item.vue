<template>
    <tr class="trackerRow" v-bind:class="{ colored: isEven }">
      <td>{{serial}}</td>
      <td>{{car.reg_no}}</td>
      <td>{{car.driver.name}}</td>
      <td>{{car.driver.phone}}</td>
      <td v-if="nolocation"> <i class="fa fa-spinner fa-spin"></i></td>
      <td v-if="!nolocation">{{car.location.poi}}</td>
      <td v-if="nolocation"> <i class="fa fa-spinner fa-spin"></i></td>
      <td v-if="!nolocation">{{car.location.thana}}</td>
      <td v-if="nolocation"> <i class="fa fa-spinner fa-spin"></i></td>
      <td v-if="!nolocation">{{car.location.district}}</td>
      <td v-if="nolocation"><i class="fa fa-spinner fa-spin"></i></td>
      <td v-if="!nolocation">{{car.location.distance}}</td>
      <td v-if="nolocation"><i class="fa fa-spinner fa-spin"></i></td>
      <td v-if="!nolocation">
        <p v-if="car.location.status === '-' " href="">{{car.location.status}}</p>
        <a v-else-if="!car.location.status" class="btn btn-default btn-sm" :href="'/driver/manage?assign='+car.driver.id+'&previous=tracker'">
          <i class="fa fa-link"></i> Assign
        </a>
        <button v-else-if="car.location.status" class="btn btn-danger btn-sm" @click="onInfoClick">
          <i class="fa"></i> Booked
        </button>

      </td>
    </tr>
</template>
<script>
import EventBus from '../../../util/EventBus';
import {mapGetters} from 'vuex';
import store from '../../../enterprise/tracker/store';



export default {
  store,
  props:['car','serial'],
  data: () => ({

  }),
  computed:{
    ...mapGetters({
        refreshclicked: 'refreshclicked',
    }),
    nolocation()
    {
        return this.car.location == null;
    },
    isEven(){
      return 1 - this.serial%2;
    }
  },
  mounted(){
        if(this.car.location == null)
        {
          this.$store.dispatch('getlocations', this.car.id);
        }
        EventBus.$on('refresh-button-clicked',this.refreshbuttonclicked.bind(this));
        //EventBus.$on('location-found',this.nolocation.bind(this));
        //EventBus.$on('made-location-null',this.nolocation.bind(this));

  },
  methods:{
    refreshbuttonclicked(){
      this.$store.commit('setlocationtonull',this.car.id);
     this.$store.dispatch('getlocations', this.car.id);
    },
    onInfoClick(){

      EventBus.$emit('info-button-clicked', this.car.driver.id);
    },
    show () {
      this.$modal.show('info');
    },
    hide () {
      this.$modal.hide('info');
    },

  }
}
</script>
<style lang="scss" scoped>
tr{
  font-size: 14px;
}
tr:hover{
  font-weight: bold;
  border-left: 4px solid #3c8dbc;
  color: #3c8dbc;
}
.colored{
  background: #E3F2FD;
}
</style>
