<template lang="html">
    <div>
        <search :onSubmit="onSearch" :content="search"></search>
        <no-item-found v-show="noItem"></no-item-found>
        <table class="table table-responsive customer-table" v-show="!noItem">
            <thead>
                <tr>
                    <th class="col-xs-1">#</th>
                    <th class="col-xs-7"><i class="fa fa-user"></i> Name</th>
                    <th class="col-xs-2"><i class="fa fa-user-circle"></i> Type</th>
                    <th class="col-xs-2"><i class="fa fa-car"></i> Cars</th>
                </tr>
            </thead>
            <tbody>
                <customer v-for="(user, i) in users"
                  :user="user"
                  :index="serial(i)"
                  :key="i">
                </customer>
            </tbody>
        </table>
        <pager v-on:click.native="onPageChanged(pagination.current_page)"
                :pagination="pagination"
                :offset="offset"
                v-show="!noItem">
        </pager>
        <spinner extraHeight="true" floating="true" v-if="loader.list"></spinner>
    </div>
</template>

<script>
import Search from './CustomerSearch.vue';
import Customer from './CustomerItem.vue';
import Pager from '../util/Pagination.vue';
import Spinner from '../util/Spinner.vue';
import NoItemFound from '../util/NoItemFound.vue';

import {mapGetters} from 'vuex';

export default {
  components: {
    Search,
    Customer,
    Pager,
    Spinner,
    NoItemFound,
  },
  data: function() {
    return {
      search: {
        name: '',
        phone: '',
      },
      counter: 0,
      offset: 4,
    }
  },
  computed: {
    ...mapGetters({
      users: 'customers',
      pagination: 'pagination',
      loader: 'loader',
      serial: 'serial',
    }),
    noItem() {
        return this.users.length == 0 && !this.loader.list;
    },
    start() {
      return 0;
    }
  },
  mounted() {
    this.getCustomers(1);
  },
  methods: {
    getCustomers(page) {
      this.$store.dispatch('fetch', {
        page, ...this.search,
      });
    },
    onPageChanged(page) {
      this.getCustomers(page);
    },
    onSearch(data) {
      this.search = data;
      this.getCustomers(1);
    },
    getUrlVars() {
      var vars = {};
      var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,
        function(m, key, value) {
          vars[key] = value;
        });
      return vars;
    }
  }
}
</script>

<style lang="css">
.customer-table {
    margin-top: 25px;
}
</style>
