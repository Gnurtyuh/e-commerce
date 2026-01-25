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
import { reactive } from "vue";
import axios from "axios";
import router from "@/router/index.js";

const form = reactive({
  email: "",
  password: ""
});

const handleLogin = async () => {
  if (!form.email || !form.password) {
    alert("Please enter email and password");
    return;
  }

  try {
    const statusRes = await axios.get(
        "http://localhost:8080/users/auth/status?email=" + form.email,
        {
          headers: {
            "Content-Type": "application/json"
          }
        }
    );
    const status = statusRes.data;
    if (status !== "ACTIVE") {
      alert("Account not activated. Please verify OTP." +status);

      // Chuyển sang trang verify OTP và truyền email qua query params
      await router.push({
        path: '/verify',
        query: {email: form.email}
      });
      try {
        // Gọi API resend OTP
        await axios.post(
            'http://localhost:8080/users/otp/send?email=' + form.email ,
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
      return;
    }
    const res = await axios.post(
        "http://localhost:8080/users/auth/login",
        {
          email: form.email,
          password: form.password
        },
        {
          headers: {
            "Content-Type": "application/json"
          }
        }
    );

    console.log("Login success:", res.data);
    localStorage.setItem("role", res.data.role);

    // ví dụ backend trả accessToken
    localStorage.setItem("token", res.data.token);

    alert("Login successful");

  } catch (err) {
    console.error(err.response?.data || err.message);
    alert("Email hoặc password không đúng "+err.response?.data?.message || "Login failed");
  }
};
</script>
