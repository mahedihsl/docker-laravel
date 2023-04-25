<template>
  <div>
    <h4>
      Assign {{driver.name}}
      <button class="btn btn-default btn-sm pull-right" @click="cancel">
        <i class="fa fa-arrow-left"></i> Back
      </button>
    </h4>
    <hr>
    <div class="row">
      <div class="col-md-6" style="background: #b2dfdb; padding: 10px; margin-left:2%;">
        <div class="form">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Starting Address</label>
                <input type="text" class="form-control" placeholder="ex: Mirpur" v-model="data.start">
                <p class="text-danger"></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Destination Address</label>
                <input type="text" class="form-control" placeholder="ex: Uttara" v-model="data.dest">
                <p class="text-danger"></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Select Date</label>
                <input type="text" class="form-control" id="date" placeholder="">
                <p class="text-danger"></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Select Time</label>
                <input type="text" class="form-control" id="time" placeholder="">
                <p class="text-danger"></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Duration</label>
                <select class="form-control" v-model="data.duration">
                  <option :value="n" v-for="n in 24">{{n}} Hour{{n > 1 ? 's' : ''}}</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <label>Assignment Type</label>
              <div class="radio">
                <label>
                  <input type="radio" value="1" v-model="data.type"> Employee
                </label>
                <label>
                  <input type="radio" value="2" v-model="data.type"> Logistics
                </label>
              </div>
            </div>
            <div class="col-md-6 col-md-offset-4">
              <button class="btn btn-success btn-sm right-space" @click="save">
                <i class="fa fa-check" v-if="!loading"></i>
                <i class="fa fa-refresh fa-spin" v-if="loading"></i> Save
              </button>
              <button class="btn btn-default btn-sm" @click="cancel">
                <i class="fa fa-times"></i> Cancel
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-5 bordered-box" style="background: #c8e6c9; padding: 10px">
        <component :is="viewType"></component>
      </div>
    </div>
    <!--<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 assignmentList">
      <div class="taskTopbar col-md-12">
        <h4>{{driver.name}}'s Assignments</h4>
      </div>
      <div class="taskBody col-md-12">
          <div v-for="(row,i) in assignmentList" class="row" style="margin-top:10px; -moz-box-shadow:3px 3px 5px 6px #ccc; box-shadow:3px 3px 5px 6px #ccc;">
            <div class="col-md-10" >
              <div class="col-md-5" style="padding-top:4px; ">
                <strong>{{row.start}}</strong>
                <p>2:35 PM</p>
              </div>
              <div class="col-md-5" style="padding-top:4px; ">
                <strong>{{row.dest}}</strong>
                <p>4:40 PM</p>
              </div>
              <div class="col-md-10" style="border-top: 1px solid #CFD8DC;">
                <strong>Employee</strong><br>
                <strong>mosharaf</strong>
                <small>01753773427</small>
              </div>
            </div>
            <div class="col-md-2" style="background-color:#A7E2DC; height:100px;">
              <button class="btn btn-sm btn-danger" type="button" name="button" style="margin-top:30px">delete</button>
            </div>
          </div>
      </div>
    </div>-->
  </div>
</template>
<script>
import {mapGetters} from 'vuex';
import EventBus from '../../../util/EventBus';

import Employees from './Employees.vue';
import Logistics from './Logistics.vue';

export default {
  props: ['driver'],
  components: {
    Employees, Logistics,
  },
  data: () => ({
    data: {
      start: '',
      dest: '',
      type: '1',
      duration: '1',
    },
  }),
  computed: {
    ...mapGetters(['employees', 'userId', 'loading', 'message', 'selected', 'previousPage', 'assignmentList']),
    viewType() {
      return parseInt(this.data.type) == 1 ? Employees : Logistics;
    }
  },
  mounted() {
    $('#date').datetimepicker({
        timepicker: false,
        format:'j M Y',
    });
    $('#time').timepicker();
    //this.$store.dispatch('getAssignments',this.driver.id);
  },
  methods: {
    save() {
      let data = Object.assign({}, this.data);
      data.when         = $('#date').val() + ' ' + $('#time').val();
      data.driver_id    = this.driver.id;
      data.car_id       = this.driver.car.id;
      data.user_id      = this.userId;
      data.message      = this.message;
      data.employee_id  = this.selected;

      if (this.data.type == '1' && this.selected == null) {
        toastr.warning('Select an employee');
      } else {
        this.$store.dispatch('assign', data);
      }
    },

    cancel() {
      console.log(this.previousPage);
      if(this.previousPage == null){
        EventBus.$emit('assign-driver-close');
      }
      else if(this.previousPage == "tracker"){

        window.location.href = '/text/tracker';
      }
      else if(this.previousPage == "map"){
        window.location.href = '/map/search';
      }
    }
  }
}
</script>
<style lang="scss" scoped>
.bordered-box {
  border-radius: 2px;
  border: 1px solid #E0E0E0;
  margin-left: 5%;
}
.taskTopbar{
  background-color: #009688;
  margin-top: 5px;
  text-align: center;
  margin-left: 10px;
}
.assignmentList{
  padding: 10px;
}
.taskBody{
  text-align: center;
  margin-left: 10px;
}
</style>
