<template>
  <div>
    <Breadcrumb title="Shopping Cart" />

    <!-- Shopping Cart Section Begin -->
    <section class="shoping-cart spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="shoping__cart__table">
              <table>
                <thead>
                  <tr>
                    <th class="shoping__product">Products</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in cartItems" :key="item.id">
                    <td class="shoping__cart__item">
                      <img :src="item.image" :alt="item.name" style="width: 100px;">
                      <h5>{{ item.name }}</h5>
                    </td>
                    <td class="shoping__cart__price">
                      ${{ item.price.toFixed(2) }}
                    </td>
                    <td class="shoping__cart__quantity">
                      <div class="quantity">
                        <div class="pro-qty">
                          <span class="dec qtybtn" @click="updateQuantity(item.id, item.quantity - 1)">-</span>
                          <input type="text" :value="item.quantity" readonly>
                          <span class="inc qtybtn" @click="updateQuantity(item.id, item.quantity + 1)">+</span>
                        </div>
                      </div>
                    </td>
                    <td class="shoping__cart__total">
                      ${{ (item.price * item.quantity).toFixed(2) }}
                    </td>
                    <td class="shoping__cart__item__close">
                      <span class="icon_close" @click="removeFromCart(item.id)"></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="shoping__cart__btns">
              <router-link to="/shop" class="primary-btn cart-btn">CONTINUE SHOPPING</router-link>
              <a href="#" class="primary-btn cart-btn cart-btn-right" @click.prevent="clearCart">
                <span class="icon_close"></span> Clear Cart
              </a>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="shoping__continue">
              <div class="shoping__discount">
                <h5>Discount Codes</h5>
                <form @submit.prevent>
                  <input type="text" placeholder="Enter your coupon code">
                  <button type="submit" class="site-btn">APPLY COUPON</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="shoping__checkout">
              <h5>Cart Total</h5>
              <ul>
                <li>Subtotal <span>${{ cartTotal.toFixed(2) }}</span></li>
                <li>Total <span>${{ cartTotal.toFixed(2) }}</span></li>
              </ul>
              <router-link to="/checkout" class="primary-btn">PROCEED TO CHECKOUT</router-link>
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

const { cartItems, cartTotal, removeFromCart, updateQuantity, clearCart } = useCart()
</script>
