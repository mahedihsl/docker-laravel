<template>
  <div>
    <search :onSubmit="onSearch" :content="search"></search>
    <no-item v-show="noItem"></no-item>
    <table class="table table-striped customer-table" v-show="!noItem">
      <thead>
        <tr>
          <th>#</th>
          <th>Reg No.</th>
          <th>Com. ID</th>
          <th>Phone No.</th>
          <th>Last Pulse</th>
        </tr>
      </thead>
      <tbody>
        <car v-for="(car, i) in cars"
            :car="car"
            :index="getSerialNo(i)"
            :key="i">
        </car>
      </tbody>
    </table>
    <pagination v-bind:pagination="pagination"
                v-on:click.native="onPageChanged(pagination.current_page)"
                :offset="offset"
                v-show="!noItem">
    </pagination>
  </div>
</template>
<script>
import Search from './CarSearch.vue';
import Car from './CarItem.vue';
import Pagination from '../util/Pagination.vue';
import NoItem from '../util/NoItemFound.vue';

import CarApi from '../../api/CarApi';
import EventBus from '../../util/EventBus';

export default {
  components: {
      Search,
      Car,
      Pagination,
      NoItem,
  },
  data: () => ({
    api: new CarApi(EventBus),
    cars: [],
    search: {
        reg: '',
        com: '',
        phone: '',
    },
    pagination: {
        total: 0,
        per_page: 15,
        total_pages: 0,
        current_page: 1,
    },
    offset: 4,
    noItem: false,
  }),
  mounted() {
    EventBus.$on('car-list-found', this.onListFound.bind(this));

    this.onPageChanged(1);
  },
  methods: {
    getSerialNo(i) {
      return (this.pagination.current_page - 1) * this.pagination.per_page + 1 + i;
    },

    onListFound(list, pagination) {
      this.cars = list;
      this.pagination = pagination;
      this.noItem = !list.length;
    },

    onSearch(reg, com, phone) {
      this.search = {reg, com, phone};
      this.api.search(1, reg, com, phone);
    },

    onPageChanged(n) {
      this.api.search(n, this.search.reg, this.search.com, this.search.phone);
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
