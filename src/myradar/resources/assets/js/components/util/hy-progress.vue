<template lang="html">
    <div class="">
        <h3 class="text-center">
          <i class="fa fa-check" v-show="saveCustomerFlag"> </i>
          <i class="fa fa-times" v-show="saveCustomerFlag==false"> </i>
            <i class="fa fa-spinner fa-spin" aria-hidden="true" v-show="saveCustomerFlag==null"></i>
          Customer Created</h3>
        <h3 class="text-center">
          <i class="fa fa-check" v-show="saveCarFlag"> </i>
          <i class="fa fa-times" v-show="saveCarFlag==false"> </i>
        <i class="fa fa-spinner fa-spin" aria-hidden="true" v-show="saveCarFlag==null"></i>
          </i>Car Created</h3>
        <h3 class="text-center">
            <i class="fa fa-check" v-show="saveBindServiceFlag"> </i>
            <i class="fa fa-times" v-show="saveBindServiceFlag==false"> </i>
              <i class="fa fa-spinner fa-spin" aria-hidden="true" v-show="saveBindServiceFlag==null"></i>
          </i>Service Assigned</h3>

            <h5>{{setServiceErrorMsg}}</h5>
            <div  id="serviceMissing" v-show="setServiceCheckFlag">
                <div v-for="item in setServiceCheck">
                  <div class="alert alert-danger">
                       <h4>{{ item }} Service Data Missing</h4>
                    </div>
                </div>
              </div>
    </div>
</template>

<script>
export default {
  data: function() {
    return {


    };
  },
  mounted: function() {
    console.log('Component mounted.')
  },
  computed: {

    saveCustomerFlag: function() {

      return this.$store.getters.saveCustomerFlag

    },
    saveCarFlag: function() {

      return this.$store.getters.saveCarFlag

    },
    saveBindServiceFlag: function() {

      return this.$store.getters.saveBindServiceFlag

    },
    setServiceErrorMsg: function() {
        return this.$store.getters.setServiceErrorMsg

    },
    setServiceCheck: function() {
        return this.$store.getters.setServiceCheck

    },
    setServiceCheckFlag: function() {
       console.log(this.$store.getters.setServiceCheckFlag);
        return this.$store.getters.setServiceCheckFlag

    },
  }
}
</script>
