  <template>
  <div>
    <Breadcrumb title="Chi tiết sản phẩm" />

    <!-- Product Details Section Begin -->
    <section class="product-details spad" v-if="product">
      <div class="container">
        <div class="row">
          <!-- Hình ảnh -->
          <div class="col-lg-6 col-md-6">
            <div class="product__details__pic">
              <div class="product__details__pic__item">
                <img class="product__details__pic__item--large" :src="product.image" :alt="product.name">
              </div>
            </div>
          </div>

          <!-- Thông tin -->
          <div class="col-lg-6 col-md-6">
            <div class="product__details__text">
              <h3>{{ product.name }}</h3>


              <div class="product__details__price">
                ${{ product.price.toFixed(2) }}
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
                  <span>Còn hàng ({{ product.stock }} sản phẩm)</span>
                </li>
                <li>
                  <b>Giao hàng</b>
                  <span>
                    Giao trong 1 ngày.
                    <span>Nhận tại cửa hàng miễn phí hôm nay</span>
                  </span>
                </li>
                <li>
                  <b>Trọng lượng</b>
                  <span>0.5 kg</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Related Product Section Begin -->
    <section class="related-product">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="section-title related__product__title">
              <h2>Sản phẩm liên quan</h2>
            </div>
          </div>
        </div>

        <div class="row">
          <ProductCard v-for="product in relatedProducts" :key="product.id" :product="product" />
        </div>
      </div>
    </section>
    <!-- Related Product Section End -->
  </div>
</template>


<script setup>
import { ref, computed } from 'vue'
import Breadcrumb from '@/components/layout/Breadcrumb.vue'
import ProductCard from '@/components/ui/ProductCard.vue'
import { useCart } from '@/composables/useCart'
import { products } from '@/data/products'
import { useRoute } from 'vue-router'

const route = useRoute()
const { addToCart } = useCart()
const productId = route.params.id
const quantity = ref(1)

const product = computed(() => {
  return products.find(p => p.id === parseInt(route.params.id))
})

const relatedProducts = computed(() => {
  if (!product.value) return []
  return products
    .filter(
      p =>
        p.category === product.value.category &&
        p.id !== product.value.id
    )
    .slice(0, 4)
})

const increaseQuantity = () => {
  quantity.value++
}

const decreaseQuantity = () => {
  if (quantity.value > 1) {
    quantity.value--
  }
}

const handleAddToCart = () => {
  if (product.value) {
    addToCart(product.value, quantity.value)
    alert(
      `Đã thêm ${quantity.value} x ${product.value.name} vào giỏ hàng!`
    )
  }
}

</script>
