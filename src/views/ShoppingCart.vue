<template>
  <div>
    <Breadcrumb title="Giỏ hàng" />

    <!-- Shopping Cart Section Begin -->
    <section class="shoping-cart spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">

            <!-- CART TABLE -->
            <div class="shoping__cart__table">

              <table v-if="cartItems.length > 0">
                <thead>
                <tr>
                  <th class="shoping__product">Sản phẩm</th>
                  <th>Giá</th>
                  <th>Số lượng</th>
                  <th>Thành tiền</th>
                  <th></th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="item in cartItems" :key="item.productId">

                  <td class="shoping__cart__item">
                    <img
                        :src="item.image"
                        :alt="item.name"
                        style="width: 100px;"
                    >
                    <h5>{{ item.name }}</h5>
                  </td>

                  <td class="shoping__cart__price">
                    {{ formatPrice(item.price) }} VND
                  </td>

                  <td class="shoping__cart__quantity">
                    <div class="quantity">
                      <div class="pro-qty">

                          <span
                              class="dec qtybtn"
                              @click="decreaseQuantity(item)"
                          >-</span>

                        <input
                            type="text"
                            :value="item.quantity"
                            readonly
                        >

                        <span
                            class="inc qtybtn"
                            @click="increaseQuantity(item)"
                            :class="{ disabled: item.quantity >= item.maxStock }"
                        >+</span>

                      </div>
                      <!-- Hiển thị thông báo tồn kho -->
                      <small v-if="item.maxStock" class="stock-info">
                        Còn lại: {{ item.maxStock - item.quantity }}
                      </small>
                    </div>
                  </td>

                  <td class="shoping__cart__total">
                    {{ formatPrice(item.price * item.quantity) }} VND
                  </td>

                  <td class="shoping__cart__item__close">
                      <span
                          class="icon_close"
                          @click="removeFromCart(item.productId)"
                      ></span>
                  </td>

                </tr>
                </tbody>
              </table>

              <!-- EMPTY CART -->
              <div v-else class="text-center p-5">
                <h4>Giỏ hàng của bạn đang trống</h4>
                <router-link to="/shop" class="primary-btn mt-3">
                  Đi mua hàng
                </router-link>
              </div>

            </div>

          </div>
        </div>

        <!-- Buttons -->
        <div class="row">
          <div class="col-lg-12">

            <div class="shoping__cart__btns">

              <router-link
                  to="/shop"
                  class="primary-btn cart-btn"
              >
                TIẾP TỤC MUA SẮM
              </router-link>

              <a
                  href="#"
                  class="primary-btn cart-btn cart-btn-right"
                  @click.prevent="clearCart"
              >
                <span class="icon_close"></span>
                Xóa giỏ hàng
              </a>

            </div>

          </div>

          <!-- Total -->
          <div class="col-lg-6 offset-lg-6">

            <div class="shoping__checkout">

              <h5>Tổng giỏ hàng</h5>

              <ul>
                <li>
                  Tạm tính
                  <span>{{ formatPrice(cartTotal) }} VND</span>
                </li>

                <li>
                  Tổng cộng
                  <span>{{ formatPrice(cartTotal) }} VND</span>
                </li>
              </ul>

              <!-- CHECKOUT BUTTON -->
              <button
                  class="primary-btn"
                  :disabled="cartItems.length === 0 || !isAllValid"
                  @click="goToCheckout"
              >
                TIẾN HÀNH THANH TOÁN
              </button>

              <!-- Hiển thị thông báo lỗi tổng thể -->
              <p v-if="hasStockError" class="stock-error mt-2">
                Một số sản phẩm vượt quá số lượng tồn kho
              </p>

            </div>

          </div>

        </div>
      </div>
    </section>
    <!-- Shopping Cart Section End -->
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import Breadcrumb from '@/components/layout/Breadcrumb.vue'
import { useCart } from '@/composables/useCart'
import axios from "axios";

