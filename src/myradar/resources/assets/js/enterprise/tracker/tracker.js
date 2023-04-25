require('../../bootstrap');


import EventBus from '../../util/EventBus';
import TrackerTable from '../../components/enterprise/tracker/TrackerTable.vue';

import store from './store';


new Vue({
  el:'#app',
  store,
  components: {
    TrackerTable
  },
  data:{
    temp: null,
    current: TrackerTable,
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
