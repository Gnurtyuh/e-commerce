<template>
    <section class="breadcrumb-section set-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Register</h2>
                        <div class="breadcrumb__option">
                            <router-link to="/">Home</router-link>
                            <span>Register</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="checkout spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="checkout__form">
                        <h4>Create an account</h4>

                        <form @submit.prevent="handleRegister">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>First Name<span>*</span></p>
                                        <input type="text" v-model="form.firstName" required />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Last Name<span>*</span></p>
                                        <input type="text" v-model="form.lastName" required />
                                    </div>
                                </div>
                            </div>

                            <div class="checkout__input">
                                <p>Email<span>*</span></p>
                                <input type="email" v-model="form.email" required />
                            </div>

                            <div class="checkout__input">
                                <p>Password<span>*</span></p>
                                <input type="password" v-model="form.password" required />
                            </div>

                            <div class="checkout__input">
                                <p>Confirm Password<span>*</span></p>
                                <input type="password" v-model="form.confirmPassword" required />
                            </div>

                            <button type="submit" class="site-btn w-100">
                                REGISTER
                            </button>

                            <p class="text-center mt-3">
                                Already have an account?
                                <router-link to="/login" class="text-success">
                                    Login
                                </router-link>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { reactive } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const form = reactive({
    firstName: '',
    lastName: '',
    email: '',
    password: '',
    confirmPassword: ''
})

const handleRegister = async () => {
    if (!form.email || !form.password) {
        alert('Please fill all required fields')
        return
    }

    if (form.password !== form.confirmPassword) {
        alert('Passwords do not match')
        return
    }

    try {
        // 🔥 MOCK API REGISTER
        console.log('Register data:', form)

        // giả lập gửi OTP thành công
        setTimeout(() => {
            router.push({
                path: '/verify-otp',
                query: { email: form.email }
            })
        }, 500)

    } catch (error) {
        console.error(error)
        alert('Register failed')
    }
}
</script>
