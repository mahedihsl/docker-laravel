<template>
  <div class="col-xs-12 col-md-6 col-md-offset-3">
    <h4>Assign car for {{employee.name}}</h4>
    <hr>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Driver</th>
          <th>Car</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>
  </div>
</template>
<script>
import Driver from './Driver.vue';

export default {
  props: ['employee'],
  data: () => ({

  })
}
</script>
<style lang="scss" scoped>
</style>
