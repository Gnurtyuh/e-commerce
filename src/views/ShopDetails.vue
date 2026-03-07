<template>
  <div>
    <Breadcrumb title="Chi tiết sản phẩm" />

    <section class="product-details spad" v-if="product">
      <div class="container">
        <div class="row">

          <!-- IMAGE -->
          <div class="col-lg-6 col-md-6">
            <div class="product__details__pic">
              <div class="product__details__pic__item">
                <img
                  class="product__details__pic__item--large"
                  :src="mainImage"
                  :alt="product.name"
                >
              </div>
            </div>
          </div>

          <!-- INFO -->
          <div class="col-lg-6 col-md-6">
            <div class="product__details__text">

              <h3>{{ product.name }}</h3>

              <div class="product__details__price">
                {{ displayPrice }}đ
              </div>

              <p>{{ product.description }}</p>

              <div class="product__details__quantity">
                <div class="quantity">
                  <div class="pro-qty">
                    <span class="dec qtybtn" @click="decreaseQuantity">-</span>
                    <input type="text" v-model.number="quantity">
                    <span class="inc qtybtn" @click="increaseQuantity">+</span>
                  </div>
                </div>
              </div>

              <a href="#" class="primary-btn" @click.prevent="handleAddToCart">
                THÊM VÀO GIỎ
              </a>

              <ul>
                <li>
                  <b>Tình trạng</b>
                  <span>Còn hàng</span>
                </li>
                <li>
                  <b>Giao hàng</b>
                  <span>Giao trong 1 ngày</span>
                </li>
              </ul>

            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- RELATED -->
    <section class="related-product" v-if="relatedProducts.length">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="section-title related__product__title">
              <h2>Sản phẩm liên quan</h2>
            </div>
          </div>
        </div>

        <div class="row">
          <ProductCard
            v-for="item in relatedProducts"
            :key="item.productId"
            :product="item"
          />
        </div>
      </div>
    </section>

  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'
import Breadcrumb from '@/components/layout/Breadcrumb.vue'
import ProductCard from '@/components/ui/ProductCard.vue'
import { useCart } from '@/composables/useCart'

const API_BASE = 'http://localhost:8080'

const route = useRoute()
const { addToCart } = useCart()

const product = ref(null)
const relatedProducts = ref([])
const quantity = ref(1)

/* ======================
   LOAD PRODUCT DETAIL
====================== */
const fetchProductDetail = async () => {
  try {
    const productId = route.params.id

    const productRes = await axios.get(
      `${API_BASE}/products/${productId}`
    )

    const baseProduct = productRes.data

    const [variantRes, imageRes] = await Promise.all([
      axios.get(`${API_BASE}/by-product/${productId}`),
      axios.get(`${API_BASE}/products/${productId}/images`)
    ])

    product.value = {
      ...baseProduct,
      variants: variantRes.data || [],
      images: imageRes.data || []
    }

    fetchRelatedProducts(baseProduct.categoryId)

  } catch (err) {
    console.error('Lỗi load chi tiết sản phẩm:', err)
  }
}

/* ======================
   LOAD RELATED
====================== */
const fetchRelatedProducts = async (categoryId) => {
  try {
    const res = await axios.get(
      `${API_BASE}/products/by-category/${categoryId}`
    )

    const filtered = res.data
      .filter(p => p.productId != route.params.id)
      .slice(0, 4)

    // attach variants + images giống product detail
    relatedProducts.value = await Promise.all(
      filtered.map(async (item) => {
        const [variantRes, imageRes] = await Promise.all([
          axios.get(`${API_BASE}/by-product/${item.productId}`),
          axios.get(`${API_BASE}/products/${item.productId}/images`)
        ])

        return {
          ...item,
          variants: variantRes.data || [],
          images: imageRes.data || []
        }
      })
    )

  } catch (err) {
    console.error('Lỗi load related:', err)
  }
}

/* ======================
   IMAGE
====================== */
const mainImage = computed(() => {
  if (!product.value?.images?.length)
    return 'https://via.placeholder.com/500x500?text=No+Image'

  const main = product.value.images.find(i => i.isMain)

  const imagePath = main
    ? main.imagePath
    : product.value.images[0].imagePath

  return `${API_BASE}/${imagePath}`
})

/* ======================
   PRICE
====================== */
const displayPrice = computed(() => {
  if (!product.value?.variants?.length) return 0
  return product.value.variants[0].price
})

/* ======================
   QUANTITY
====================== */
const increaseQuantity = () => quantity.value++
const decreaseQuantity = () => {
  if (quantity.value > 1) quantity.value--
}

/* ======================
   ADD TO CART
====================== */
const handleAddToCart = () => {
  if (!product.value) return

  addToCart({
    ...product.value,
    price: displayPrice.value,
    image: mainImage.value
  }, quantity.value)

  alert(`Đã thêm ${quantity.value} x ${product.value.name} vào giỏ hàng!`)
}

onMounted(fetchProductDetail)
</script>