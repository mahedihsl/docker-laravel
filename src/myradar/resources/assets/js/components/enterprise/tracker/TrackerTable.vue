<template>
  <div class="">

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive driver-location">
      <div class="form filters">

           <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
              <div class="form-group">
                <input type="text" class="form-control" v-model="input.reg_no" placeholder="Type Reg No./Driver">
              </div>
            </div>

            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
               <div class="form-group">
                 <input type="text" class="form-control" v-model="input.name" placeholder="Type Drivers Name">
               </div>
             </div>

             <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                <div class="form-group">
                  <input type="text" class="form-control" v-model="input.phone" placeholder="Type Drivers No.">
                </div>
              </div>

              <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                <div class="form-group">
                  <select class="form-control" v-model="input.district">
                    <option value="">Select District</option>
                    <option v-for="(row, i) in districtlist" v-bind:value="row.name">{{row.name}}</option>
                  </select>
                </div>
              </div>

              <!--<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                 <div class="form-group">
                   <input type="text" class="form-control" v-model="input.thana" placeholder="Type Thana">
                 </div>
               </div>-->
               <!--test line for merge test -->

              <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                <div class="form-group">
                  <select class="form-control" v-model="input.thana">
                    <option value="">Select Thana</option>
                    <option v-for="(row, i) in getthanalist" v-bind:value="row.name">{{row.name}}</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                <button class="btn btn-default pull-right " @click="onRefreshClick">
                 <i class="fa fa-refresh"></i> Refresh
                </button>
              </div>

      </div>


      <Spinner :extra-height="true" v-show="loading"></Spinner>
      <div v-show="!loading">
        <table class="table">
          <thead class="colored-header">
            <tr>
              <th class="col-sm-1">#</th>
              <th class="col-sm-1">Car</th>
              <th class="col-sm-1">Name</th>
              <th class="col-sm-2">Phone</th>
              <th class="col-sm-2">Location</th>
              <th class="col-sm-2">Thana</th>
              <th class="col-sm-1">District</th>
              <th class="col-sm-1">Distance(Km)</th>
              <th class="col-sm-1">Action</th>
            </tr>
          </thead>
          <tbody v-show="!nodata">
            <item v-for="(row, i) in filtered_list" :car="row" :key="i" :serial="i + 1"></item>
          </tbody>
        </table>

        <modal name="info" :scrollable="true" height="auto">
          <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12 modaltitle">
            <h3>Assignment Info</h3>
          </div>
          <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12 assignmentdata">
            <div class="row">
              <div class="col-sm-6 col-lg-6 col-xs-6 col-md-6 driverinfo">
                <h4> <strong>Driver</strong></h4>
                <strong >{{this.assignmentInfo.driverName}}(car:{{this.assignmentInfo.reg_no}})</strong>
                <p >{{this.assignmentInfo.driverPhone}}</p>
              </div>
              <div class="col-sm-6 col-lg-6 col-xs-6 col-md-6 route">
                <h4> <strong>Route</strong></h4>
                <strong>{{this.assignmentInfo.start}} - {{this.assignmentInfo.dest}}</strong>

              </div>
            </div>
            <div class="row">
              <div class="col-sm-6 col-lg-6 col-xs-6 col-md-6 time">
                <h4> <strong>Date & Time</strong></h4>
                <strong>{{this.assignmentInfo.date}}</strong>
                <p>{{this.assignmentInfo.duration}} hour</p>
              </div>
              <div v-if="this.assignmentInfo.type === 1" class="col-sm-6 col-lg-6 col-xs-6 col-md-6 employee">
                <h4> <strong>Employee</strong></h4>
                <strong>{{this.assignmentInfo.employeeName}}</strong>
                <p>{{this.assignmentInfo.employeePhone}}</p>
              </div>
              <div v-if="this.assignmentInfo.type === 2" class="col-sm-6 col-lg-6 col-xs-6 col-md-6 message">
                <h4> <strong>Message</strong></h4>
                <strong>{{this.assignmentInfo.message}}</strong>

              </div>
            </div>
            <div class="">
              <div v-if="this.assignmentInfo.status === true" class="reAssign">
                <a class="btn btn-default btn-sm" :href="'/driver/manage?assign='+this.assignmentInfo.driverId+'&previous=tracker'">
                  <i class="fa fa-link"></i> Reassign
                </a>
              </div>
            </div>
            <div class="row">
              <div  class="okbutton">
                <button class="btn btn-primary btn-sm" @click="hide">
                  <i class="fa "></i> OK
                </button>
              </div>
            </div>
          </div>

        </modal>

        <div class="" v-show="nodata">
          <i class="fa fa-frown-o" aria-hidden="true"></i>
          <br>
          <h3 class="nodata">Sorry, No Data Found</h3>
        </div>

      </div>

    </div>
  </div>
