<template>
  <div class="">
    <div class="btn-group" role="group" aria-label="...">
      <button type="button" class="btn btn-success btn-sm" @click="load('good')">Good ({{count.good}})</button>
      <button type="button" class="btn btn-warning btn-sm" @click="load('bad')">Bad ({{count.bad}})</button>
      <button type="button" class="btn btn-danger btn-sm" @click="load('worst')">Worst ({{count.worst}})</button>
    </div>
    <hr>
    <h3><strong>{{title}}</strong> <span v-show="!!title">Health Device List</span></h3>
    <spinner :extra-height="true" v-show="loading"></spinner>
    <table class="table table-striped" v-show="!!title && !loading">
      <thead>
        <tr>
          <th>#</th>
          <th>Com. ID</th>
          <th>Deviation</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(l, i) in list" class="clickable" @click="navigate(i)">
          <td>{{i + 1}}</td>
          <td>{{l.com_id}}</td>
          <td>{{l.deviation}} %</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import {mapGetters} from 'vuex';
import {mapMutations} from 'vuex';

import EventBus from '../../../util/EventBus';

import Spinner from '../../util/Spinner.vue';

export default {
  components: {
    Spinner,
  },
  data: () => ({
    title: '',
    list: [],
  }),
  computed: {
    ...mapGetters(['stats', 'tag', 'loading']),
    count() {
      return {
        good: this.stats ? this.stats.good : '--',
        bad: this.stats ? this.stats.bad : '--',
        worst: this.stats ? this.stats.worst : '--',
      }
    }
  },
  mounted() {
    EventBus.$on('perf-list-found', this.onListFound.bind(this));
  },
  methods: {
    ...mapMutations(['setLoading']),
    load(tag) {
      this.title = tag;
      this.$store.dispatch('getList', tag);
    },
    onListFound(list, tag) {
      if (tag == this.tag) {
        this.list = list;
        this.setLoading(false);
      }
    },
    navigate(i) {
      window.location.href = this.list[i].target;
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
