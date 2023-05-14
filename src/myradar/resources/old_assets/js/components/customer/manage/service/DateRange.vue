<template>
    <tr>
        <td class="cell"></td>
        <td class="cell text-center" v-for="d in dates">
            <span class="date-text">{{d}}</span>
        </td>
    </tr>
</template>
<script>
export default {
    props: ['dates'],
    data: () => ({

    })
}
</script>
<style scoped>
.date-text {
    font-size: 12px;
    font-weight: bold;
    width: 100%;
}
.cell {
    width: 80px;
}
.table > tbody > tr > td {
    padding-left: 0;
    padding-right: 0;
}
</style>
