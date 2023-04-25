<template>
  <div class="col-md-12">
    <p><strong>{{serial}}. {{event.body}}</strong></p>
    <p>
      <span class="relaxed label label-primary" v-for="(m, i) in meta" :key="i">
        {{m.key}} ({{m.val}})
      </span>
    </p>
    <span class="helper-text">{{event.time}}</span>
    <hr class="thin">
  </div>
</template>
<script>
export default {
  props: ['event', 'serial'],
  data: () => ({

  }),
  computed: {
    meta() {
      let ret = [];
      for (var k in this.event.meta) {
        if (this.event.meta.hasOwnProperty(k)) {
          ret.push({
            key: k,
            val: this.event.meta[k],
          });
        }
      }
      return ret;
    }
  }
}
</script>
<style lang="scss" scoped>
.thin {
  margin-top: 10px;
  margin-bottom: 10px;
}
.relaxed {
  margin-right: 10px;
}
</style>
