<template>
  <div id=''>
    <item  v-for="(scheme, i) in promo_schemes" :scheme="scheme" :key="i" :serial="i + 1"> </item>
  </div>
</template>
<script>
import PromotionApi from '../../../api/PromotionApi';
import EventBus from '../../../util/EventBus';
import item from './item';
export default {
  name: "",
  components: {
    item,
  },
  data: () => ({
    schemes: [],
  }),
  computed:{
    promo_schemes(){
      return this.schemes;
    }
  },
  mounted() {
    EventBus.$on('scheme-list-found',this.onPromoSchemeListFound.bind(this));
    let api= new PromotionApi(EventBus);
    api.promoSchemeList();
  },
  methods: {
    onPromoSchemeListFound(data) {
      this.schemes = data;
    }
  }
}
</script>

<style lang="scss" scoped>

</style>
