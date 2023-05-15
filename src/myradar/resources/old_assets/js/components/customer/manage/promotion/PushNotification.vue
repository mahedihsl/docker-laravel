<template>
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="promotiontitle">
      <h3>Notification</h3>
    </div>
    <div class="form-group shadow-textarea">
        <textarea v-model="noti.title" class="form-control z-depth-1" id="notititle" rows="1" placeholder="Enter title here"></textarea>
    </div>
    <div class="form-group shadow-textarea">
        <textarea v-model="noti.body" class="form-control z-depth-1" id="notibody" rows="4" placeholder="Write something here..."></textarea>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sendbuttondiv">
      <button @click="onSendClick" class="btn btn-success sendbutton">Send Notification</button>
    </div>
  </div>
</template>
<script>
import EventBus from '../../../../util/EventBus';
import PromotionApi from '../../../../api/PromotionApi';

export default {
  props:['customer'],
  name: "",
  data: () => ({
    noti:{
      title:'',
      body:''
    }
  }),
  mounted() {
    EventBus.$on('notification-sent',this.notificationSent.bind(this));
  },
  methods:{
    onSendClick()
    {
      let api = new PromotionApi(EventBus);
      api.notification(this.customer.id, this.noti.title, this.noti.body);
    },

    notificationSent(data){
      //todo
      //check data
      if(data)
      {
        toastr.success('Notifacation successfully sent');
      }
      else {
        toastr.warning('Something went wrong');
      }
    }
  }
}
</script>
<style lang="scss" scoped>
.form-control{
  resize: none;
}
</style>
