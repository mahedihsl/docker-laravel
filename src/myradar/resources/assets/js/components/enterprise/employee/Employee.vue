<template>
  <tr :class="{clickable: assignable, focused}" @click="onSelect">
    <td>{{serial}}</td>
    <td>{{employee.name}}</td>
    <td>{{employee.phone}}</td>
    <td>{{'N/A'}}</td>
    <td>
      <button class="btn btn-default btn-sm" v-if="!assignable" @click="onUpdateClick">
        <i class="fa fa-cog"></i> Update
      </button>
      <button class="btn btn-danger btn-sm" @click="onDeleteClick" v-if="!assignable">
        <i class="fa fa-trash" v-if="!loading"></i>
        <i class="fa fa-refresh fa-spin" v-if="loading"></i> Delete
      </button>
    </td>
  </tr>
</template>
<script>
import EventBus from '../../../util/EventBus';
import {mapGetters} from 'vuex';

export default {
  props: ['serial', 'employee', 'assignable'],
  data: () => ({
    focused: false,
  }),
  computed: {
    ...mapGetters(['loading', 'selected']),
  },
  mounted() {
    if (this.assignable) {
      EventBus.$on('employee-focused', () => this.focused = this.selected === this.employee.id);
    }
  },
  methods: {
    onUpdateClick() {
      EventBus.$emit('edit-employee-click', this.employee);
    },

    onDeleteClick() {
      const instance = this;
      $.confirm({
        title: 'Are You Sure ?',
        content: this.employee.name + ' will be deleted',
        type: 'red',
        theme: 'material',
        buttons: {
          confirm: {
            btnClass: 'btn-red',
            text: 'Yes, Delete',
            action: function () {
              instance.$store.dispatch('deleteEmployee', instance.employee.id);
            },
          },
          cancel: function () {

          }
        }
      });
    },

    onSelect() {
      EventBus.$emit('employee-selected', this.employee);
    }
  }
}
</script>
<style lang="scss" scoped>
tr{

}
tr:hover{
  font-weight: bold;
  border-left: 4px solid #3c8dbc;
  color: #3c8dbc;
  background: #3c8dbc;
}
</style>
