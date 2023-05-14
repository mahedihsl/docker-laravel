<template>
  <tr>
    <td>{{serial}}</td>
    <td>{{driver.name}}</td>
    <td>{{driver.car}}</td>
    <td>
      <button class="btn btn-default btn-sm" @click="onAssignClick">
      <i class="fa fa-check"></i></button> Assign
    </td>
  </tr>
</template>
<script>
export default {
  data: () => ({

  })
}
</script>
<style lang="scss" scoped>
</style>
