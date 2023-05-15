<template>
  <div class="tw-w-full">
    <component
      :is="currentComponent.name"
      v-bind="currentComponent.props"
      @close="onCloseClick"
      @create="onCreateClick"
      @edit="onEditClick"
      @configure="onConfigureClick"
      @saved="fetchRmsSiteList"
      @updated="fetchRmsSiteList"
    ></component>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

import RmsSiteList from './RmsSiteList.vue'
import SiteCreateForm from './SiteCreateForm.vue'
import SiteEditForm from './SiteEditForm.vue'
import SiteConfiguration from './SiteConfiguration.vue'

export default {
  props: {
    customer: {
      type: Object,
      required: true,
    },
  },
  components: {
    RmsSiteList,
    SiteCreateForm,
    SiteEditForm,
    SiteConfiguration,
  },
  data: () => ({
    currentComponent: {
      name: null,
      props: {},
    },
  }),
  computed: {
    ...mapGetters('rms', ['sites']),
  },
  mounted() {
    this.fetchRmsSiteList()
  },
  methods: {
    async fetchRmsSiteList() {
      try {
        await this.$store.dispatch('rms/getSiteList', {
          user_id: this.customer.id,
        })
        this.setCurrentComponent(RmsSiteList)
      } catch (error) {
        console.log('rms site list fetch error', error)
      }
    },

    onCloseClick(from) {
      this.setCurrentComponent(RmsSiteList)
    },

    onCreateClick() {
      this.setCurrentComponent(SiteCreateForm, { userId: this.customer.id })
    },

    onEditClick(site) {
      this.setCurrentComponent(SiteEditForm, { site })
    },

    async onConfigureClick(site) {
      try {
        await this.$store.dispatch('rms/getSiteInfo', site.id)
        await this.$store.dispatch('rms/fetchPinConfigs', { site_id: site.id })
        this.setCurrentComponent(SiteConfiguration)
      } catch (error) {
        console.log(error)
      }
    },

    setCurrentComponent(comp, props = {}) {
      this.currentComponent = {
        name: comp,
        props,
      }
    },
  },
}
</script>

<style lang="scss" scoped>
</style>