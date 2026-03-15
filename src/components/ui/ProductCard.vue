<template>
  <div class="col-lg-3 col-md-4 col-sm-6">
    <div class="featured__item">

      <!-- Hình tạm thời vì backend chưa có image -->
      <div
        class="featured__item__pic"
        :style="backgroundStyle"
        @click="goToProduct"
      >
        <ul class="featured__item__pic__hover">
          <li>
            <a href="#" @click.prevent.stop="handleAddToCart">
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
        <h5>{{ firstVariant?.price ? `${firstVariant.price} VND` : 'Liên hệ' }}</h5>
      </div>

    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useCart } from '@/composables/useCart'
import { useRouter } from 'vue-router'

const API_BASE = 'http://localhost:8080'

const router = useRouter()

const props = defineProps({
  product: {
    type: Object,
    required: true
  }
})

const { addToCart } = useCart()

const firstVariant = computed(() => {
  return props.product?.variants?.[0] || null
})

const mainImage = computed(() => {
  if (!props.product?.images?.length) return null

  return (
      props.product.images.find(img => img.isMain) ||
      props.product.images[0]
  )
})

const backgroundStyle = computed(() => ({
  backgroundImage: mainImage.value
      ? `url(${API_BASE}/${mainImage.value.imagePath})`
      : `url(https://via.placeholder.com/300x250?text=${props.product.name})`,
  backgroundSize: 'cover',
  backgroundPosition: 'center'
}))

/* ======================
   GO TO PRODUCT
====================== */
const goToProduct = () => {
  router.push(`/shop/${props.product.productId}`)
}

/* ======================
   ADD TO CART
====================== */
const handleAddToCart = () => {

  const productCart = {
    productId: props.product.productId,
    name: props.product.name,
    variantId: firstVariant.value?.variantId,
    stock: firstVariant.value?.stock,
    price: firstVariant.value?.price || 0,
    image: mainImage.value
        ? `${API_BASE}/${mainImage.value.imagePath}`
        : 'https://via.placeholder.com/300x250'
  }

  addToCart(productCart, 1)

  alert(`Đã thêm ${props.product.name}  vào giỏ hàng!`)

}
</script>