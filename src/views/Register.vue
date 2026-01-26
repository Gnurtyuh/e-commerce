<template>
    <!-- Breadcrumb -->
    <section class="breadcrumb-section set-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Đăng ký</h2>
                        <div class="breadcrumb__option">
                            <router-link to="/">Trang chủ</router-link>
                            <span>Đăng ký</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Register Form -->
    <section class="checkout spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="checkout__form">
                        <h4>Tạo tài khoản mới</h4>

                        <form @submit.prevent="handleRegister">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Họ<span>*</span></p>
                                        <input type="text" v-model="form.firstName" placeholder="Nhập họ" required />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Tên<span>*</span></p>
                                        <input type="text" v-model="form.lastName" placeholder="Nhập tên" required />
                                    </div>
                                </div>
                            </div>

                            <div class="checkout__input">
                                <p>Email<span>*</span></p>
                                <input type="email" v-model="form.email" placeholder="Nhập email" required />
                            </div>

                            <div class="checkout__input">
                                <p>Số điện thoại<span>*</span></p>
                                <input type="text" v-model="form.phone" placeholder="Nhập số điện thoại" required />
                            </div>

                            <div class="checkout__input">
                                <p>Mật khẩu<span>*</span></p>
                                <input type="password" v-model="form.password" placeholder="Nhập mật khẩu" required />
                            </div>

                            <div class="checkout__input">
                                <p>Xác nhận mật khẩu<span>*</span></p>
                                <input type="password" v-model="form.confirmPassword" placeholder="Nhập lại mật khẩu"
                                    required />
                            </div>

                            <button type="submit" class="site-btn w-100">
                                ĐĂNG KÝ
                            </button>

                            <p class="text-center mt-3">
                                Đã có tài khoản?
                                <router-link to="/login" class="text-success">
                                    Đăng nhập
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
import { useRouter } from "vue-router";
import axios from "axios";

const router = useRouter();

const form = reactive({
    firstName: "",
    lastName: "",
    email: "",
    password: "",
    confirmPassword: "",
    phone: ""
});

const handleRegister = async () => {
    if (
        !form.firstName ||
        !form.lastName ||
        !form.email ||
        !form.password ||
        !form.confirmPassword ||
        !form.phone
    ) {
        alert("Vui lòng nhập đầy đủ các trường bắt buộc");
        return;
    }

    if (form.password !== form.confirmPassword) {
        alert("Mật khẩu xác nhận không khớp");
        return;
    }

    try {
        const res = await axios.post(
            "http://localhost:8080/users/auth/register",
            {
                email: form.email,
                password: form.password,
                phone: form.phone,
                fullName: `${form.firstName} ${form.lastName}`
            },
            {
                headers: {
                    "Content-Type": "application/json"
                }
            }
        );

        console.log("Register success:", res.data);
        alert("Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản.");

        // Chuyển sang trang verify OTP
        await router.push({
            path: "/verify",
            query: { email: form.email }
        });

        // Gửi lại OTP
        await axios.post(
            "http://localhost:8080/users/otp/send?email=" + form.email,
            {},
            {
                headers: {
                    "Content-Type": "application/json"
                }
            }
        );

        alert("OTP đã được gửi tới email của bạn!");

    } catch (err) {
        console.error(err.response?.data || err.message);
        alert(err.response?.data?.message || "Đăng ký thất bại");
    }
};
</script>
