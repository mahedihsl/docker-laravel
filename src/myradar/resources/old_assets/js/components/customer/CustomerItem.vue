<template lang="html">
    <tr>
        <td>{{ index }}</td>
        <td>
            <div class="row row-eq-height">
                <div class="col-xs-2">
                    <a :href="'/manage/customer/' + user.id">
                        <img src="img/user_avatar.png" alt="" class="img img-circle user-thumb"/>
                    </a>
                </div>
                <div class="col-xs-10">
                    <a :href="'/manage/customer/' + user.id">
                        <strong class="user-name">{{ user.name }}</strong>
                    </a>
                    <span class="user-phone"><i class="fa fa-phone"></i> {{ user.phone }}</span>
                </div>
            </div>
        </td>
        <td>
            <span :class="label.style">{{ label.name }}</span>
        </td>
        <td>{{ user.count }}</td>
    </tr>

</template>

<script>
export default {
    props: ['index', 'user'],
    mounted() {

    },
    computed: {
        label() {
            let styles = ['success', 'primary', 'warning'];
            let names = ['Private', 'Enterprise', 'Public'];
            return {
                'style': 'label label-' + styles[this.user.type - 1],
                'name':  names[this.user.type - 1],
            };
        }
    }
}
</script>

<style lang="css" scoped>
    .user-thumb {
        width: 45px;
        height: 45px;
        radius: 50%;
        margin: 10px auto;
    }
    .table > tbody > tr > td {
        vertical-align: middle;
    }
    .user-name {
        display: inline-block;
        margin-top: 12px;
    }
    .user-phone {
        display: block;
    }
</style>
