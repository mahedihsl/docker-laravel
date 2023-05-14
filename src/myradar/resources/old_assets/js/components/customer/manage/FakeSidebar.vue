<template>
    <div>
        <div class="col-xs-12 sidebar-header">
            <img src="/img/user_avatar.png" alt="" class="img img-circle img-responsive profile-img">
            <div class="placeholder md"></div>
            <div class="placeholder sm"></div>
        </div>
        <div class="col-xs-12 nopadding">
            <ul class="manage-menu">
                <li><div class="placeholder md"></div></li>
                <li><div class="placeholder md"></div></li>
                <li><div class="placeholder md"></div></li>
                <li><div class="placeholder md"></div></li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
  data: () => ({

  })
}
</script>
<style lang="scss" scoped>
.placeholder {
    background: #E0E0E0;
    border-radius: 3px;
    margin: 10px 10px;
}
.placeholder.md {
    height: 20px;
}
.placeholder.sm {
    height: 15px;
}
.manage-menu > li {
    padding: 5px 10px;
}
</style>
