<template>
  <ul class="car-list">
    <li v-for="(c, i) in items" :key="i">
      <span :class="{ 'text-success': c.subscribed }">
        <i
          class="fa mr-2"
          :class="{
            'fa-circle-thin': !c.subscribed,
            'fa-check-circle-o': c.subscribed,
          }"
        ></i>
        {{ c.reg_no }}
      </span>
      <button
        class="btn btn-plus btn-small absolute-right-center mr-4"
        v-if="!c.subscribed"
        @click="$emit('subscribe', c)"
      >
        <i class="fa fa-plus"></i>
      </button>
      <button
        class="btn btn-minus btn-small absolute-right-center mr-4"
        v-if="c.subscribed"
        @click="$emit('unsubscribe', c)"
      >
        <i class="fa fa-minus"></i>
      </button>
    </li>
  </ul>
</template>

<script>
export default {
  props: {
    items: {
      type: Array,
      required: true,
    },
  },
}
</script>

<style scoped>
.car-list {
  list-style: none;
  padding: 0;
}

.car-list > li {
  position: relative;
  padding: 10px 20px;
  border-top: 1px solid #eeeeee;
  transition: all 0.2s ease-in;
}

.car-list > li:hover {
  background: #f5f5f5;
}

.car-list > li:last-child {
  border-bottom: 1px solid #eeeeee;
}

.car-list > li > span {
  font-weight: 600;
  font-size: 1.25rem;
}
</style>
