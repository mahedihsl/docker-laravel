<template>
    <tr>
        <td>{{device.com_id}}</td>
        <td>{{device.phone}}</td>
        <td>{{device.imei}}</td>
        <td>{{device.version}}</td>
        <td>{{device.time}}</td>
        <td>
          <input type="text" class="form-control" placeholder="version" v-model="version" required>
        </td>
        <td>
          <button type="submit" class="btn btn-primary btn-small" name="button" @click="onSaveClick">
            save
          </button>
        </td>
    </tr>
</template>
<script>
import EventBus from '../../util/EventBus';
import Api from '../../api/DeviceApi';
export default {
    props: ['device'],
    data: () => ({
      version:'',
    }),
    mounted() {
      //do something after mounting vue instance
      EventBus.$on('device-version-updated',this.onVersionUpdate.bind(this));
    },
    methods: {
      onSaveClick() {
        if(this.version == ''){
          toastr.error('Please enter version first!');
          return ;
        }
        let api = new Api(EventBus);
        api.updateVersion(this.device.com_id, this.version);
      },
      onVersionUpdate(){
        toastr.success('verison updated successfully!');
      }
    }
}
</script>
<style lang="scss" scoped>
</style>
