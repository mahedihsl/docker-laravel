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
      {link: '/lastpulse', text: '3.7.5 and above'},
      {link: '/lastpulse?day=1', text: 'below 3.7.5'},
    ];
  }
}
</script>
<style lang="scss" scoped>
.focused {
  background: #eeeeee;
}
</style>
