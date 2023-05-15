<template lang="html">
  <div class="col-xs-12 col-md-6">
    <div class="info-boxx">

        <h4 class="text-center box-title">YOUR CAR IS</h4>

      <div class="content" v-if="!!status && subscribed">
        <img :src="lockImage" alt="" class="img icon-main">
        <span class="full-width text-center text-main" :class="lockStyle">{{lockText}}</span>
        <strong class="full-width text-center">
          Your car is <span :class="engineStyle">{{engineText}}</span> now
        </strong>
        <div class="col-xs-6 col-md-6 col-lg-6 lockunclock-button">
          <button class="btn btn-action action-blue " @click="toggleState">
            <i class="fa fa-spinner fa-spin" v-if="progress"></i> {{buttonText}}
          </button>
        </div>
        <div class="col-xs-6 col-md-6 col-lg-6 onoff-button">
          <button v-on:click="show()" type="button" name="button" class="btn btn-action action-green">Car On/Off History</button>
        </div>
      </div>
      <div class="content" v-if="!subscribed">
        <not-subscribed body="Not subscribed"></not-subscribed>
      </div>


    </div>
    <!--modal starts here -->
    <modal name="caronoff-historymodal" :scrollable="true" height="auto"  :pivotY="0.3">
      <div class="modal-box">
        <div class="col-xs-12 col-md-12 col-lg-12 modaltopbar">
          <div class="col-xs-6 col-md-6 col-lg-6 modal-titlecontainer">
            <span class="modal-title">Car On/Off History For Car {{this.regNo}}</span>
          </div>
          <div class="col-xs-6 col-md-6 col-lg-6 close-buttoncontainer">
            <!--<button type="button" name="button" class="btn btn-default close-btn">Close</button>-->
            <i v-on:click="hide()" class="fa fa-times close-btn"></i>
          </div>
        </div>
          <div class="col-xs-12 col-md-12 col-lg-12 historyvalue" v-for="(item,i) in modalvalue" v-bind:class="isodd(i)">
            <engine-row :item ="item" :index="i"> </engine-row>
          </div>
      </div>
    </modal>
  </div>
</template>

<script>
import EventBus from '../../../util/EventBus';
import EngineApi from '../../../api/EngineApi';
import EventApi from '../../../api/EventApi';
import EngineRow from './EngineRow.vue';
import NotSubscribed from '../../util/NotSubscribed.vue';

export default {
  props: ['deviceId', 'subscribed', 'regNo'],
  components: {
    NotSubscribed,
    EngineRow,
  },
  data: () => ({
    status: null,
    progress: false,
    modalvalue:[],
    eventType:[1,2],
    oddcheck:0,

  }),
  computed: {
    lockImage() {
      let name = this.status.lock ? 'lock' : 'unlock';
      return `/images/${name}.png`;
    },
    lockText() {
      return this.status.lock ? 'Locked' : 'Unlocked';
    },
    lockStyle() {
      return !this.status.lock ? 'text-success' : 'text-danger';
    },
    engineStyle() {
      return this.status.engine ? 'text-success' : 'text-danger';
    },
    engineText() {
      return this.status.engine ? 'ON' : 'OFF';
    },
    buttonText() {
      return this.status.lock ? 'Unlock Now' : 'Lock Now';
    },

  },
  watch: {
    deviceId: function(newVal, oldVal) {
      this.getEngineStatus(newVal);
    }
  },
  mounted() {
    if (this.subscribed) {
      EventBus.$on('engine-status-found', this.onEngineStatusFound.bind(this));
      EventBus.$on('lock-status-found', this.onLockStatusFound.bind(this));
      EventBus.$on('lock-status-unchanged', this.onLockStatusUnchanged.bind(this));
      this.getEngineStatus(this.deviceId);
    }
  },
  methods: {
    isodd(i){
      //console.log(i);
      return i%2===1 ? 'grayback' : 'whiteback';
    },
    show () {
      EventApi.recent(this.deviceId, 100, this.eventType).then(list=>this.modalvalue=list);
      this.$modal.show('caronoff-historymodal');
    },
    hide () {
      this.$modal.hide('caronoff-historymodal');
    },
    getEngineStatus(id) {
      let api = new EngineApi(EventBus);
      api.getStatus(id);
    },
    onEngineStatusFound(data) {
      this.status = data;
    },
    onLockStatusFound(value) {
      this.status.lock = value;
      this.progress = false;
    },
    toggleState() {
      this.progress = true;
      let api = new EngineApi(EventBus);
      api.toggleStatus(this.deviceId, (this.status.lock + 1) % 2);
    },
    onLockStatusUnchanged(){
      this.progress = false;
    }
  }
}

</script>

<style lang="css">
.grayback{
  background-color: #E0E0E0;
}
.databody {
  padding:0px;
}
.slno{
  padding:0px;
  text-align:center;
}
.data{
  font-size: 16px;
}
.subdata{
  padding-left: 18px;
  font-size: 13px;
  color: #9E9E9E;
}
.modal-titlecontainer{
  padding: 0px;
}
.close-buttoncontainer{
  padding: 0px;
}
.modaltopbar{
  padding-top: 10px;
  border-bottom: 1px solid #E0E0E0;
  background-color: #039BE5;
  padding-bottom: 10px;
  z-index: 1001;
}
.modal-title{
  font-weight: bold;
  color: #ffffff;
  font-size: 17px;
}
.historyvalue{
  padding:10px;
  border-bottom:1px solid #E0E0E0;
}
.close-btn{
  float:right;
  padding:2px;
  padding-left:10px;
  padding-right: 10px;
  color:#ffffff;
}
.btn {
  padding-left:5px;
  padding-right: 5px;
  margin-left: 0px;
  margin-right: 0px;
}
.onoff-button{
  padding:0px;
  padding-left:5px;
}
.lockunclock-button{
  padding-right:5px;
  padding-left: 25px;
}
.action-blue{
  padding-left:20px;
  padding-right:20px;
}
</style>
