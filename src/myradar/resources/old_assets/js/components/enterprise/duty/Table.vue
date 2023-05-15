<template>
  <div class="col-xs-12 table-responsive">
    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10" style="margin-bottom:2%">
      <div class="form-inline">
        <div class="form-group">
          <input type="text" class="form-control" v-model="search" placeholder="Type Reg No./Driver">
        </div>
        <div class="form-group">
          <select class="form-control" v-model="selected">
            <option :value="v" v-for="v in times">{{v.l}}</option>
          </select>
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" style="margin-bottom:2%">
      <a class="btn btn-primary pull-right" :href="'/duty/hour/export?user_id='+userId+'&month='+(this.selected.m+1)+'&year='+this.selected.y"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export</a>
    </div>
    <spinner :extra-height="true" v-if="loading"></spinner>
    <table class="table table-striped table-hover" v-show="filteredList.length">
      <thead class="colored-header">
        <tr>
          <th class="col-sm-1">#</th>
          <th class="col-sm-2">Reg No.</th>
          <th class="col-sm-2">Driver</th>
          <th class="col-sm-3">Phone No.</th>
          <th class=" col-sm-2 clickable" @click="setTimeSort">
            Duration <i class="fa" :class="timeSortIcon"></i>
          </th>
          <th class="col-sm-2">Month</th>
        </tr>
      </thead>
      <tbody>
        <item v-for="(v, i) in filteredList" :car="v" :key="i" :serial="i + 1"></item>
      </tbody>
    </table>
  </div>
</template>
<script>
import moment from 'moment';
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';
import {mapMutations} from 'vuex';

import EventBus from '../../../util/EventBus';

import Item from './Item.vue';
import Spinner from '../../util/Spinner.vue';

export default {
  props: ['compare', 'value'],
  components: {
    Item, Spinner,
  },
  data: () => ({
    search: '',
    times: [],
    selected: null,
    userId: null,
  }),
  beforeMount() {
    this.times[0] = {
      m: moment().month(),
      y: moment().year(),
      l: moment().format('MMMM YYYY'),
    };

    for (var i = 1; i < 6; i++) {
      let temp = moment().subtract(i, 'months');
      this.times.push({
        m: temp.month(),
        y: temp.year(),
        l: temp.format('MMMM YYYY'),
      });

      this.selected = this.times[0];
      this.setTime(this.selected);
    }
    this.userId = $('input[name="user_id"]').val();
  },
  mounted() {
    setTimeout(() => {
      if (!this.filteredList.length) this.getCars();
    }, 300);
  },
  watch: {
    selected: function(nVal, oVal) {
      this.setTime(nVal);
      EventBus.$emit('month-filter-changed');
    }
  },
  computed: {
    ...mapGetters('duty', ['cars', 'timeSort', 'loading','time']),
    filteredList() {
      return this.cars(this.search, this.compare, this.value);
    },
    timeSortIcon() {
      return ['fa-sort-desc', 'fa-sort', 'fa-sort-asc'][this.timeSort + 1];
    }
  },
  methods: {
    ...mapMutations('duty', ['setTimeSort', 'setTime']),
    ...mapActions('duty', ['getCars']),
  }
}
</script>
<style lang="scss" scoped>
.clickable {
  cursor: pointer;
}
th {
  text-align: center;
}
</style>
