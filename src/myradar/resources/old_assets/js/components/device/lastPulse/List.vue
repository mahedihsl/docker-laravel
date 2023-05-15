<template>
  <div class="">
    <div class="btn-group" role="group" aria-label="...">
      <button type="button" class="btn btn-success btn-sm" @click="load('good')">Good ({{count.good}})</button>
      <button type="button" class="btn btn-warning btn-sm" @click="load('bad')">Bad ({{count.bad}})</button>
      <button type="button" class="btn btn-danger btn-sm" @click="load('worst')">Worst ({{count.worst}})</button>
    </div>
    <hr>
    <h3><strong>{{title}}</strong> <span v-show="!!title">Last Pulse List</span></h3>
    <spinner :extra-height="true" v-show="loading"></spinner>
    <table class="table table-striped" v-show="!!title && !loading">
      <thead>
        <tr>
          <th class="col-md-1">#</th>
          <th class="col-md-1">Com. ID</th>
          <th class="col-md-2">Phone</th>
          <th class="col-md-1">Version</th>
          <th class="col-md-2">Last Pulse</th>
          <th class="col-md-1">Complain</th>
          <th class="col-md-4 text-center">Reset Calls</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(l, i) in list">
          <td>{{i + 1}}</td>
          <td class="clickable" @click="navigate(i)">
						<strong>{{l.com_id}}</strong>
					</td>
          <td>{{l.phone}}</td>
          <td>{{l.version}}</td>
          <td>{{l.last_pulse}}</td>
          <td>{{l.complain}}</td>
					<td>
						<div class="col-md-6">
							<p class="text-center counter" @click="resetCall(l.id, 1)">
								{{l.reset_calls}}
								<i class="fa fa-caret-up" v-if="l.call_flag != 2"></i>
								<i class="fa fa-check-circle" style="color: #4caf50" v-if="l.call_flag == 2"></i>
								<br>
								<small style="font-size: 10px; color: #9e9e9e;">Calls</small>
							</p>
						</div>
						<div class="col-md-6">
							<p class="text-center counter" @click="resetCall(l.id, 0)">
								{{l.reset_attempts}}
								<i class="fa fa-caret-up" v-if="l.call_flag == 0"></i>
								<i class="fa fa-check-circle" style="color: #4caf50" v-if="l.call_flag == 1 || l.call_flag == 2"></i>
								<br>
								<small style="font-size: 10px; color: #9e9e9e;">Attempt</small>
							</p>
						</div>
					</td>
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
    EventBus.$on('reset-call-made', this.onResetCallUpdate.bind(this));
  },
  methods: {
    ...mapMutations(['setLoading']),
    load(tag) {
      this.title = tag;
      this.$store.dispatch('getList', tag);
    },
    onListFound(list, tag) {
      if (tag == this.tag) {
				for (let i = 0; i < list.length; i++) {
					list[i].call_flag = 0;
				}
        this.list = list;
        this.setLoading(false);
      }
    },
		onResetCallUpdate(id, data) {
			for (var i = 0; i < this.list.length; i++) {
				if (this.list[i].id == id) {
					this.list[i].reset_calls = data.reset_calls;
					this.list[i].reset_attempts = data.reset_attempts;
					this.list[i].call_flag = data.ring == 1 ? 2 : 1;
					break;
				}
			}
		},
    navigate(i) {
      window.location.href = this.list[i].target;
    },
		resetCall(id, ring) {
			this.$store.dispatch('updateResetCall', {id, ring});
		}
  }
}
</script>
<style lang="scss" scoped>
.counter {
	cursor: pointer;
	padding: 6px 10px;
	font-size: 15px;
	font-weight: bold;
	color: #424242;
	background: white;
	border-radius: 4px;
	line-height: 1em;
	-webkit-box-shadow: 0px 5px 10px 0px rgba(0,0,0,0.1);
	-moz-box-shadow: 0px 5px 10px 0px rgba(0,0,0,0.1);
	box-shadow: 0px 5px 10px 0px rgba(0,0,0,0.1);
}
.counter:hover {
	background: #f5f5f5;
}
</style>
