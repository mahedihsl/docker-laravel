<template>
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <Sms :customer="customer"> </Sms>
    <push-notification :customer="customer"> </push-notification>
  </div>
</template>
<script>
import Sms from './Sms.vue';
import PushNotification from './PushNotification.vue';
import PromotionApi from '../../../../api/PromotionApi';


export default {
  props: ['customer'],
  data: () => ({

  }),
  components: {
    Sms,
    PushNotification
  },
  mounted(){

  },
  methods:{

  }
}
</script>
<style lang="scss" >
.sendbutton{
  float: right;
}
.promotiontitle{
  padding-top:1.5%;
  padding-bottom: 1.5%;
}
.sendbuttondiv{
  padding:0px;
  padding-bottom: 2%;

}
.promotiontitle h3{
  margin-bottom: 0px;
  margin:0px;
}
#textarea{
  width: 100%;
}
</style>
