<template lang="html">
  <table>
      <thead class="table table-responsive table-striped">
          <tr>
              <th class="col-md-4">Name</th>
              <th class="col-md-3">Type</th>
              <th class="col-md-3">Action</th>
          </tr>
      </thead>
      <tbody>
          <p-service v-bind:item="item" v-for="(item, i) in services" :key="i"></p-service>
      </tbody>
  </table>
</template>

<script>
import ServiceItem from './ServiceItem.vue';

export default {
    components: {
        'p-service': ServiceItem,
    },

    data: function() {
        return {
            services: [],
        }
    },

    mounted: function() {
        this.getServices();
    },

    methods: {
        getServices() {
            this.$http.get('/services/all').then(response => {
                this.services = response.data.data;
            }, error => {});
        }
    }
}
</script>

<style lang="css">
</style>
