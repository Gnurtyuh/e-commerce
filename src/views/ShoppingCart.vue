<template>
  <div>
    <Breadcrumb title="Giỏ hàng" />

    <!-- Shopping Cart Section Begin -->
    <section class="shoping-cart spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="shoping__cart__table">
              <table>
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
                      {{ item.price }}VND
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
                      {{ (item.price * item.quantity) }} VND
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

          <!-- Coupon -->
          <div class="col-lg-6">
            <div class="shoping__continue">
              <div class="shoping__discount">

              </div>
            </div>
          </div>

          <!-- Total -->
          <div class="col-lg-6">
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

              <router-link
                to="/checkout"
                class="primary-btn"
              >
                TIẾN HÀNH THANH TOÁN
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Shopping Cart Section End -->
  </div>
</template>

<script setup>
import Breadcrumb from '@/components/layout/Breadcrumb.vue'
import { useCart } from '@/composables/useCart'

const {
  cartItems,
  cartTotal,
  removeFromCart,
  updateQuantity,
  clearCart
} = useCart()
</script>
