<template>
  <div class="col-xs-12 col-md-10 col-md-offset-1">
    <h4 class="ash-header">{{title}}</h4>
    <div class="row">
      <component :is="current" :customer="customer"></component>
      <!-- <profile-view :customer="customer" v-if="!editMode"></profile-view>
      <profile-edit :customer="customer" v-if="editMode"></profile-edit> -->
    </div>
    <div class="row" v-show="viewMode">
      <div class="col-xs-12 col-md-5 card-2" style="padding-right: 0">
        <div class="col-xs-8" style="height: 80px;">
          <div style="padding-top: 18px;">
            <span :class="{'text-success': enabled, 'text-danger': !enabled}">
              <strong>Account {{enabled ? 'Enabled' : 'Disabled'}}</strong>
            </span>
            <br/>
            <a href="#" class="btn btn-link" @click="onToggleHistoryClick">History</a>
          </div>
        </div>
        <div class="col-xs-4" style="padding-right: 0">
          <div style="height: 80px;">
            <span @click="toggleEnabled" class="icon-box pull-right" :class="{'box-success': !enabled, 'box-danger': enabled}">
              <i class="fa fa-power-off fa-3x"></i>
            </span>
          </div>
        </div>
      </div>

      <div class="col-xs-12 col-md-5 col-md-offset-2 card-2" style="padding-right: 0">
        <div class="col-xs-8" style="height: 80px;">
          <div style="text-align: center; padding-top: 18px;">
            <span class="text-primary">
              <strong>Change Password</strong>
            </span>
          </div>
        </div>
        <div class="col-xs-4" style="padding-right: 0">
          <div style="height: 80px;">
            <span @click="onPasswordEditClick" class="icon-box box-info pull-right">
              <i class="fa fa-pencil fa-3x"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import EventBus from '../../../../util/EventBus';
import AccountApi from '../../../../api/AccountApi';

import ProfileView from './ProfileView.vue';
import SessionList from './SessionList.vue';
import ProfileEdit from './ProfileEdit.vue';
import PasswordChange from './PasswordChange.vue';
import ToggleHistory from './ToggleHistory.vue';

export default {
  props: ['customer'],
  components: {
    ProfileView,
    ProfileEdit,
    PasswordChange,
    ToggleHistory,
    SessionList,
  },
  data: () => ({
    title: '',
    profile: null,
    enabled: null,
    current: ProfileView,
  }),
  computed: {
    viewMode() {
      return this.current == ProfileView;
    }
  },
  mounted() {
    EventBus.$on('account-info-found', this.onInfoFound.bind(this));
    EventBus.$on('account-info-updated', this.onInfoUpdated.bind(this));
    EventBus.$on('session-list-click', this.onSessionListClick.bind(this));
    EventBus.$on('profile-edit-click', this.onProfileEditClick.bind(this));
    EventBus.$on('profile-edit-done', this.onProfileEditDone.bind(this));
    EventBus.$on('toggle-history-closed', this.onProfileEditDone.bind(this));

    let api = new AccountApi(EventBus);
    api.info(this.customer.id);

    this.title = 'Account Information';
  },
  methods: {
    onInfoFound(data) {
      this.enabled = data.enabled;
    },

    onInfoUpdated(response) {
      if (response.status == 1) {
        this.onInfoFound(response.data);
        toastr.success('Updated successfully');
      } else {
        toastr.error(response.data.message)
      }

    },

    onToggleHistoryClick() {
      this.current = ToggleHistory;
      this.title = 'Account Enable/Disable History';
    },

    onSessionListClick() {
      this.current = SessionList
      this.title = 'Phone List'
    },

    onProfileEditClick() {
      this.current = ProfileEdit;
      this.title = 'Update Information';
    },

    onPasswordEditClick() {
      this.current = PasswordChange;
      this.title = 'Change Password';
    },

    onProfileEditDone(profile) {
      this.current = ProfileView;
      this.title = 'Account Information';
    },

    toggleEnabled() {
      const instance = this;
      let message = '';
      if (this.enabled) {
        message = 'This account will be deactivated';
      } else {
        message = 'This account will be active again';
      }

      $.confirm({
        title: 'Are You Sure ?',
        content: message,
        type: 'red',
        theme: 'material',
        buttons: {
          confirm: {
            btnClass: 'btn-green',
            action: function () {
              let api = new AccountApi(EventBus);
              api.toggleEnabled(instance.customer.id);
            },
          },
          cancel: function () {

          }
        }
      });
    }
  }
}
</script>
<style lang="scss" scoped>
.icon-box {
  color: white;
  height: 80px;
  width: 100%;
  padding: 10px 0;
  text-align: center;
  cursor: pointer;
}
.box-success {
  background: #4CAF50;
}
.box-danger {
  background: #F44336;
}
.box-info {
  background: #03A9F4;
}
</style>
