<template lang="html">
  <div class="fuel-meter-box">
    <div class="content">
      <div class="fuel-meter">
        <img src="/img/fuel_meter.png" alt="" class="bg" />
        <img src="/img/niddle.png" alt="" class="niddle" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['value'],
  components: {},
  data: () => ({}),
  watch: {
    value(newVal, oldVal) {
      this.onValueChanged(newVal)
    },
  },
  mounted() {
    this.onValueChanged(this.value)
  },
  methods: {
    onValueChanged(val) {
      let trans = 'translate(-50%, -70%)'
      let degree = Math.floor(-151 + (124 * val) / 100)
      console.log(`updating niddle`, val, degree)
      let elem = $('.niddle')
      elem.animate(
        { deg: degree + 150 },
        {
          duration: 2000,
          step: function(now) {
            // in the step-callback (that is fired each step of the animation),
            // you can use the `now` paramter which contains the current
            // animation-position (`0` up to `angle`)
            let temp = -150 + now
            elem.css({
              transform: trans + ' rotate(' + temp + 'deg)',
            })
          },
        }
      )
    },
  },
}
</script>

<style lang="css">
.fuel-meter-box {
  width: 100%;
  padding: 20px 0;
  position: relative;
}
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
