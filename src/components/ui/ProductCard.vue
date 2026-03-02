<template>
  <div class="col-lg-3 col-md-4 col-sm-6">
    <div class="featured__item">

      <!-- Hình tạm thời vì backend chưa có image -->
      <div
        class="featured__item__pic"
        :style="backgroundStyle"
      >
        <ul class="featured__item__pic__hover">
          <li>
            <a href="#" @click.prevent="handleAddToCart">
              <i class="fa fa-shopping-cart"></i>
            </a>
          </li>
        </ul>
      </div>

      <div class="featured__item__text">
        <h6>
          <router-link :to="`/shop/${product.productId}`">
            {{ product.name }}
          </router-link>
        </h6>

        <!-- Backend chưa có price -->
        <h5>Liên hệ</h5>
      </div>

    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useCart } from '@/composables/useCart'

const props = defineProps({
  product: {
    type: Object,
    required: true
  }
})

const { addToCart } = useCart()

// Vì backend chưa có image → dùng ảnh placeholder
const backgroundStyle = computed(() => ({
  backgroundImage: `url(https://via.placeholder.com/300x250?text=${props.product.name})`,
  backgroundSize: 'cover',
  backgroundPosition: 'center'
}))

const handleAddToCart = () => {
  addToCart(props.product, 1)
  alert(`Đã thêm ${props.product.name} vào giỏ hàng!`)
}
</script>