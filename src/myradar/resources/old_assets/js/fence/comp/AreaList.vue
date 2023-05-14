<template>
  <div>
    <ul class="area-list">
      <li
        class="area-item"
        v-for="(v, i) in items"
        :key="i"
        @click="onItemClick(i)"
        :class="{ active: i === activeIndex }"
      >
        <span class="area-name">{{ i + 1 }}. {{ v.name }}</span>
        <div class="right-section" v-if="v.type != 'template'">
          <span class="badge-car-count mr-6">
            <i class="fa fa-car mr-2"></i>
            <strong>{{ v.cars.length }}</strong>
          </span>
          <i class="fa fa-chevron-right"></i>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    items: {
      type: Array,
      required: true,
    },
  },
  data: () => ({
    activeIndex: -1,
  }),
  methods: {
    onItemClick(i) {
      this.activeIndex = i
      this.$emit('item-click', this.items[i])
    },
  },
}
</script>

<style scoped>
.area-list {
  list-style: none;
  padding-left: 0;
  margin-bottom: 48px;
  overflow: scroll;
}
.area-item {
  cursor: pointer;
  padding: 10px 20px;
  border-top: 1px solid #eeeeee;
  transition: all 0.3s ease-in;
  position: relative;
}
.area-item:last-child {
  border-bottom: 1px solid #eeeeee;
}
.area-item.active {
  background: #f5f5f5;
}
.area-item:hover {
  background: #f5f5f5;
}
.area-name {
  color: #424242;
  font-size: 1.35rem;
  font-weight: 600;
}
.right-section {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);

  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
}
.badge-car-count {
  border: 1px solid #7986cb;
  background: #e8eaf6;
  color: #3f51b5;
  font-size: 1.1rem;
  border-radius: 50px;
  padding: 3px 8px;
}
</style>
