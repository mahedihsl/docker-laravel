<template>
    <tr>
        <td>
            <i class="fa fa-spinner fa-spin" v-if="!items.length"></i> {{service.name}}
        </td>
        <td v-for="o in items">
            <div class="cell" v-bind:class="{active: o}"></div>
        </td>
    </tr>
</template>
<script>
import EventBus from '../../../../util/EventBus';
import ServiceApi from '../../../../api/ServiceApi';

export default {
    props: ['carid', 'service'],
    data: () => ({
        items: [],
    }),
    mounted() {
        EventBus.$on('service-log-found', this.onServiceLogFound.bind(this));

        let api = new ServiceApi(EventBus);
        api.getLog(this.carid, this.service.id);
    },
    methods: {
        onServiceLogFound(list) {
            this.items = list.map(o => o.status);

            let dates = list.map(o => o.date);
            EventBus.$emit('date-range-changed', dates);
        }
    }
}
</script>
<style scoped>
.cell {
    height: 20px;
    width: 80px;
}
.active {
    background: #4CAF50;
}
.table > tbody > tr > td {
    padding-left: 0;
    padding-right: 0;
}
</style>
