<template>
  <tr class="promo-item">
    <td>{{index}}</td>
    <td>{{promo.code}}</td>
    <td>{{promo.user.name}}</td>
    <td><span class="number badge bg-red">{{promo.applied ? promo.applied.length : 0}}</span></td>
  </tr>
</template>
<script>
export default {
  name: "",
  props: ['promo', 'index'],
  data: () => ({

  })
}
</script>
<style lang="scss" scoped>
.number{
  font-size: 15px;
}
</style>
