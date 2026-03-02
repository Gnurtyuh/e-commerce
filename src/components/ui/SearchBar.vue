<template>
  <div class="hero__search__form">
    <form @submit.prevent="onSubmit">
      <input
        v-model="internalKeyword"
        type="text"
        placeholder="Bạn đang tìm sản phẩm gì?"
      />
      <button type="submit" class="site-btn">
        TÌM KIẾM
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRouter } from 'vue-router'

const props = defineProps({
  initialKeyword: {
    type: String,
    default: ''
  },
  autoRoute: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(['search'])
const router = useRouter()
const internalKeyword = ref(props.initialKeyword)

// Theo dõi khi initialKeyword thay đổi từ bên ngoài
watch(() => props.initialKeyword, (newVal) => {
  internalKeyword.value = newVal || ''
})

const onSubmit = () => {
  if (!internalKeyword.value.trim()) return

  if (props.autoRoute) {
    // Tự động chuyển trang đến shop nếu true
    router.push({
      path: '/shop',
      query: { q: internalKeyword.value.trim() }
    })
  } else {
    // Phát sự kiện tìm kiếm nếu cần xử lý riêng
    emit('search', internalKeyword.value.trim())
  }
}
</script>
