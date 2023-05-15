<template>
  <div class="row">
    <div class="row header">
      <div class="col-md-12">
        <h4 class="text-center text-primary">Settings of Car: {{vehicle.reg_no}}</h4>
        <hr>
      </div>
      <speed-limit :vehicle="vehicle"></speed-limit>
    </div>
  </div>
</template>
<script>
import SpeedLimit from './SpeedLimit.vue';

export default {
  props: ['vehicle'],
  components: {
    SpeedLimit,
  },
  data: () => ({

  })
}
</script>
<style lang="scss" scoped>
</style>
