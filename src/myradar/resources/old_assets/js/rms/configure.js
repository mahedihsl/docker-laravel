require('../bootstrap');

import PinHeader from './component/PinHeader.vue'
import PinConfig from './component/PinConfig.vue'
import PinConfigForm from './component/PinConfigForm.vue'

import { mapGetters } from 'vuex'
import store from './store';

new Vue({
    el: '#app',
    store,
    components: {
        PinHeader,
        PinConfig,
        PinConfigForm,
    },
    data: {
        site_id: '',
        visibleForms: [],
    },
    computed: {
        ...mapGetters(['site', 'pinConfigsOfDevice']),
    },
    mounted() {
        this.site_id = document.getElementById('site_id').value
        this.getSiteInformation(this.site_id)
    },
    methods: {
        async getSiteInformation(site_id) {
            try {
                await this.$store.dispatch('getSiteInfo', site_id)
                await this.$store.dispatch('fetchPinConfigs', { site_id })
            } catch (error) {
                console.log(error)
            }
        },
        async onPinConfigFormClosed(comId, isSavingSuccessful) {
            if (isSavingSuccessful) {
                await this.$store.dispatch('fetchPinConfigs', { site_id: this.site_id })
            }
            const index = this.visibleForms.findIndex(id => id === comId)
            if (index !== -1) {
                this.visibleForms.splice(index, 1)
            }
        },
        showPinConfigForm(comId) {
            if (!this.visibleForms.includes(comId)) {
                this.visibleForms.push(comId)
            }
        },
        pinConfigFormVisibility(comId) {
            return this.visibleForms.includes(comId)
        }
    },
})
