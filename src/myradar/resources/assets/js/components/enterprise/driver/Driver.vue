<template>
  <tr >
    <td>
      <div class="status" :class="{booked: driver.booked, free: !driver.booked}" :title="status"></div>
      <div style="float: left">{{serial}}</div>
    </td>
    <td>{{driver.name}}</td>
    <td>{{driver.phone}}</td>
    <td>{{driver.car ? driver.car.name : 'N/A'}}</td>
    <td>
      <button class="btn btn-default btn-sm" @click="onAssignClick">
        <i class="fa fa-link"></i> Assign
      </button>
      <button class="btn btn-default btn-sm" @click="onUpdateClick">
        <i class="fa fa-cog"></i> Update
      </button>
      <button class="btn btn-danger btn-sm" @click="onDeleteClick">
        <i class="fa fa-trash" v-if="!loading"></i>
        <i class="fa fa-refresh fa-spin" v-if="loading"></i> Delete
      </button>
    </td>
  </tr>
</template>
<script>
import EventBus from '../../../util/EventBus';
import {mapGetters} from 'vuex';
import tippy from 'tippy.js';

export default {
  props: ['serial', 'driver'],
  data: () => ({

  }),
  computed: {
    ...mapGetters(['loading']),
    status() {
      return this.driver.booked ? 'BOOKED' : 'AVAILABLE';
    }
  },
  mounted() {
    tippy('.status');
  },
  methods: {
    onUpdateClick() {
      EventBus.$emit('edit-driver-click', this.driver);
    },

    onDeleteClick() {
      const instance = this;
      $.confirm({
        title: 'Are You Sure ?',
        content: this.driver.name + ' will be deleted',
        type: 'red',
        theme: 'material',
        buttons: {
          confirm: {
            btnClass: 'btn-red',
            text: 'Yes, Delete',
            action: function () {
              instance.$store.dispatch('deleteDriver', instance.driver.id);
            },
          },
          cancel: function () {

          }
        }
      });
    },

    onAssignClick() {
      EventBus.$emit('assign-driver-click', this.driver);
    }
  }
}
</script>
<style lang="scss" scoped>
.status {
  float: left;
  width: 16px;
  height: 16px;
  border-radius: 50%;
  margin-right: 6px;
  margin-top: 3px;
}
.booked {
  background-color: #f44336;
}
.free {
  background-color: #4caf50;
}
tr{

}
tr:hover{
  font-weight: bold;
  border-left: 4px solid #3c8dbc;
  color: #3c8dbc;
  background: #3c8dbc;
}
</style>