const router = useRouter()
const loadingStock = ref(false)

const {
  cartItems,
  cartTotal,
  removeFromCart,
  updateQuantity,
  clearCart
} = useCart()

// Computed: Kiểm tra tất cả sản phẩm có hợp lệ không
const isAllValid = computed(() => {
  return cartItems.value.every(item =>
      !item.maxStock || item.quantity <= item.maxStock
  )
})

const hasStockError = computed(() => {
  return cartItems.value.some(item =>
      item.maxStock && item.quantity > item.maxStock
  )
})

// Load stock khi component mounted
onMounted(async () => {
  await loadAllStock()
})

// Load tồn kho cho tất cả sản phẩm
const loadAllStock = async () => {
  loadingStock.value = true

  try {
    for (const item of cartItems.value) {
      await loadProductStock(item)
    }
  } catch (error) {
    console.error('Error loading stock:', error)
  } finally {
    loadingStock.value = false
  }
}

// Load tồn kho cho 1 sản phẩm
const loadProductStock = async (item) => {
  try {
    const response = await axios.get(
        `http://localhost:8080/by-product/${item.productId}`
    )

    const variants = response.data
    if (variants && variants.length > 0) {
      // Giả sử variant đầu tiên là variant đang chọn
      item.maxStock = variants[0].stock
    }
  } catch (error) {
    console.error(`Error loading stock for product ${item.productId}:`, error)
  }
}

// Tăng số lượng
const increaseQuantity = async (item) => {
  // Nếu chưa có thông tin stock, load trước
  if (!item.maxStock) {
    await loadProductStock(item)
  }

  // Kiểm tra stock trước khi tăng
  if (item.maxStock && item.quantity >= item.maxStock) {
    alert(`Sản phẩm "${item.name}" chỉ còn ${item.maxStock} trong kho`)
    return
  }

  updateQuantity(item.productId, item.quantity + 1)
}

// Giảm số lượng
const decreaseQuantity = (item) => {
  if (item.quantity > 1) {
    updateQuantity(item.productId, item.quantity - 1)
  }
}

// Format price
const formatPrice = (price) => {
  return new Intl.NumberFormat('vi-VN').format(price)
}

/**
 * CHECKOUT NAVIGATION
 */
const goToCheckout = async () => {
  if (cartItems.value.length === 0) {
    alert('Giỏ hàng của bạn đang trống!')
    return
  }

  // Kiểm tra stock lần cuối
  for (const item of cartItems.value) {
    if (item.maxStock && item.quantity > item.maxStock) {
      alert(`Sản phẩm "${item.name}" vượt quá số lượng tồn kho`)
      return
    }
  }

  try {
    const token = localStorage.getItem("token")
    const userId = localStorage.getItem("userId")

    if (!token || !userId) {
      alert("Bạn cần đăng nhập")
      router.push("/login")
      return
    }

    const payload = {
      userId: userId,
      totalAmount: cartTotal.value,
      items: cartItems.value.map(item => ({
        variantId: item.variantId,
        quantity: item.quantity
      }))
    }

    const res = await axios.post(
        "http://localhost:8080/orders",
        payload,
        {
          headers: {
            Authorization: `Bearer ${token}`
          }
        }
    )

    const orderId = res.data.orderId
    router.push(`/checkout?orderId=${orderId}`)

  } catch (error) {
    console.error(error)
    alert("Không thể tạo đơn hàng")
  }
}
</script>

<style scoped>
.pro-qty {
  position: relative;
  display: inline-block;
}

.pro-qty .qtybtn.disabled {
  opacity: 0.5;
  cursor: not-allowed;
  pointer-events: none;
}

.stock-info {
  display: block;
  margin-top: 5px;
  color: #28a745;
  font-size: 12px;
}

.stock-error {
  color: #dc3545;
  font-size: 14px;
  text-align: right;
}

.primary-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>