</template>

<script>
import EventBus from '../../../util/EventBus';
import Item from './Item.vue';
import {mapGetters} from 'vuex';
import store from '../../../enterprise/tracker/store';
import Spinner from '../../util/Spinner.vue';
export default {
  name: "",
  store,
  components:{
    Item,
    Spinner,
  },
  data: () => ({
    input:{
      reg_no: '',
      location: '',
      phone: '',
      name: '',
      distance:'',
      thana: '',
      district: '',
    },

  }),
  methods:{
    onRefreshClick(){
      this.refreshing = true;
      EventBus.$emit('refresh-button-clicked');
    },
    getAssignmentInfo(id){

      this.$store.dispatch('getAssignmentInfo',id);
    },
    show () {
      this.$modal.show('info');
    },
    hide () {
      this.$modal.hide('info');
    },
  },
  mounted(){

    this.$store.dispatch('getdrivers');
    EventBus.$on('info-button-clicked',this.getAssignmentInfo.bind(this));
    EventBus.$on('assignment-info-found',this.show.bind(this));
  },
  watch: {
    'input.district':function(val){
      this.input.thana = "";
    //  console.log('value of watcherman'+val);
      if(val == ''){
      //  console.log("watherman is alivenow");
        this.$store.commit('makethanalistempty');
      }
      else {
        this.$store.dispatch('getthanalist',this.input.district);
      }

    },
  },
  computed:{
    ...mapGetters({
      filtered: 'filtered',
        drivers: 'drivers',
        districtlist: 'districtlist',
        loading: 'loading',
        thanalist: 'thanalist',
        assignmentInfo:'assignmentInfo',
    }),
    nodata(){
      return this.drivers.length == 0;
    },
    getthanalist(){
      return this.thanalist;
    },
    filtered_list() {
      return this.filtered({name:this.input.name, phone: this.input.phone, reg_no:this.input.reg_no, thana:this.input.thana, district:this.input.district});
    },

  }
}
</script>
<style lang="scss">

.okbutton{
  text-align: center;
  margin-bottom: 2%;
}
.okbutton .btn{
  padding-left: 20px;
  padding-right: 20px;
}
.reAssign{
  text-align: center;
}
.driverinfo{
  text-align: center;
  border-right: 1px solid #2F87BF;
}
.route{
  text-align: center;

}
.time{

  text-align: center;
}
.employee{
  text-align: center;
}
.message{
  text-align:center;
}
.driverinfo h4{
  color: #2F87BF;
}
.employee h4{
  color: #2F87BF;
}
.time h4{
  color: #2F87BF;
}
.route h4{
  color: #2F87BF;
}
.message h4{
  color: #2F87BF;
}
.modaltitle{
  text-align: center;
  color: #ffffff;
  background-color: #2F87BF;
}
.modaltitle h3{
  margin-top: 0px;
  margin-bottom: 0px;
  padding-top: 10px;
  padding-bottom: 5px;
}
.assignmentdata{

}
.toptitle{
  float:left;
}
.refreshbutton{
  float:right;
}
.driver-location{
  text-align: center;
}
.fa-frown-o{
    margin-top: 20px;
    font-size: 50px;
    color: #9E9E9E;
}
.nodata{
  color: #9E9E9E;
}
.colored-header{
  background-color: #2B77A7;
  height: auto;
  font-size: 14px;
}

th{
  text-align: center;
}
table {
  border-collapse: collapse;
  border-radius: 1em;
  overflow: hidden;
}

</style>
