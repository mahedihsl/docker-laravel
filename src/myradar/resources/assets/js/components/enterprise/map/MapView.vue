<template>
  <div class="">
    <div class="form-inline col-xs-12 zoneDropdown">
      <div class="form-group">
        <select class="form-control right-space" v-model="zone">
          <option value="-1">Select Zone</option>
          <option v-for="(z, i) in zones" :value="i">{{z.name}}</option>
        </select>
      </div>
      <button type="button" class="btn btn-primary btn-sm right-space" @click="search">
        <i v-if="!isLoading" class="fa fa-search"></i>
        <i v-if="isLoading"class="fa fa-spinner fa-spin"></i>
        Search
      </button>
    </div>


      <div style="height: 480px;" class="col-xs-10" id="map">
      </div>

      <div class="col-xs-2 car-selector">
            <div class="sidebar">
                <div class="well">
                    <ul class="nav">
                        <li class="nav-header"><h4>Cars</h4></li>
                        <li v-for="(row,i) in allCars" :value="i"><a href="#" @click="onCarClick(row)">{{row.name}}</a></li>
                    </ul>
                </div>
                <!--/.well -->
            </div>
            <!--/sidebar-nav-fixed -->
        </div>

  </div>
</template>
<script>
import EventBus from '../../../util/EventBus';

import {Map} from '../../../position/map';
import {Car} from '../../../position/car';
import {Point} from '../../../position/point';

import {mapGetters} from 'vuex';

export default {
  data: () => ({
    loading: false,
    map: null,
    zone: '-1',
    cars: [],
    mapBound: null,
    locations: [
      [
        [23.774136, 90.363413, 0],
        [23.773821, 90.369507, 1],
        [23.771408, 90.367964, 1],
        [23.768835, 90.358458, 0],
        [23.773799, 90.365353, 1],
      ],
      [
        [23.810198, 90.366414, 1],
        [23.815576, 90.365899, 0],
        [23.820758, 90.368560, 1],
        [23.824369, 90.363153, 1],
      ],
      [
        [23.794136, 90.403149, 0],
        [23.794057, 90.412075, 0],
        [23.797394, 90.401389, 0],
        [23.789226, 90.400059, 1],
      ],
      [
        [23.867648, 90.398946, 1],
        [23.874554, 90.397744, 0],
        [23.878421, 90.401379, 1],
        [23.870964, 90.402795, 0],
      ],
      [
        [23.747998, 90.380093, 1],
        [23.749922, 90.378891, 1],
        [23.746190, 90.371424, 1],
        [23.754713, 90.372668, 0],
      ]
    ]
  }),
  computed: {
    ...mapGetters(['zones', 'userId', 'allCars']),

    isLoading()
    {
      return this.loading;
    }
  },
  mounted() {
    EventBus.$on('car-list-found', this.onCarListFound.bind(this));

    /**
     * Create Map Instance
     * @type {Map}
     */
    this.map = new Map('map');
    this.map.init();


    this.$store.dispatch('getZones');
    this.$store.dispatch('getAllCars');
    /**
       * Connect to Pusher Server
       * @type {Pusher}
       */
      let pusher = new Pusher('e104f912331445995538', {
          cluster: 'ap1',
          encrypted: false,
      });
      let state = pusher.connection.state;

      let channel = pusher.subscribe('map-channel-' + this.userId);
      channel.bind('map-event', function(data) {
        let message = data.message;
        for (let i = 0; i < this.cars.length; i++) {
          if (this.cars[i].isLiveMode() && this.cars[i].getDeviceId() == message.device_id) {
            this.cars[i].moveInLiveMode(message);
            break;
          }
        }
      }.bind(this));
      channel.bind('new-event', function(message) {
        let type = message.type;
        if (type != 1 && type != 2) return;
        for (var i = 0; i < this.cars.length; i++) {
          if (this.cars[i].isLiveMode() && this.cars[i].getDeviceId() == message.data.device_id) {
            this.cars[i].setAsRed(!message.data.status ? true : false)
            break;
          }
        }
      }.bind(this));
  },
  methods: {
    search() {

      let selected = parseInt(this.zone);
      if (selected > -1) {
        this.loading = true;
        this.$store.dispatch('getCars', this.zones[selected].id);
        return;
      }

      alert('select a zone');
    },
    onCarListFound(list) {
      this.mapBound = new google.maps.LatLngBounds();
      this.loading = false;
      //console.log('car list length: ', list.length);
      for (let k = 0; k < this.cars.length; k++) {
          this.cars[k].removeFromMap();
      }
      this.cars = [];
      for (let i = 0; i < list.length; i++) {
        let c = new Car(list[i].device, true);
        c.setVehicleType(list[i].vehicle_type)
        c.setMap(this.map);
        this.cars.push(c);
        this.mapBound = this.cars[i].startLiveTracking(this.mapBound, list.length);
      }

    },
    onCarClick(car){
      this.mapBound = new google.maps.LatLngBounds();
      this.zone = '-1';
      for (let k = 0; k < this.cars.length; k++) {
          this.cars[k].removeFromMap();
      }
      this.cars = [];


      let c = new Car(car.device, true);
      c.setVehicleType(car.vehicle_type)
      c.setMap(this.map);
      this.cars.push(c);
      this.mapBound = this.cars[0].startLiveTracking(this.mapBound, this.cars.length);

    }
  }
}
</script>
<style lang="scss" scoped>
.sidebar{
  overflow-y: auto;
  position: absolute;
  max-height: 480px;
  text-align: center;
  padding-left: 20%;
  padding-right: 0px;
  width: 100%;
}
h4{
  margin: 0px;
  padding-top:6px;
  padding-bottom:6px;
  font-weight: bold;
}

.zoneDropdown{
  margin-bottom: 2%;
}

.nav-header {
    border-bottom: 4px solid rgb(84, 72, 236);
}
.sidebar a{
  background-color: #ffffff ;
  color: #000000;
  // border-bottom: 2px solid rgb(255,255,255);
}
.sidebar a:hover{
  color:rgb(84, 72, 236);
}
.sidebar a::after{
  content: '';
  display: block;
  width: 0;
  height: 2px;
  background: rgb(84, 72, 236);
  transition: width .3s;
}

.sidebar a:hover::after{
  width: 100%;
  transition: width .3s;
  // border-bottom: 2px solid rgb(84, 72, 236);
  // transition: all .3s ease-out;
}

.sidebar a:active{
  background: rgb(84, 72, 236);
  color: rgb(255, 255, 255);
}

.sidebar a:focus{
  background: rgb(84, 72, 236);
  color: rgb(255, 255, 255);
}

.well {
  padding: 0px;
  width: 100%;
}

.car-selector{
  padding:0px;
}

/* width */
::-webkit-scrollbar {
  width: 7px;
}

/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey;
  border-radius: 10px;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #7986CB;
  border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #5C6BC0;
}

</style>
