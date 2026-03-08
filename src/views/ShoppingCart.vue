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
                      {{ item.price }} VND
                    </td>

                    <td class="shoping__cart__quantity">
                      <div class="quantity">
                        <div class="pro-qty">

                          <span
                            class="dec qtybtn"
                            @click="updateQuantity(item.productId, item.quantity - 1)"
                          >-</span>

                          <input
                            type="text"
                            :value="item.quantity"
                            readonly
                          >

                          <span
                            class="inc qtybtn"
                            @click="updateQuantity(item.productId, item.quantity + 1)"
                          >+</span>

                        </div>
                      </div>
                    </td>

                    <td class="shoping__cart__total">
                      {{ item.price * item.quantity }} VND
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
                  <span>{{ cartTotal }} VND</span>
                </li>

                <li>
                  Tổng cộng
                  <span>{{ cartTotal }} VND</span>
                </li>
              </ul>

              <!-- CHECKOUT BUTTON -->
              <button
                class="primary-btn"
                :disabled="cartItems.length === 0"
                @click="goToCheckout"
              >
                TIẾN HÀNH THANH TOÁN
              </button>

            </div>

          </div>

        </div>
      </div>
    </section>
    <!-- Shopping Cart Section End -->
  </div>
</template>



<script setup>
import { useRouter } from 'vue-router'
import Breadcrumb from '@/components/layout/Breadcrumb.vue'
import { useCart } from '@/composables/useCart'

const router = useRouter()

const {
  cartItems,
  cartTotal,
  removeFromCart,
  updateQuantity,
  clearCart
} = useCart()


/**
 * CHECKOUT NAVIGATION
 */

const goToCheckout = () => {

  if (cartItems.value.length === 0) {

    alert('Giỏ hàng của bạn đang trống!')

    return
  }

  router.push('/checkout')

}
</script>