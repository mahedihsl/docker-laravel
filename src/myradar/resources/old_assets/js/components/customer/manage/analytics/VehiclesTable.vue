<template>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="bottomcard card">
      <div class="vehiclestitle col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h4>Vehicles</h4>
      </div>
      <div class="card-content">
        <table class="table table-striped text-center">
          <thead>
            <tr class="row">
              <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">#</th>
              <th class="col-xs-4 col-sm-4 col-md-4 col-lg-4">Reg no</th>
              <th class="col-xs-6 col-sm-6 col-md-6 col-lg-6">package</th>
            </tr>
          </thead>
          <tbody>
            <tr class="row" style="cursor: pointer;" v-for="(car, i) in cars" :key="i" @click="onItemClick(car)">
              <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">{{ i + 1 }}</td>
              <td class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                {{ car.name }}
              </td>
              <td class="col-xs-4 col-sm-4 col-md-4 col-lg-4">pack</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  props: ['cars'],
  data: () => ({}),
  methods: {
    onItemClick(car) {
      this.$emit('click', car)
    },
  },
}
</script>

<style lang="scss" scoped>
</style>
