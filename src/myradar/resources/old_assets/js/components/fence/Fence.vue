<template lang="html">
    <div class="col-md-12" v-on:click="toggleFence">
        <div class="fence-item">
            <i class="fa fa-check text-success" v-show="fence.selected === true"></i>
            <i class="fa fa-spinner fa-spin text-primary" v-show="loading === true"></i>
            <i class="fa fa-circle-o text-dimmed" v-show="fence.selected === false"></i>
            <span>{{fence.name}}</span>
        </div>
    </div>
</template>

<script>
import FenceApi from '../../api/FenceApi';
import EventBus from '../../util/EventBus';

export default {
    props: ['fence'],
    data: function() {
        return {
            loading: false,
        };
    },
    mounted() {
        EventBus.$on('fence-toggled', this.onToggleComplete.bind(this));
    },
    methods: {
        onToggleComplete(fenceId, flag) {
            if (fenceId == this.fence.id) {
                this.fence.selected = flag;
                this.loading = false;
            }
        },

        toggleFence() {
            let api = new FenceApi(EventBus);
            api.toggleFence(this.fence.id, !this.fence.selected);
            this.fence.selected = null;
            this.loading = true;
        }
    },
}
</script>

<style lang="css">
.fence-item {
    cursor: pointer;
    padding: 15px;
    border-bottom: solid 1px #E0E0E0;
}
.fence-item:hover {
    background: #EEEEEE;
}
.fence-item > span {
    font-size: 14px;
}
.text-dimmed {
    color: #BDBDBD;
}
</style>
