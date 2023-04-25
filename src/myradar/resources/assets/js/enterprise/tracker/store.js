import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import EventBus from '../../util/EventBus';
import TrackerApi from '../../api/enterprise/TrackerApi';

export default new Vuex.Store({
  state:{
    driverlist: [],
    userId: null,
    districtlist: [],
    loading: true,
    thanalist: [],
    assignmentInfo:[],
  },
  getters:{
    drivers(state){
      return state.driverlist
    },
    thanalist(state){
      return state.thanalist
    },
    loading(state){
      return state.loading
    },
    districtlist(state){
      return state.districtlist
    },
    userId(state) {
        return state.userId
    },
    selectedDistrict(state){
      return state.selectedDistrict;
    },
    filtered(state) {

      return (params) => {

        let newlist = state.driverlist;
        if(params.name != "")
            newlist = newlist.filter(v => v.driver.name.toLowerCase().includes(params.name.toLowerCase()));
        if(params.reg_no != "")
            newlist = newlist.filter(v => v.reg_no.includes(params.reg_no));
        if(params.phone != "")
            newlist = newlist.filter(v => v.driver.phone.includes(params.phone));
        if(params.thana != "")
            newlist = newlist.filter(v => v.location.thana == params.thana);
        if(params.district != "")
           newlist = newlist.filter(v => v.location.district == params.district);

        return newlist;
      }
    },
    assignmentInfo(state){
      return state.assignmentInfo;
    }
  },
  mutations:{
    drivers(state, data){
      //console.log(state.driverlist);
      state.driverlist = data['drivers'].data;
      for(var i=0;i<state.driverlist.length;i++)
      {
        // if(state.driverlist[i].driver === null){
        //   console.log("null");
        //   //state.driverlist[i].driver.name = "--";
        //   Vue.set(state.driverlist[i].driver,name,"--");
        //   state.driverlist[i].driver.phone = "--";
        // }
        // else {
        //   console.log("not null");
        // }
        state.driverlist[i].location = null;
        Vue.set(state.driverlist[i],location,null);
      }

      state.loading = false;
      state.districtlist = data['districtlist'];
    },
    locations(state, info){

      let ind = state.driverlist.findIndex(val => val.id == info.carId);
      //console.log(state.driverlist[ind]);
      Vue.delete(state.driverlist[ind], location);
      state.driverlist[ind].location = info.data;
      Vue.set(state.driverlist[ind], location , info.data);
      //console.log(state.driverlist[ind].location);
    },
    thanalist(state, info){
      state.thanalist = info.data.thanalist;

    },
    userId(state, id) {
        state.userId = id
    },
    setlocationtonull(state, carId){
      let ind = state.driverlist.findIndex(val => val.id == carId);
      Vue.delete(state.driverlist[ind], location);
      state.driverlist[ind].location = null;
      Vue.set(state.driverlist[ind], location , null);
      EventBus.$emit('made-location-null');
    },
    makethanalistempty(state){
      state.thanalist.splice(0,state.thanalist.length);
    },
    assignmentInfo(state,data){

      state.assignmentInfo = data.data;
      let ind = state.driverlist.findIndex(val => val.driver.id == state.assignmentInfo.driverId);

      state.assignmentInfo.status = state.driverlist[ind].location.status;

    }
  },
  actions:{

    getdrivers({commit, state}) {

        TrackerApi.list(state.userId).then(data => {
            commit('drivers', data);
            EventBus.$emit('driver-list-found');
        })
    },

    getlocations({commit,state}, carId){
      TrackerApi.locations(carId).then(data => {
        commit('locations',{data, carId});
        EventBus.$emit('location-found',carId);
      })
    },
    getthanalist({commit,state}, districtId){
      //console.log(districtId);
      TrackerApi.thanalist(districtId).then(data =>{
        commit('thanalist',{data, districtId});
      })
    },
    getAssignmentInfo({commit,state},driverId){

      TrackerApi.assignmentInfo(driverId).then(data =>{
        commit('assignmentInfo', {data});
        EventBus.$emit('assignment-info-found',driverId);
      })
    }

  }
})
