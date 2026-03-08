<template>
  <div>
    <Breadcrumb title="Thanh toán" />

    <section class="checkout spad">
      <div class="container">

        <div class="checkout__form">
          <h4>Thông tin giao hàng</h4>

          <form @submit.prevent="handleCheckout">
            <div class="row">

              <!-- LEFT -->
              <div class="col-lg-8 col-md-6">

                <div class="checkout__input__checkbox">
                  <label>
                    <input type="radio" value="default" v-model="addressMode" @change="useDefaultAddress">
                    Sử dụng địa chỉ mặc định
                    <span class="checkmark"></span>
                  </label>

                  <label style="margin-left:20px">
                    <input type="radio" value="new" v-model="addressMode" @change="useNewAddress">
                    Nhập địa chỉ mới
                    <span class="checkmark"></span>
                  </label>
                </div>

                <div class="checkout__input">
                  <p>Họ và tên<span>*</span></p>
                  <input v-model="form.full_name" :readonly="addressMode === 'default'" required>
                </div>

                <div class="checkout__input">
                  <p>Số điện thoại<span>*</span></p>
                  <input v-model="form.phone" :readonly="addressMode === 'default'" required>
                </div>

                <div class="checkout__input">
                  <p>Email<span>*</span></p>
                  <input type="email" v-model="form.email" required>
                </div>

                <!-- <div class="checkout__input">
                  <p>Tỉnh / Thành phố<span>*</span></p>
                  <input v-model="form.city" required>
                </div> -->

                <div class="checkout__input">
                  <p>Địa chỉ chi tiết<span>*</span></p>
                  <input v-model="form.address" :readonly="addressMode === 'default'" required>
                </div>

                <button type="button" class="site-btn confirm-btn" @click="confirmShipping">
                  Xác nhận thông tin
                </button>

                <div class="checkout__input">
                  <p>Ghi chú đơn hàng</p>
                  <input v-model="form.notes" placeholder="Ví dụ: gọi trước khi giao">
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
                    <li v-for="item in cartItems" :key="item.id">
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
                        Chuyển khoản ngân hàng
                        <input type="radio" value="bank" v-model="form.paymentMethod">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="checkout__input__checkbox">
                      <label>
                        Thanh toán khi nhận hàng
                        <input type="radio" value="cod" v-model="form.paymentMethod">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                  </div>


                  <div v-if="qrPayment" class="qr-box">

                    <h5>Quét QR để thanh toán</h5>

                    <img :src="qrPayment.qrCode" width="220">

                    <p>
                      Số tiền:
                      <b>{{ qrPayment.amount.toLocaleString() }}đ</b>
                    </p>

                    <p>
                      Nội dung:
                      <b>{{ qrPayment.content }}</b>
                    </p>

                    <p v-if="checkingPayment">
                      Đang chờ thanh toán...
                    </p>

                  </div>


                  <button type="submit" class="site-btn" :disabled="loading">
                    {{ loading ? 'Đang xử lý...' : 'ĐẶT HÀNG' }}
                  </button>

                </div>

              </div>

            </div>
          </form>

        </div>

      </div>
    </section>

  </div>
</template>



<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import Breadcrumb from '@/components/layout/Breadcrumb.vue'
import { useCart } from '@/composables/useCart'

const router = useRouter()
const { cartItems, cartTotal, clearCart } = useCart()

const loading = ref(false)
const qrPayment = ref(null)
const checkingPayment = ref(false)

const user = ref(null)
const addresses = ref([])
const defaultAddress = ref(null)

const addressMode = ref('default')

const form = ref({
  full_name: '',
  phone: '',
  email: '',
  address: '',
  city: '',
  notes: '',
  paymentMethod: 'cod'
})



/**
 * LOAD USER + ADDRESS
 */

onMounted(async () => {

  try {

    const email = localStorage.getItem('email')

    if (!email) {
      console.error("Email không tồn tại trong localStorage")
      return
    }

    // encode email
    const encodedEmail = encodeURIComponent(email)

    /**
     * STEP 1: GET USER INFO
     */

    const userRes = await axios.get(
      `http://localhost:8080/users/user/info?email=${encodedEmail}`
    )

    user.value = userRes.data


    /**
     * STEP 2: GET ADDRESS BY USER ID
     */

    const addressRes = await axios.get(
      `http://localhost:8080/users/${user.value.userId}/address`
    )

    let data = addressRes.data

    // Fix crash .find()
    if (Array.isArray(data)) {
      addresses.value = data
    } else if (data) {
      addresses.value = [data]
    } else {
      addresses.value = []
    }

    /**
     * FIND DEFAULT ADDRESS
     */

    defaultAddress.value =
      addresses.value.find(a => a.isDefault === true)

    if (defaultAddress.value) {
      useDefaultAddress()
    }

  }

  catch (error) {

    console.error("Load user error:", error)

  }

})



/**
 * USE DEFAULT ADDRESS
 */

const useDefaultAddress = () => {

  if (!defaultAddress.value || !user.value) return

  form.value.full_name = defaultAddress.value.receiverName
  form.value.phone = defaultAddress.value.phone
  form.value.address = defaultAddress.value.address
  form.value.email = user.value.email

}



/**
 * NEW ADDRESS
 */

const useNewAddress = () => {

  if (!user.value) return

  form.value.full_name = ''
  form.value.phone = ''
  form.value.address = ''
  form.value.city = ''
  form.value.email = ''

}



/**
 * CONFIRM SHIPPING
 */

const confirmShipping = () => {
  alert('Thông tin giao hàng đã được xác nhận!')
}



/**
 * CHECKOUT
 */

const handleCheckout = async () => {

  if (!cartItems.value.length) {
    alert('Giỏ hàng trống!')
    return
  }

  try {

    loading.value = true

    const payload = {
      customer: form.value,
      products: cartItems.value,
      total: cartTotal.value,
      payment_method: form.value.paymentMethod
    }

    if (form.value.paymentMethod === 'cod') {

      await fakeApi('/api/orders', payload)

      alert('Đặt hàng thành công')

      clearCart()

      router.push('/cart')

      return
    }

    const res = await fakeApi('/api/payment/create', payload)

    qrPayment.value = res

    startCheckingPayment(res.orderId)

  }

  catch (error) {

    alert('Thanh toán thất bại')

  }

  finally {

    loading.value = false

  }

}



/**
 * CHECK PAYMENT
 */

const startCheckingPayment = (orderId) => {

  checkingPayment.value = true

  const interval = setInterval(async () => {

    const res = await fakeApi(`/api/payment/status/${orderId}`)

    if (res.status === 'paid') {

      clearInterval(interval)

      alert('Thanh toán thành công')

      clearCart()

      router.push('/cart')

    }

  }, 5000)

}



/**
 * FAKE API PAYMENT
 */

const fakeApi = (url, data = null) => {

  return new Promise(resolve => {

    setTimeout(() => {

      if (url === '/api/payment/create') {

        const orderId = 'ORD' + Date.now()

        resolve({
          orderId,
          amount: cartTotal.value,
          content: orderId,
          qrCode: 'https://img.vietqr.io/image/vcb-12345678-compact.png'
        })

      }

      else if (url.includes('/api/payment/status')) {

        resolve({
          status: Math.random() > 0.7 ? 'paid' : 'pending'
        })

      }

      else {

        resolve({ success: true })

      }

    }, 1200)

  })

}
</script>



<style scoped>

.confirm-btn{
  margin-bottom:20px;
}

.checkout__payment{
  margin-top:20px;
}

.qr-box{
  margin-top:20px;
  text-align:center;
}

.qr-box img{
  margin:15px 0;
}

</style>