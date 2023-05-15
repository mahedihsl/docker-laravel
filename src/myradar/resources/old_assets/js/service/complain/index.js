require('../../bootstrap')

import SideBar from '../../components/service/complain/SideBar.vue';
import ComplainForm from '../../components/service/complain/ComplainForm.vue';
import Content from '../../components/service/complain/Content.vue';
import EventBus from '../../util/EventBus';
import store from './store';
new Vue({
  el: '#app',
  store,
  components: {
    SideBar,
    ComplainForm,
    Content,
  },
  data: {},
  computed: {
    current() {
        return this.$options.store.state.current;
    },
    currentView() {
        return this.current ? ComplainForm : Content;
    },
    title() {
        return this.current ? 'New Complain' : 'All Complains';
    }
  },
  mounted() {
    EventBus.$on('change-view',this.changeView.bind(this));
    EventBus.$on('change-content',this.changeContent.bind(this));
  },
  methods: {
    changeView(k) {
        this.$options.store.commit('changeView', k);
    },
    changeContent(k) {
        this.$options.store.commit('changeContent', k);
    },
  }
});
