<template lang="html">
  <div class="col-xs-12 col-md-8 col-md-offset-2">
    <div class="form">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Full name" v-model="info.name">
            <span class="helper-text text-danger">{{error.name}}</span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Phone <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Contact Number" v-model="info.phone">
            <span class="helper-text text-danger">{{error.phone}}</span>
          </div>
        </div>
      </div>
			<div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Address <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Address" v-model="info.address">
            <span class="helper-text text-danger">{{error.address}}</span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Email <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="abcd@example.com" v-model="info.email">
            <span class="helper-text text-danger">{{error.email}}</span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Customer Type <span class="text-danger">*</span></label>
            <select class="form-control" v-model="info.ctype">
              <option value="1">Private Customer</option>
              <option value="2">Enterprise Customer</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" placeholder="Min. 6 character long" v-model="info.password">
            <span class="helper-text text-danger">{{error.password}}</span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Confirm Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" placeholder="Type password again" v-model="info.password_confirmation">
          </div>
        </div>
      </div>
			<div class="alert alert-warning" v-if="hasError" role="alert">
				<h3>Oops, Error !</h3>
				<ul>
					<li v-for="(v, i) in error">{{v}}</li>
				</ul>
			</div>
      <div class="col-md-4 col-md-offset-4">
        <button class="btn btn-success btn-block" v-on:click="save">Save</button>
      </div>
      <spinner extraHeight="true" floating="true" v-if="loader.create"></spinner>
    </div>
  </div>
</template>

<script>
import Spinner from '../util/Spinner';

import {mapGetters} from 'vuex';
import EventBus from '../../util/EventBus';

export default {
  components: {Spinner},
  data: () => ({
    info: {
      name: '',
      phone: '',
      ctype: '1',
      email: '',
			address: '',
      password: '',
      password_confirmation: '',
    }
  }),
  computed: {
    ...mapGetters({
      loader: 'loader',
      error: 'error',
    }),
		hasError() {
			for (var key in this.error) {
				if (this.error.hasOwnProperty(key) && this.error[key]) {
					return true;
				}
			}
			return false;
		}
  },
  mounted() {
    EventBus.$on('customer-save-done', this.onSaveCompleted.bind(this));
  },
  methods: {
    save() {
      this.$store.dispatch('save', this.info);
    },

    onSaveCompleted(data) {
			this.error = null;
      $(location).attr('href', data.redirect);
    },
  },
}
</script>

<style lang="css">
</style>
