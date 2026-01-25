<template>
  <section class="checkout spad">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="checkout__form">
            <h4>Verify OTP</h4>

            <form @submit.prevent="submitOtp">
              <p>
                We have sent a verification code to
                <strong>{{ email }}</strong>
              </p>

              <div class="checkout__input">
                <p>OTP Code<span>*</span></p>
                <input
                    type="text"
                    v-model="otp"
                    placeholder="Enter 6-digit OTP"
                    maxlength="6"
                    required
                />
              </div>

              <button type="submit" class="site-btn">
                Verify
              </button>

              <button
                  type="button"
                  class="site-btn site-btn--gray"
                  @click="resendOtp"
                  style="margin-left: 25px;"
              >
                Resend OTP
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const route = useRoute();

const otp = ref('');
const email = route.query.email || 'your email';

const submitOtp = async () => {
  if (otp.value.length !== 6) {
    alert('OTP must be 6 digits');
    return;
  }

  try {
    // Gọi API verify OTP
    const res = await axios.post(
        'http://localhost:8080/users/otp/verify?email=' + email + '&otp=' + otp.value,
        {
          headers: {
            'Content-Type': 'application/json',
          }
        }
    );

    console.log('OTP verified:', res.data);
    alert('Verification successful!');

    // Chuyển sang trang login
    await router.push('/login');

  } catch (err) {
    console.error(err.response?.data || err.message);
    alert(err.response?.data?.message || 'OTP verification failed');
  }
};

const resendOtp = async () => {
  try {
    // Gọi API resend OTP
    await axios.post(
        'http://localhost:8080/users/otp/send?email=' + email ,
        {
          headers: {
            'Content-Type': 'application/json',
          }
        }
    );

    alert('OTP has been resent to your email!');

  } catch (err) {
    console.error(err.response?.data || err.message);
    alert(err.response?.data?.message || 'Failed to resend OTP');
  }
};
</script>