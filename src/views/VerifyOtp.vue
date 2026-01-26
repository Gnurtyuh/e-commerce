<template>
  <section class="checkout spad">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="checkout__form">
            <h4>Xác thực OTP</h4>

            <form @submit.prevent="submitOtp">
              <p>
                Chúng tôi đã gửi mã xác thực tới
                <strong>{{ email }}</strong>
              </p>

              <div class="checkout__input">
                <p>Mã OTP<span>*</span></p>
                <input
                  type="text"
                  v-model="otp"
                  placeholder="Nhập mã OTP 6 chữ số"
                  maxlength="6"
                  required
                />
              </div>

              <button type="submit" class="site-btn">
                XÁC THỰC
              </button>

              <button
                type="button"
                class="site-btn site-btn--gray"
                @click="resendOtp"
                style="margin-left: 25px;"
              >
                GỬI LẠI OTP
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const route = useRoute()

const otp = ref('')
const email = route.query.email || 'email của bạn'

const submitOtp = async () => {
  if (otp.value.length !== 6) {
    alert('Mã OTP phải gồm 6 chữ số')
    return
  }

  try {
    // Gọi API xác thực OTP
    const res = await axios.post(
      'http://localhost:8080/users/otp/verify?email=' +
        email +
        '&otp=' +
        otp.value,
      {},
      {
        headers: {
          'Content-Type': 'application/json'
        }
      }
    )

    console.log('OTP verified:', res.data)
    alert('Xác thực thành công!')

    // Chuyển sang trang đăng nhập
    await router.push('/login')

  } catch (err) {
    console.error(err.response?.data || err.message)
    alert(err.response?.data?.message || 'Xác thực OTP thất bại')
  }
}

const resendOtp = async () => {
  try {
    // Gọi API gửi lại OTP
    await axios.post(
      'http://localhost:8080/users/otp/send?email=' + email,
      {},
      {
        headers: {
          'Content-Type': 'application/json'
        }
      }
    )

    alert('OTP đã được gửi lại vào email của bạn!')

  } catch (err) {
    console.error(err.response?.data || err.message)
    alert(err.response?.data?.message || 'Gửi lại OTP thất bại')
  }
}
</script>
