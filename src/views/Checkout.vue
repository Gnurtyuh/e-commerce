<template>
  <div>
    <Breadcrumb title="Checkout" />

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h6><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click here</a> to enter your code</h6>
          </div>
        </div>
        <div class="checkout__form">
          <h4>Billing Details</h4>
          <form @submit.prevent="handleCheckout">
            <div class="row">
              <div class="col-lg-8 col-md-6">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="checkout__input">
                      <p>First Name<span>*</span></p>
                      <input type="text" v-model="form.firstName" required>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="checkout__input">
                      <p>Last Name<span>*</span></p>
                      <input type="text" v-model="form.lastName" required>
                    </div>
                  </div>
                </div>
                <div class="checkout__input">
                  <p>Country<span>*</span></p>
                  <input type="text" v-model="form.country" required>
                </div>
                <div class="checkout__input">
                  <p>Address<span>*</span></p>
                  <input type="text" v-model="form.address" placeholder="Street Address" class="checkout__input__add" required>
                  <input type="text" v-model="form.address2" placeholder="Apartment, suite, unit etc. (optional)">
                </div>
                <div class="checkout__input">
                  <p>Town/City<span>*</span></p>
                  <input type="text" v-model="form.city" required>
                </div>
                <div class="checkout__input">
                  <p>Country/State<span>*</span></p>
                  <input type="text" v-model="form.state" required>
                </div>
                <div class="checkout__input">
                  <p>Postcode / ZIP<span>*</span></p>
                  <input type="text" v-model="form.zip" required>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="checkout__input">
                      <p>Phone<span>*</span></p>
                      <input type="text" v-model="form.phone" required>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="checkout__input">
                      <p>Email<span>*</span></p>
                      <input type="email" v-model="form.email" required>
                    </div>
                  </div>
                </div>
                <div class="checkout__input__checkbox">
                  <label for="acc">
                    Create an account?
                    <input type="checkbox" id="acc" v-model="form.createAccount">
                    <span class="checkmark"></span>
                  </label>
                </div>
                <div class="checkout__input">
                  <p>Order notes<span>*</span></p>
                  <input type="text" v-model="form.notes" placeholder="Notes about your order, e.g. special notes for delivery.">
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="checkout__order">
                  <h4>Your Order</h4>
                  <div class="checkout__order__products">Products <span>Total</span></div>
                  <ul>
                    <li v-for="item in cartItems" :key="item.id">
                      {{ item.name }} x {{ item.quantity }} <span>${{ (item.price * item.quantity).toFixed(2) }}</span>
                    </li>
                  </ul>
                  <div class="checkout__order__subtotal">Subtotal <span>${{ cartTotal.toFixed(2) }}</span></div>
                  <div class="checkout__order__total">Total <span>${{ cartTotal.toFixed(2) }}</span></div>
                  <button type="submit" class="site-btn">PLACE ORDER</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
    <!-- Checkout Section End -->
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import Breadcrumb from '@/components/layout/Breadcrumb.vue'
import { useCart } from '@/composables/useCart'

const router = useRouter()
const { cartItems, cartTotal, clearCart } = useCart()

const form = ref({
  firstName: '',
  lastName: '',
  country: '',
  address: '',
  address2: '',
  city: '',
  state: '',
  zip: '',
  phone: '',
  email: '',
  createAccount: false,
  notes: ''
})

const handleCheckout = () => {
  alert('Order placed successfully!')
  clearCart()
  router.push('/')
}
</script>
