<template>
  <!-- Breadcrumb -->
  <section class="breadcrumb-section set-bg">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="breadcrumb__text">
            <h2>Đăng nhập</h2>
            <div class="breadcrumb__option">
              <router-link to="/">Trang chủ</router-link>
              <span>Đăng nhập</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Login Form -->
  <section class="checkout spad">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="checkout__form">
            <h4>Đăng nhập vào tài khoản</h4>

            <form @submit.prevent="handleLogin">
              <div class="checkout__input">
                <p>Email<span>*</span></p>
                <input
                  type="email"
                  v-model="form.email"
                  placeholder="Nhập email"
                  required
                />
              </div>

              <div class="checkout__input">
                <p>Mật khẩu<span>*</span></p>
                <input
                  type="password"
                  v-model="form.password"
                  placeholder="Nhập mật khẩu"
                  required
                />
              </div>

              <button type="submit" class="site-btn w-100">
                ĐĂNG NHẬP
              </button>

              <p class="text-center mt-3">
                Chưa có tài khoản?
                <router-link to="/register" class="text-success">
                  Đăng ký
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
    alert("Vui lòng nhập email và mật khẩu");
    return;
  }

  try {
    // Kiểm tra trạng thái tài khoản
    const statusRes = await axios.get(
      "http://localhost:8080/users/auth/status?email=" + form.email,
      {
        headers: {
          "Content-Type": "application/json"
        }
      }
    );

    const status = statusRes.data;

    // Chưa kích hoạt → chuyển sang verify OTP
    if (status !== "ACTIVE") {
      alert("Tài khoản chưa được kích hoạt. Vui lòng xác thực OTP.");

      await router.push({
        path: "/verify",
        query: { email: form.email }
      });

      try {
        await axios.post(
          "http://localhost:8080/users/otp/send?email=" + form.email,
          {},
          {
            headers: {
              "Content-Type": "application/json"
            }
          }
        );

        alert("OTP đã được gửi lại vào email của bạn!");
      } catch (err) {
        console.error(err.response?.data || err.message);
        alert( "Gửi lại OTP thất bại");
      }

      return;
    }

    // Login
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
    localStorage.setItem(
        "user",
        JSON.stringify({
          name: res.data.fullName,
          role: res.data.role
        })
    );
    localStorage.setItem("token", res.data.token);

    localStorage.setItem("email", form.email);
    window.dispatchEvent(new Event("auth-changed"));


    await router.push("/");

  } catch (err) {
    console.error(err.response?.data || err.message);
    alert(
      "Email hoặc mật khẩu không đúng"
    );
  }
};
</script>
