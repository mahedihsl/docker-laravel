<template>
  <div class="row">
    <div class="col-xs-12" :class="{'no-item': extraHeight}">
      <h3 class="text-center warning-header">
        <i class="fa fa-ban fa-3x"></i><br>
        {{body}}
      </h3>
    </div>
  </div>
</template>
<script>
export default {
  props: ['body', 'extraHeight'],
  data: () => ({

  })
}
</script>
<style lang="css" scoped>
.warning-header {
  font-weight: normal;
  font-size: 20px;
  color: #EF5350;
}
</style>
