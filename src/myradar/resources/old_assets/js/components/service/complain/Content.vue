<template>
  <div id="">
    <component :is="currentList"> </component>
  </div>
</template>
<script>
import ComplainList from './ComplainList.vue';
import ComplainDetails from './ComplainDetails.vue';
import {mapGetters} from 'vuex';
export default {
  name: "",
  components: {
    ComplainList,
    ComplainDetails
  },
  data: () => ({

  }),
  computed:{
    ...mapGetters(['currentContent']),
    currentList(){
      return this.currentContent ? ComplainDetails : ComplainList;
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
