<template lang="html">
  <div class="col-xs-12 col-md-4">
    <div class="info-boxx">
      <h4 class="text-center box-title">FUEL METER</h4>
      <div class="content" v-show="subscribed">
        <div class="fuel-meter">
          <img src="/img/fuel_meter.png" alt="" class="bg">
          <img src="/img/niddle.png" alt="" class="niddle">
        </div>
      </div>
      <div class="content" v-show="!subscribed">
        <not-subscribed body="Not subscribed"></not-subscribed>
      </div>
    </div>
  </div>
</template>

<script>
import EventBus from '../../../util/EventBus';
import FuelApi from '../../../api/FuelApi';

import NotSubscribed from '../../util/NotSubscribed.vue';

export default {
  props: ['deviceId', 'subscribed'],
  components: {
    NotSubscribed,
  },
  data: () => ({

  }),
  watch: {
    deviceId: function(newVal, oldVal) {
      this.getLatestFuel(newVal);
    }
  },
  mounted() {
    if (this.subscribed) {
      EventBus.$on('latest-fuel-found', this.onDataFound.bind(this));
      this.getLatestFuel(this.deviceId);
    }
  },
  methods: {
    getLatestFuel(id) {
      let api = new FuelApi(EventBus);
      api.latest(id);
    },
    onDataFound(item) {
      let trans = 'translate(-50%, -50%)';
      let degree = Math.floor(-151 + (124 * item.value / 100));
      let elem = $('.niddle');
      elem.animate({deg: degree + 150}, {
        duration: 2000,
        step: function(now) {
            // in the step-callback (that is fired each step of the animation),
            // you can use the `now` paramter which contains the current
            // animation-position (`0` up to `angle`)
            let temp = -150 + now;
            elem.css({
                transform: trans + ' rotate(' + temp + 'deg)'
            });
        }
      });
    }
  }
}
</script>

<style lang="css">
.fuel-meter {
  width: 200px;
  height: auto;
  display: block;
  margin: 0 auto;
}
.fuel-meter .bg {
  width: 100%;
  height: auto;
}
.fuel-meter .niddle {
  width: 20px;
  height: auto;
  position: absolute;
  left: 50%;
  top: 58%;
  transform: translate(-50%, -50%) rotate(-150deg);
  -moz-transform: translate(-50%, -50%) rotate(-150deg);
  -webkit-transform: translate(-50%, -50%) rotate(-150deg);
}
</style>
