<template>
  <tr class="car-item" @click="showDetails">
    <td>{{index}}</td>
    <td>{{car.reg_no}}</td>
    <td>{{car.com_id}}</td>
    <td>{{car.phone}}</td>
    <td>{{car.last_pulse}}</td>
  </tr>
</template>
<script>
export default {
  props: ['car', 'index'],
  data: () => ({

  }),
  methods: {
    showDetails() {
      window.location.href = this.car.target;
    }
  }
}
</script>
<style lang="css" scoped>
.car-item {
  cursor: pointer;
}
.car-item:hover {
  background: #EEEEEE;
  color: #3F51B5;
}
</style>
