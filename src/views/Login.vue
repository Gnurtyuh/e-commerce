<template>
    <section class="breadcrumb-section set-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Login</h2>
                        <div class="breadcrumb__option">
                            <router-link to="/">Home</router-link>
                            <span>Login</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="checkout spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="checkout__form">
                        <h4>Login to your account</h4>

                        <form @submit.prevent="handleLogin">
                            <div class="checkout__input">
                                <p>Email<span>*</span></p>
                                <input type="email" v-model="form.email" required />
                            </div>

                            <div class="checkout__input">
                                <p>Password<span>*</span></p>
                                <input type="password" v-model="form.password" required />
                            </div>

                            <button type="submit" class="site-btn w-100">
                                LOGIN
                            </button>

                            <p class="text-center mt-3">
                                Don’t have an account?
                                <router-link to="/register" class="text-success">
                                    Register
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

const form = reactive({
    email: '',
    password: ''
})

const handleLogin = () => {
    console.log('Login data:', form)
    // gọi API sau
}
</script>
