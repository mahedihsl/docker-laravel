<template>
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="promotiontitle">
      <h3>SMS</h3>
    </div>
    <div class="form-group">
       <div>
           <textarea v-model="messagebody" name="user-message" id="user-message" class="form-control" cols="70" rows="4" placeholder="Enter your Message"></textarea>
       </div><!--end col 10-->
     </div><!--ends from group-->

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sendbuttondiv">
      <button @click="onSendClick" class="btn btn-success sendbutton" type="submit">Send SMS</button>
      <button @click="onSchemeClick" class="btn btn-default sendbutton" type="submit">Select Scheme</button>
    </div>


    <modal name="info" :scrollable="true" height="auto">
      <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12 modal-title">
        <h3>Schemes <span @click="closeModal"><i class="close fa fa-times pull-right" aria-hidden="true"></i></span></h3>
      </div>
      <div class="col-xs-12 modal-content">
        <div class="info-box bg-green scheme-list" @click="onSchemeSelect(scheme)" v-for="scheme in promoSchemeList" :key="scheme.key">
            <span class="info-box-icon"><i class="fa fa-tag" aria-hidden="true"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{scheme.name}}</span>
              <span class="info-box-number">
                {{scheme.free_month}} months free
                <span class="pull-right">{{scheme.discount}} taka discount</span>
              </span>


              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
                  <span class="progress-description">
                    valid till: <b>{{scheme.valid_till}}</b>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
      </div>
    </modal>
  </div>

</template>

<script>
import EventBus from '../../../../util/EventBus';
import PromotionApi from '../../../../api/PromotionApi';

export default {
  props:['customer'],
  name: "",
  data: () => ({
    messagebody:'',
    promoCode:'',
    promoSchemeList:[],
    selectedScheme: '',
  }),
  mounted(){
      EventBus.$on('message-sent',this.messageSent.bind(this));
      EventBus.$on('scheme-list-found',this.onPromoSchemeListFound.bind(this));
  },
  methods:{
    onSendClick()
    {
      let api = new PromotionApi(EventBus);
      api.message({id:this.customer.id, phone:this.customer.phone, message:this.messagebody}).then(response=>{
        EventBus.$emit('message-sent', response.body);
        api.savePromo({user_id:this.customer.id, promo_scheme_id:this.selectedScheme._id, code:this.promoCode});

      },error => {toastr.error('message not sent')});;
    },
    closeModal()
    {
      this.$modal.hide('info');
    },
    onSchemeClick()
    {
      let api = new PromotionApi(EventBus);
      api.promoSchemeList();
    },
    onPromoSchemeListFound(data)
    {
      this.promoSchemeList = data;
      this.$modal.show('info');
    },
    generateMessage()
    {
      this.messagebody = 'Dear Customer,\nRefer someone code: '+this.promoCode;
      this.messagebody+=' to get '+this.selectedScheme.free_month+' month of free service';
      this.messagebody+=' and help them get '+this.selectedScheme.discount+' taka discount on installation';
      this.messagebody+=' before '+this.selectedScheme.valid_till+'.\n\nCall: 01907888907';
    },
    onSchemeSelect(scheme){
      this.selectedScheme = scheme;

      let api = new PromotionApi(EventBus);
      api.generatePromoCode().then(data=>{
        this.promoCode = data.code;
        this.generateMessage();
        this.closeModal();
      },error => {});

    },
    messageSent(data){
      //todo
      //checkdata
      toastr.success('Message successfully sent');
      this.messagebody = '';
    }
  },
}
</script>
<style lang="scss" scoped>

.sendbuttondiv{
  border-bottom: 1px solid #E0E0E0;
}
.sendbutton{
  margin-left: 4px;
  margin-right: 4px;
}
.close{
  cursor:pointer;
}
.title{
  padding-top:0.5%;
  padding-bottom: 0.5%;
}
.form-control{
  resize: none;
}
.scheme-list{
  cursor: pointer;
}

.scheme-list:hover{
  box-shadow: 0 8px 32px 0 rgba(0,180,85,0.7);
}

.modal-title{
  color: #ffffff;
  background-color: #00B45B;
  margin-bottom: 14px;
}
</style>
