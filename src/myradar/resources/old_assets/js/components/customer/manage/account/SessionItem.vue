<template>
  <li class="session-item">
    <div class="phone-icon">
      <img src="/images/ic-smartphone.png" alt="" />
    </div>
    <div class="session-content">
      <h3 class="heading">{{ phoneName }}</h3>
      <span class="subtitle">
        {{ phoneVersion }}
        <i class="fa fa-circle dot-divider"></i>
        {{ lastSeen }}
      </span>
    </div>
    <div class="session-control">
      <!-- <button
        class="btn btn-default btn-sm"
        @click="$emit('remove', session.id)"
      >
        <i class="fa fa-trash"></i> Delete
      </button> -->
      <button
        class="btn btn-default btn-sm"
        style="margin-left: 10px;"
        @click="$emit('logout', session.id)"
      >
        <i class="fa fa-ban"></i> Logout
      </button>
    </div>
  </li>
</template>

<script>
export default {
  props: ['session'],
  computed: {
    hasMetaInfo() {
      // Check if at least one meta propertiey present
      return !!this.session.phone_manufacturer
    },

    phoneName() {
      if (!this.hasMetaInfo) return '--'
      return this.session.phone_manufacturer + ' ' + this.session.phone_model
    },
    phoneVersion() {
      if (!this.hasMetaInfo) return '--'
      return 'Android ' + this.session.android_version_name
    },
    lastSeen() {
      if (!this.hasMetaInfo) return '--'
      return this.session.last_active
    },
  },
}
</script>

<style scoped>
.session-item {
  display: flex;
  flex-direction: row;
  align-items: center;
  padding: 10px 15px;
  transition: all 0.2s ease-in;
}
.session-item:hover {
  background-color: #f7f7f7;
}
.session-content {
  padding-left: 15px;
  flex-grow: 1;
}
.session-control {
  flex-shrink: 0;
  display: flex;
  flex-direction: row;
  align-items: center;
}
.phone-icon {
  flex-shrink: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #f5f5f5;
  border-radius: 99px;
  width: 48px;
  height: 48px;
}
.phone-icon > img {
  width: 36px;
  height: 36px;
}
.heading {
  font-size: 14px;
  font-weight: 600;
  color: #424242;
  margin: 0 2px;
}
.subtitle {
  font-size: 12px;
  font-weight: 400;
  color: #212121;
}
.dot-divider {
  color: #bdbdbd;
  margin: 0 8px;
  font-size: 8px;
}
</style>
