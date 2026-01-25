<template>
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <h4>Verify OTP</h4>

                <form @submit.prevent="submitOtp">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <p>
                                We have sent a verification code to
                                <strong>{{ email }}</strong>
                            </p>

                            <div class="checkout__input">
                                <p>OTP Code<span>*</span></p>
                                <input type="text" v-model="otp" placeholder="Enter 6-digit OTP" maxlength="6"
                                    required />
                            </div>

                            <button type="submit" class="site-btn">
                                Verify
                            </button>

                            <button type="button" class="site-btn site-btn--gray" @click="resendOtp" style="margin-left: 25px;">
                                Resend OTP
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()

const otp = ref('')
const email = route.query.email || 'your email'

const submitOtp = () => {
    if (otp.value.length !== 6) {
        alert('OTP must be 6 digits')
        return
    }

    // TODO: call API verify OTP
    console.log('Verify OTP:', otp.value)

    // giả lập thành công
    router.push('/login')
}

const resendOtp = () => {
    // TODO: call API resend OTP
    alert('OTP resent!')
}
</script>
