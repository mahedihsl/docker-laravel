require('../../bootstrap');


import EventBus from '../../util/EventBus';
import SettingsList from '../../components/enterprise/settings/SettingsList.vue';
import SelectCar from '../../components/enterprise/settings/SelectCar.vue';
import Fence from '../../components/enterprise/settings/fence/Manage.vue';
import store from './store';


new Vue({
  el:'#app',
  store,
  components: {
    SettingsList,
    SelectCar,
    Fence
  },
  data:{
    temp: null,
    current: SettingsList,
  },

  computed:{
    props(){

    }
  },
  beforeCreate() {
    //do something before creating vue instance

  },
  beforeMount(){
    //EventBus.$on('user_found', this.onUserFound.bind(this));
    let userId = $('input[name="user_id"]').val();

    this.$store.commit('userId', userId);

  },
  mounted(){

  },
  methods:{

  },

});
