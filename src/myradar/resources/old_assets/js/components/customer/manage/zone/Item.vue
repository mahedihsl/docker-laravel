<template>
  <tr>
    <td>{{serial}}</td>
    <td>{{zone.name}}</td>
    <td><strong>{{zone.lat}}</strong></td>
    <td><strong>{{zone.lng}}</strong></td>
    <td>{{zone.radius}}</td>
    <td>
      <button class="btn btn-danger btn-sm" @click="onDelete">
        <i class="fa fa-trash"></i> Delete
      </button>
    </td>
  </tr>
</template>
<script>
import {mapActions} from 'vuex';

export default {
  props: ['serial', 'zone'],
  data: () => ({

  }),
  methods: {
    ...mapActions('zone', {
      remove: 'delete',
    }),
    onDelete() {
      const instance = this;
      $.confirm({
        title: 'Are You Sure ?',
        content: 'This zone will be deleted',
        type: 'red',
        theme: 'material',
        buttons: {
          confirm: {
            btnClass: 'btn-red',
            text: 'Yes, Delete',
            action: function () {
              instance.remove(instance.zone.id);
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
</style>
