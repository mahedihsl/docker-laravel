<template>
  <div class="promo-scheme">
    <div class="row">
      <h3 class="ash-divider col-md-3">
        {{title}}
      </h3>

      <button v-show="!current" class="btn btn-primary pull-right" @click="changeView(1)">
       <i class="fa fa-plus" aria-hidden="true"></i> New Scheme
      </button>

      <button v-show="current" class="btn btn-default pull-right" @click="changeView(0)">
        <i class="fa fa-arrow-left"></i> Back
      </button>

      <button v-show="!current" class="btn btn-default status pull-right" @click="changeView(2)">
        <i class="fa fa-eye" aria-hidden="true"></i> Status
      </button>

      <button v-show="!current" class="btn btn-warning pull-right" @click="onSendPromoClick()">
        <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Send Promo
      </button>

    </div>

    <component :is="currentView" ></component>

    <modal name="info" :scrollable="true" height="auto">
      <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12 modal-title">
        <h3>Schemes <span @click="closeModal('info')"><i class="close fa fa-times pull-right" aria-hidden="true"></i></span></h3>
      </div>
      <div class="col-xs-12 modal-content">
        <div class="info-box bg-yellow scheme-list" @click="onSchemeSelect(scheme)" v-for="scheme in promoSchemeList" :key="scheme.key">
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

    <modal name="message" :scrollable="true" height="auto">
      <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12 modal-title">
        <h3>Message   <i v-show="isLoading" class="fa fa-spinner fa-spin" aria-hidden="true"></i></h3>
      </div>
      <div class="col-xs-12 modal-content">
        <textarea id="textarea1"
                  class="col-sm-12 col-lg-12 col-xs-12 col-md-12 "
                  v-model="messageBody"
                  rows="15"
                  placeholder="Enter something">
       </textarea>
      </div>
      <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12 modal-footer">
        <button @click="closeModal('message')" class="btn btn-default" type="button" name="button">Cancel</button>
        <button @click="onSendClick" :disabled="isDisabled" class="btn btn-primary" type="button" name="button">
          <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Send
        </button>
      </div>
    </modal>

  </div>
</template>
<script>
import store from '../../../customer/promotion/store';
import EventBus from '../../../util/EventBus';
import PromoList from './PromoList.vue';
import PromoForm from './PromoForm.vue';
import PromoStatus from './PromoStatus.vue';
import PromotionApi from '../../../api/PromotionApi';
import CustomerApi from '../../../api/CustomerApi';

export default {
  name: "",
  store,
  components: {
    PromoList,
    PromoForm,
    PromoStatus,
  },
  data: () => ({
    promoSchemeList:[],
    messageBody:"",
    selectedScheme:"",
    promoCode:"RADARXXXX",
    loading: false,
    disabled: false,
  }),
  mounted() {
    EventBus.$on('message-sent',this.onMessageSent.bind(this));
    EventBus.$on('customer-ids-found',this.onCustomerIdsFound.bind(this));
    EventBus.$on('scheme-list-found',this.onPromoSchemeListFound.bind(this));
  },
  computed:{
    current(){
      return this.$options.store.state.current;
    },
    currentView(){
      if(this.current == 0) return PromoList;
      else if(this.current == 1) return PromoForm;
      return PromoStatus;
    },
    title(){
      if(this.current == 0) return 'Promo List';
      else if(this.current == 1) return 'Promo Form';
      return 'Promo Status';
    },
    isLoading(){

      return this.loading;
    },
    isDisabled(){
      return this.disabled;
    }
  },
  methods: {
    changeView(k){
      this.$options.store.commit('changeView',k);
    },
    onSendPromoClick(){
      this.$modal.show('info');
    },
    onPromoSchemeListFound(data)
    {
      this.promoSchemeList = data;
    },
    onSchemeSelect(scheme)
    {
      this.selectedScheme = scheme;
      this.disabled = false;
      this.generateMessage(this.promoCode);
    },
    generateMessage(promoCode)
    {
      this.messageBody = 'Dear Customer,\nRefer someone code: '+promoCode;
      this.messageBody+=' to get '+this.selectedScheme.free_month+' month of free service';
      this.messageBody+=' and help them get '+this.selectedScheme.discount+' taka discount on installation';
      this.messageBody+=' before '+this.selectedScheme.valid_till+'.\n\nCall: 01907888907';
      this.$modal.hide('info');
      this.$modal.show('message');

    },
    onSendClick(){
      let api = new CustomerApi(EventBus);
      api.customerIds();
      this.loading = true;
      this.disabled = true;
    },
    onCustomerIdsFound(customerList){

      let api = new PromotionApi(EventBus);
      customerList.items.forEach(function(customer){
        api.generatePromoCode().then(promoCode=>{
          this.generateMessage(promoCode.code);

          api.message({id:customer.id, phone:customer.phone, message:this.messageBody}).then(response=>{
            EventBus.$emit('message-sent', response.body);
            api.savePromo({user_id:customer.id, promo_scheme_id:this.selectedScheme._id, code:promoCode.code});

          },error => {toastr.error('message not sent')});

        },error => {});

      }.bind(this));
      this.loading = false;
      //this.messageBody = "";
      //this.$modal.hide('message');

    },
    onMessageSent(data){
      //todo
      toastr.success('Message successfully sent');
    },
    closeModal(modal)
    {
      this.$modal.hide(modal);
    }
  }
}
</script>
<style lang="scss" scoped>
.btn{
  margin-right: 10px;
}
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
  box-shadow: 0 8px 32px 0  rgba(255, 221, 49,0.8);
}
.modal-title{
  color: #ffffff;
  background-color: #fb9b00;
  margin-bottom: 14px;
}
.modal-content{
  margin: 2px;
}
.modal-content textarea{
  border-radius: 1em;
  overflow: hidden;
  resize: none;
}
.modal-footer{
  text-align: center;
}
.modal-footer button{
  margin-left: 5px;
  margin-right: 5px;
}
.fa-eye, .status{
  color: #E78D00;
}
.status{
  border: 1px solid #E78D00;
}
</style>
