<template>
  <div class="col-xs-12">
    <div class="col-xs-12 col-md-3 col-lg-3 sidebar-nav-fixed companyNames">
      <ul  class="nav">
        <li class="nav-header"><h3>Bus Companies</h3></li>
      </ul>
      <ul class="nav" v-for="company in allCompanies" :company="company">
        <li @click="onCompanyClick(1, company.id)"><h4><a href="#">{{company.name}}</a></h4></li>
      </ul>
    </div>
    <div class="col-xs-12 col-md-9 col-lg-9">
      <component :is="currentView"></component>
    </div>


  </div>
</template>
<script>

import BusList from './BusList.vue';
import RouteForm from './RouteForm.vue';
import BusApi from '../../api/BusApi';
import store from '../../bus/store';
import {mapGetters} from 'vuex';
import EventBus from '../../util/EventBus';

export default {
  name: "",
  store,
  components: {
    BusList,
    RouteForm,
  },
  data: () => ({

  }),
  mounted() {
    this.$store.dispatch('getCompanies');
  },
  computed: {
    ...mapGetters({
      allCompanies:'allCompanies',
    }),
    current(){
      return this.$store.state.current;
    },
    currentView(){
      if(this.current == -1)
        return null;
      return this.current ? BusList : RouteForm;
    }


  },
  methods: {
    onCompanyClick(val, id) {
      this.$store.commit("SelectedCompany",id);
      this.$store.commit("changeView",val);
      EventBus.$emit('company-changed',id);
    }
  }

}
</script>
<style lang="scss" scoped>
.nav-header{
  border-bottom: 1px solid #ffffff;
}
.companyNames{
  background-color: #EFEFF0;
  text-align: center;
}
.nav li{
  border-bottom: 1px solid #ffffff;
}
</style>
