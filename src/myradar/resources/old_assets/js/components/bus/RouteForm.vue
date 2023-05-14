<template>
  <div id="">
    <div class="">
      <button class="btn btn-primary pull-right" @click="onBackClick(1)" type="button" name="button"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
    </div>
    <div class="col-xs-12 col-md-12 col-lg-12">
      <form>
        <div class="form-group">

        </div>
      </form>
    </div>
    <div class="co-xs-12 col-md-5 col-lg-5 start">
      <h4>Select start point</h4>
      <form>
        <div class="form-group">
          <label>Name:</label>
          <input type="text" class="form-control" v-model="route.start.name">
        </div>
        <div class="form-group">
          <label>Latitude:</label>
          <input type="text" class="form-control" v-model="route.start.lat">
        </div>
        <div class="form-group">
          <label>Longitude:</label>
          <input type="text" class="form-control" v-model="route.start.lng">
        </div>
        <div class="form-group">
          <label>Radius:</label>
          <input type="text" class="form-control" v-model="route.start.radius">
        </div>
      </form>
    </div>
    <div class="co-xs-12 col-md-5 col-lg-5 end">
      <h4>Select end point</h4>
      <form>
        <div class="form-group">
          <label>Name:</label>
          <input type="text" class="form-control" v-model="route.dest.name">
        </div>
        <div class="form-group">
          <label>Latitude:</label>
          <input type="text" class="form-control" v-model="route.dest.lat">
        </div>
        <div class="form-group">
          <label>Longitude:</label>
          <input type="text" class="form-control" v-model="route.dest.lng">
        </div>
        <div class="form-group">
          <label>Radius:</label>
          <input type="text" class="form-control" v-model="route.dest.radius">
        </div>
      </form>
    </div>
    <div class="col-xs-12 col-md-12 col-lg-12">
      <button class="btn btn-success btn-block" type="button" name="button" :disabled="saveClicked" @click="save(route, 1)">Save</button>
    </div>
  </div>
</template>
<script>
import store from '../../bus/store';
import {mapGetters} from 'vuex';
import EventBus from '../../util/EventBus';
export default {
  props: ['showForm'],
  name: "",
  store,
  data: () => ({
    saveClicked: false,
    route:{
      routename: null,
      start:{
        name: null,
        lat: null,
        lng: null,
        radius: null,
      },
      dest:{
        name: null,
        lat: null,
        lng: null,
        radius: null,
      }
    }
  }),
  mounted() {
    //do something after mounting vue instance

  },
  computed:{
    ...mapGetters({selectedBus:'selectedBus', SelectedCompany: 'SelectedCompany'})
  },
  methods: {

    onBackClick(val) {
      this.$store.commit('changeView',val);
      //console.log(this.SelectedCompany);
      EventBus.$emit('company-changed', this.SelectedCompany);
    },

    save(route, val){
      this.saveClicked = true;
      route.id = this.selectedBus;
      this.$store.dispatch('saveRoute',route);
      this.$store.commit('changeView',val);
      EventBus.$emit('company-changed', this.SelectedCompany);
    }

  },
}
</script>
<style lang="scss" scoped>
.start{
  background-color: #B3E5FC;
  margin: 4%;
}
.end{
  background-color: #B3E5FC;
  margin: 4%  ;
}
</style>
