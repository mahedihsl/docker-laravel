<template>
  <div class="empty-box">
    <img src="/images/empty.svg" class="empty-icon" alt="" />
    <h2 class="empty-title">{{ title }}</h2>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: false,
      default: 'No item available',
    },
  },
}
</script>

<style lang="css" scoped>
.empty-box {
  width: 100%;
  padding: 30px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.empty-icon {
  width: 25%;
  height: auto;
}
.empty-title {
  font-size: 18px;
  color: #37474f;
  font-weight: 600;

  margin-top: 30px;
}
</style>
