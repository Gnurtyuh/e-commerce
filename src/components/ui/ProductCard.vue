<template>
  <div class="col-lg-3 col-md-4 col-sm-6 mix" :class="product.category">
    <div class="featured__item">
      <div class="featured__item__pic set-bg" :data-setbg="product.image" :style="backgroundStyle">
        <ul class="featured__item__pic__hover">
          <li><a href="#" @click.prevent="addToWishlist"><i class="fa fa-heart"></i></a></li>
          <li><a href="#" @click.prevent><i class="fa fa-retweet"></i></a></li>
          <li><a href="#" @click.prevent="handleAddToCart"><i class="fa fa-shopping-cart"></i></a></li>
        </ul>
      </div>
      <div class="featured__item__text">
        <h6>
          <router-link :to="`/shop/${product.id}`">{{ product.name }}</router-link>
        </h6>
        <h5>${{ product.price.toFixed(2) }}</h5>
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

const backgroundStyle = computed(() => ({
  backgroundImage: `url(${props.product.image})`
}))

const handleAddToCart = () => {
  addToCart(props.product, 1)
  alert(`${props.product.name} added to cart!`)
}

const addToWishlist = () => {
  alert(`${props.product.name} added to wishlist!`)
}
</script>
