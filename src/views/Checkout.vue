<template>
  <div>
    <Breadcrumb title="Thanh toán" />

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h6>
              <span class="icon_tag_alt"></span>
              Có mã giảm giá?
              <a href="#">Nhấn vào đây</a> để nhập mã
            </h6>
          </div>
        </div>

        <div class="checkout__form">
          <h4>Thông tin thanh toán</h4>

          <form @submit.prevent="handleCheckout">
            <div class="row">
              <!-- Thông tin khách hàng -->
              <div class="col-lg-8 col-md-6">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="checkout__input">
                      <p>Họ<span>*</span></p>
                      <input type="text" v-model="form.firstName" required>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="checkout__input">
                      <p>Tên<span>*</span></p>
                      <input type="text" v-model="form.lastName" required>
                    </div>
                  </div>
                </div>

                <div class="checkout__input">
                  <p>Quốc gia<span>*</span></p>
                  <input type="text" v-model="form.country" required>
                </div>

                <div class="checkout__input">
                  <p>Địa chỉ<span>*</span></p>
                  <input
                    type="text"
                    v-model="form.address"
                    placeholder="Địa chỉ đường"
                    class="checkout__input__add"
                    required
                  >
                  <input
                    type="text"
                    v-model="form.address2"
                    placeholder="Căn hộ, phòng, v.v. (không bắt buộc)"
                  >
                </div>

                <div class="checkout__input">
                  <p>Thành phố<span>*</span></p>
                  <input type="text" v-model="form.city" required>
                </div>

                <div class="checkout__input">
                  <p>Tỉnh / Bang<span>*</span></p>
                  <input type="text" v-model="form.state" required>
                </div>

                <div class="checkout__input">
                  <p>Mã bưu điện / ZIP<span>*</span></p>
                  <input type="text" v-model="form.zip" required>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="checkout__input">
                      <p>Số điện thoại<span>*</span></p>
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
                    Tạo tài khoản?
                    <input type="checkbox" id="acc" v-model="form.createAccount">
                    <span class="checkmark"></span>
                  </label>
                </div>

                <div class="checkout__input">
                  <p>Ghi chú đơn hàng</p>
                  <input
                    type="text"
                    v-model="form.notes"
                    placeholder="Ghi chú cho đơn hàng, ví dụ: lưu ý khi giao hàng."
                  >
                </div>
              </div>

              <!-- Đơn hàng -->
              <div class="col-lg-4 col-md-6">
                <div class="checkout__order">
                  <h4>Đơn hàng của bạn</h4>
                  <div class="checkout__order__products">
                    Sản phẩm <span>Tổng</span>
                  </div>

                  <ul>
                    <li v-for="item in cartItems" :key="item.id">
                      {{ item.name }} x {{ item.quantity }}
                      <span>${{ (item.price * item.quantity).toFixed(2) }}</span>
                    </li>
                  </ul>

                  <div class="checkout__order__subtotal">
                    Tạm tính <span>${{ cartTotal.toFixed(2) }}</span>
                  </div>

                  <div class="checkout__order__total">
                    Tổng cộng <span>${{ cartTotal.toFixed(2) }}</span>
                  </div>

                  <button type="submit" class="site-btn">
                    ĐẶT HÀNG
                  </button>
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
  alert('Đặt hàng thành công!')
  clearCart()
  router.push('/')
}
</script>
