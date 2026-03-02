<template>
  <div class="hero__categories">
    <div
      class="hero__categories__all"
      @click="isOpen = !isOpen"
    >
      <i class="fa fa-bars"></i>
      <span>Tất cả danh mục</span>
    </div>

    <transition name="slide">
      <ul v-show="isOpen">
        <li v-if="showAllOption">
          <a href="#" @click.prevent="handleSelect(null)">
            Tất cả
          </a>
        </li>
        <li
          v-for="cat in categories"
          :key="cat.categoryId || cat.id"
        >
          <a href="#" @click.prevent="handleSelect(cat.categoryId || cat.id)">
            {{ cat.name }}
          </a>
        </li>
      </ul>
    </transition>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  categories: {
    type: Array,
    default: () => []
  },
  showAllOption: {
    type: Boolean,
    default: false
  },
  initiallyOpen: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(['selectCategory'])

const isOpen = ref(props.initiallyOpen)

const handleSelect = (categoryId) => {
  emit('selectCategory', categoryId)
}
</script>

<style scoped>
.slide-enter-active,
.slide-leave-active {
  transition: all 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>
