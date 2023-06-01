<template>
  <div class="col-xs-12 col-md-2 user-sidebar nopadding">
    <fake-sidebar v-if="!info"></fake-sidebar>
    <div v-if="!!info && accessFound">
      <div class="col-md-12 sidebar-header">
        <img
          src="/img/user_avatar.png"
          alt=""
          class="img img-circle img-responsive profile-img"
        />
        <h5 class="text-center user-name">
          <span>{{ info.name || '' }}</span
          ><br />
          <span :class="type.style">{{ type.name }}</span>
        </h5>
      </div>
      <div class="col-md-12 nopadding">
        <ul class="manage-menu">
          <li
            v-for="(m, i) in items"
            :key="i"
            :class="{ active: current === m.id }"
            @click="onMenuClick(m.id)"
          >
            <span>{{ m.name }}</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
import FakeSidebar from './FakeSidebar'

import Url from '../../../util/Url'
import EventBus from '../../../util/EventBus'
import CustomerApi from '../../../api/CustomerApi'
import AccountApi from '../../../api/AccountApi'
import Store from "../../../store/modules/customer"

export default {
  components: {
    FakeSidebar,
  },
  data: () => ({
    current: -1,
    info: null,
    access: {},
    items: [
      { id: 'analytics', name: 'Analytics' },
      { id: 'account', name: 'Account' },
      { id: 'vehicles', name: 'Vehicles' },
      { id: 'payment', name: 'Payment' },
      { id: 'settings', name: 'Settings' },
      { id: 'promotion', name: 'Promotion' },
      { id: 'geofence', name: 'Geofence' },
      { id: 'complains', name: 'Complains' },
      { id: 'rms-manager', name: 'RMS Sites' },
    ],
  }),
  computed: {
    type() {
      let styles = ['success', 'primary', 'warning']
      let names = ['Private', 'Enterprise', 'Public']
      return {
        style: 'label label-' + styles[this.info.type - 1],
        name: names[this.info.type - 1],
      }
    },
    accessFound() {
      return Object.keys(this.access).length > 0
    },
  },
  mounted() {
    EventBus.$on('customer-info-found', this.onInfoFound.bind(this))
    EventBus.$on('customer-acces-found', this.onAccessFound.bind(this))
    EventBus.$on('profile-edit-done', this.onProfileEdited.bind(this))

    let userId = $('input[name="user_id"]').val()
    let api = new CustomerApi(EventBus)
    api.info(userId)

    let api2 = new AccountApi(EventBus)
    api2.myCustomerAccess()
  },
  methods: {
    onMenuClick(tag) {
      if (tag === 'complains') {
        window.location.href = `/complains?user_id=${this.info.id}`
      } else if (tag === 'geofence') {
        window.location.href = `/geofence/manage?user_id=${this.info.id}`
      } else if (this.access[tag]['status'] === true) {
        this.current = tag
        EventBus.$emit(
          'menu-clicked',
          this.current,
          this.info,
          this.access[tag]['meta']
        )
      } else {
        toastr.error('You dont have access to view this menu')
      }
    },

    onInfoFound(info) {
      console.log('customer info',this.$store.state.customer)
      this.info = info
      //this.$store.commit('customer', info)
      for (let k in this.info) {
                    console.log('key: ' + k);
                    if (this.info.hasOwnProperty(k)) {
                      console.log('value: '+this.info[k]);
                        this.$store.commit('updateCustomerInfo', {key: k, val: this.info[k]});
                    }
                }
      this.attemptAutoNavigate()
    },

    onProfileEdited(profile) {
      if (profile) {
        this.info = profile
        EventBus.$emit(
          'menu-clicked',
          this.current,
          this.info,
          this.access[this.current]['meta']
        )
      }
    },

    onAccessFound(data) {
      this.access = data
      this.attemptAutoNavigate()
    },

    attemptAutoNavigate() {
      if (!!this.info && this.accessFound) {
        let url = new Url()
        let tab = url.getParameterByName('tab')
        if (tab) {
          this.onMenuClick(tab)
          return true
        }
      }
      return false
    },
  },
}
</script>
<style lang="scss">
.user-name {
  font-weight: 600;
  font-size: 15px;
}
.profile-img {
  width: 70px;
  height: 70px;
  margin-left: auto;
  margin-right: auto;
  display: block;
}
.user-sidebar {
  background: rgb(240, 240, 240);
  padding-top: 20px;
  padding-bottom: 20px;
}
.sidebar-header {
  border-bottom: 1px solid #e0e0e0;
}
.manage-menu {
  margin: 0;
  width: 100%;
  padding: 10px 0 0 0;
}
.manage-menu > li {
  cursor: pointer;
  padding: 10px 10px;
  border-left: 2px solid rgb(240, 240, 240);
  list-style: none;
  transition: all 0.3s ease-out;
}
.manage-menu > li > span {
  color: #757575;
  font-weight: bold;
}
.manage-menu > li:hover,
.manage-menu > li.active {
  background: rgb(255, 255, 255);
  border-left: 2px solid rgb(84, 72, 236);
}
.manage-menu > li:hover > span,
.manage-menu > li.active > span {
  color: rgb(84, 72, 236);
}
</style>
