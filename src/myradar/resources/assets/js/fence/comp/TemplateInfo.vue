<template>
  <div class="info-panel">
    <div class="info-header">
      <h4>Template Details</h4>
    </div>
    <span class="close-round" @click="$emit('close')">
      <i class="fa fa-times"></i>
    </span>
    <div class="info-title">
      <h4>{{ geofence.name }}</h4>
      <span>
        <i class="fa fa-calendar mr-2"></i>
        Created On {{ geofence.created_at }}
      </span>
    </div>
    <div class="info-actions">
      <button class="btn btn-info" @click="attach">
        <i class="fa fa-add"></i>Add to my list
      </button>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  props: {
    geofence: {
      type: Object,
      required: false,
      default: null,
    },
  },
  methods: {
    attach() {
      this.$emit('attach', this.geofence)
    }
  },
}
</script>

<style scoped>
.info-panel {
  position: absolute;
  width: 30%;
  height: 100%;
  right: 0;
  top: 0;
  background: white;
  overflow: scroll;

  -webkit-box-shadow: -15px 0px 20px -10px rgba(176, 176, 176, 1);
  -moz-box-shadow: -15px 0px 20px -10px rgba(176, 176, 176, 1);
  box-shadow: -15px 0px 20px -10px rgba(176, 176, 176, 1);
}

.info-header {
  position: relative;
  border-bottom: 1px solid #eeeeee;
  padding: 15px;
}

.info-header h4 {
  margin: 5px 0;
  font-size: 1.5rem;
  color: #616161;
}

.info-title {
  padding: 10px 20px;
}
.info-title > h4 {
  font-size: 1.65rem;
  color: #212121;
  margin: 5px 0;
}
.info-title > span {
  color: #757575;
  font-size: 1.25rem;
}

.info-actions {
  padding: 15px 0;
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  align-items: stretch;
}

.close-round {
  position: absolute;
  top: 15px;
  right: 15px;

  font-size: 1.15rem;
  color: #424242;
  background: #f5f5f5;
  transition: all 0.2s ease-in;

  border-radius: 50px;
  width: 30px;
  height: 30px;

  cursor: pointer;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.close-round:hover {
  background: #e0e0e0;
}

.car-list-title {
  padding: 0 15px;
  font-size: 1.35rem;
  font-weight: 600;
  color: #212121;
}
</style>
