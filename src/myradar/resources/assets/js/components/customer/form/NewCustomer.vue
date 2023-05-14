<template lang="html">
    <div class="form">
        <div class="form-group">
            <label for="name">Name</label>
            <input   id="name" name="name" placeholder="Name"
            v-validate = "'required'"
            :class="{'form-control':true,'is-danger': errors.has('name') }"
            v-model="info.name">
            <p class="help-block"></p>
             <span v-show="errors.has('name')" class="text-danger">{{ errors.first('name') }}</span>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input id="phone" name="phone" placeholder="Phone Number"
            v-validate="{ rules: { regex: /^(?:\+?88)?01[15-9]\d{8}$/,required:true}}"
            :class="{'form-control':true,'is-danger': errors.has('phone') }"
            v-model="info.phone">
            <p class="help-block"></p>
             <span v-show="errors.has('phone')" class="text-danger">{{ errors.first('phone') }}</span>
        </div>

        <div class="form-group">
            <label for="nid">National ID</label>
            <input   id="nid" name="nid" placeholder="National ID"
            v-validate = "'required|numeric'"
            :class="{'form-control':true,'is-danger': errors.has('nid') }"
            v-model="info.nid">
            <p class="help-block"></p>
             <span v-show="errors.has('nid')" class="text-danger">{{ errors.first('nid') }}</span>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input  id="email" name="email"
                v-validate="'required|email'"
                :class="{'input': true,'form-control':true,'is-danger': errors.has('email') }" type="text" placeholder="Email"
               v-model="info.email">
             <span v-show="errors.has('email')" class="text-danger">{{ errors.first('email') }}</span>
            <p class="help-block"></p>
        </div>



        <!-- <div class="form-group">
            <label for="password">Password</label>
            <input v-validate data-vv-rules="required|confirmed:password_confirmation|length='min_value:4'"
            id="password" name="password" type="password" class="form-control" v-model="info.password">
            <p class="help-block"></p>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation"
             name="password_confirmation" placeholder="Type Password Again" v-model="info.password2">
	         <span v-show="errors.has('password')">{{ errors.first('password') }}</span>
        </div> -->


        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" id="address" rows="3" class="form-control" v-model="info.address"></textarea>
            <p class="help-block"></p>
        </div>

        <div class="form-group">
            <label for="type">Customer Type</label>
            <select class="form-control" name="type" id="type" v-model="info.type">
                <option value="0">Select Type</option>
                <option :value="t.id" v-for="t in types">{{t.name}}</option>
            </select>
            <p class="help-block">{{errorMsg}}</p>
        </div>

        <div class="form-group">
            <label for="note">Note</label>
            <textarea name="note" rows="3" class="form-control" v-model="info.note"></textarea>
        </div>

        <button type="submit" :class="{'btn btn-success pull-right':true,'disabled': isButtonDisabled }"

         @click="next()">
            <i class="fa fa-arrow-right"></i> Next
        </button>
    </div>


</template>
<script>
import { mapActions,mapState} from 'vuex';
import {required,minLength,between} from 'vuelidate/lib/validators';

export default {

  data: function() {
    return {
      title: 'New Customer',
      errorMsg :'',
      info: {
        name: '',
        phone: '',
        nid: '',
        email: '',
        password: '',
        password2: '',
        address: '',
        type: '0',
        note: '',
      }
    }
  },

  computed: {

    isEmailRequired() {
              if(this.info.email === '')
                  console.log("email empty");
                  return true; // phone is required
              return false;
          },
          isPhoneRequired() {
              // check if phone is empty
              if(this.info.phone === '')
                    console.log('phone empty')
                  return true; // cphone is required
              return false;
          },
    // phone() { return this.$store.getters.customerPhone; },
    // nid() { return this.$store.getters.customerNid; },
    // email() { return this.$store.getters.customerEmail; },
    // password() { return this.$store.getters.customerPassword; },
    // password2() { return this.$store.getters.customerPassword2; },
    // address() { return this.$store.getters.customerAddress; },
    // type() { return this.$store.getters.customerType; },
    // note() { return this.$store.getters.customerNote; },
    types() {
      return this.$store.getters.customerTypes;
    },
    hasValidationError() {
      return this.errors.any();
    },
    isButtonDisabled() {
      return !this.isTypeSelected || this.errors.any()
    },
    isTypeSelected(){
       return parseInt(this.info.type)!=0;

    }
    // ...mapState({
    //     name: state => state.customer.name,
    // })
  },
  watch: {

  },
  mounted: function() {

    this.$store.commit('setPageTitle', this.title);
    this.$store.dispatch('getCustomerTypes');
  },

  methods: {
    next() {
      $("#name").focus();
      $("#nid").focus();
      $("#phone").focus();
      $("#email").focus();
      //$("#password").focus();
      //$("#password_confirmation").focus();
    //   console.log(this.isEmailRequired)
    //   console.log(this.isPhoneRequired)
      if(!this.isTypeSelected)
       {
         this.errorMsg = 'Please Select Type';
       }
       else{
         this.errorMsg = "";
       }
      if(this.isButtonDisabled==true)
        {
          return
        }
      for (let k in this.info) {
        console.log('key: ' + k);
        if (this.info.hasOwnProperty(k)) {
          this.$store.commit('updateCustomerInfo', {
            key: k,
            val: this.info[k]
          });
        }
      }

      this.$emit('next');

    },

  }
}
</script>

<style lang="css">
</style>
