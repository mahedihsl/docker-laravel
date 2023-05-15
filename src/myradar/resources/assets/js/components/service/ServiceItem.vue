<template lang="html">
    <tr>
        <td>{{item.name}}</td>
        <td>{{item.type_text}}</td>
        <td>
            <a v-bind:href="editUrl" class="btn btn-sm btn-link">
                <i class="fa fa-pencil"></i>
            </a>
            <a v-bind:href="deleteUrl" class="btn btn-sm btn-link">
                <i class="fa fa-trash-o"></i>
            </a>
        </td>
    </tr>
</template>

<script>
export default {
    props: ['item'],
    mounted: function() {

    },
    computed: {
        editUrl: function() {
            return '/service/edit/' + this.item._id;
        },
        deleteUrl: function() {
            return '/service/delete/' + this.item._id;
        }
    }
}
</script>

<style lang="css">
</style>
