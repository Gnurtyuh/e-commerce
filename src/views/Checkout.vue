<template>
  <div>
    <Breadcrumb title="Thanh toán" />

    <section class="checkout spad">
      <div class="container">

        <div class="checkout__form">
          <h4>Thông tin giao hàng</h4>

          <div class="row">

            <!-- LEFT -->
            <div class="col-lg-8 col-md-6">

              <div class="checkout__input">
                <p>Họ và tên</p>
                <input v-model="form.full_name" readonly>
              </div>

              <div class="checkout__input">
                <p>Số điện thoại</p>
                <input v-model="form.phone" readonly>
              </div>

              <div class="checkout__input">
                <p>Email</p>
                <input v-model="form.email" readonly>
              </div>

              <div class="checkout__input">
                <p>Địa chỉ</p>
                <input v-model="form.address" readonly>
              </div>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-4 col-md-6">

              <div class="checkout__order">

                <h4>Đơn hàng của bạn</h4>

                <div class="checkout__order__products">
                  Sản phẩm <span>Tổng</span>
                </div>

                <ul>
                  <li v-for="item in cartItems" :key="item.productId">
                    {{ item.name }} x {{ item.quantity }}
                    <span>{{ (item.price * item.quantity).toFixed(2) }} VND</span>
                  </li>
                </ul>

                <div class="checkout__order__subtotal">
                  Tạm tính
                  <span>{{ cartTotal.toFixed(2) }} VND</span>
                </div>

                <div class="checkout__order__total">
                  Tổng cộng
                  <span>{{ cartTotal.toFixed(2) }} VND</span>
                </div>

                <div class="checkout__payment">

                  <div class="checkout__input__checkbox">
                    <label>
                      Thanh toán QR ngân hàng
                      <input type="radio" checked disabled>
                      <span class="checkmark"></span>
                    </label>
                  </div>

                </div>

                <button
                    class="site-btn"
                    :disabled="loading"
                    @click="handleCheckout"
                >
                  {{ loading ? 'Đang tạo QR...' : 'QUÉT MÃ THANH TOÁN' }}
                </button>

              </div>

            </div>

          </div>

        </div>

      </div>
    </section>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter, useRoute } from 'vue-router'
import Breadcrumb from '@/components/layout/Breadcrumb.vue'
import { useCart } from '@/composables/useCart'

const router = useRouter()
const route = useRoute()

const { cartItems, cartTotal } = useCart()

const orderId = route.query.orderId

const loading = ref(false)

const form = ref({
  full_name: '',
  phone: '',
  email: '',
  address: ''
})

/* LOAD USER */
onMounted(async () => {

  const token = localStorage.getItem('token')
  const email = localStorage.getItem('email')

  if (!token || !email) {

    alert("Bạn cần đăng nhập")

    router.push("/login")

    return
  }

  try {

    const res = await axios.get(
        `http://localhost:8080/users/user/info?email=${encodeURIComponent(email)}`
    )

    const user = res.data

    form.value.full_name = user.fullName
    form.value.phone = user.phone
    form.value.email = user.email
    form.value.address = user.address

  }
  catch (error) {

    console.error(error)

  }

})

/* PAYMENT */
const handleCheckout = async () => {

  const token = localStorage.getItem("token")

  try {

    loading.value = true

    const res = await axios.post(
        `http://localhost:8080/payments/create/${orderId}`,
        {},
        {
          headers: { Authorization: `Bearer ${token}` }
        }
    )

    const checkoutUrl = res.data

    if (checkoutUrl) {

      window.location.href = checkoutUrl

    } else {

      alert("Không tạo được link thanh toán")

    }

  }
  catch (error) {

    console.error(error)

    alert("Thanh toán thất bại")

  }
  finally {

    loading.value = false

  }

}
</script>

<style scoped>

.checkout__payment{
  margin-top:20px;
}

</style>