<template>
  <ul class="list-group" style="margin-top: 20px;">
    <li class="list-group-item" :class="{focused: i == day}" v-for="(o, i) in items">
      <a v-bind:href="o.link">{{o.text}}</a>
    </li>
  </ul>
</template>
<script>
import moment from 'moment';
import {mapGetters} from 'vuex';

export default {
  data: () => ({
    items: [],
  }),
  computed: {
    ...mapGetters(['day']),
  },
  mounted() {
    this.items = [
      {link: '/performance', text: 'Today'},
      {link: '/performance?day=1', text: 'Yesterday'},
      {link: '/performance?day=2', text: moment().subtract(2, 'days').format('D MMMM')},
      {link: '/performance?day=3', text: moment().subtract(3, 'days').format('D MMMM')},
      {link: '/performance?day=4', text: moment().subtract(4, 'days').format('D MMMM')},
    ];
  }
}
</script>
<style lang="scss" scoped>
.focused {
  background: #eeeeee;
}
</style>
