<template>
    <section class="profile spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">

                    <div class="profile__box">
                        <h3 class="profile__title">Đổi mật khẩu</h3>

                        <div class="profile__group">
                            <label>Mật khẩu hiện tại</label>
                            <input type="password" v-model="form.oldPassword" placeholder="Nhập mật khẩu hiện tại" />
                        </div>

                        <div class="profile__group">
                            <label>Mật khẩu mới</label>
                            <input type="password" v-model="form.newPassword" placeholder="Nhập mật khẩu mới" />
                        </div>

                        <div class="profile__group">
                            <label>Xác nhận mật khẩu mới</label>
                            <input type="password" v-model="form.confirmPassword" placeholder="Nhập lại mật khẩu mới" />
                        </div>

                        <div class="profile__action">
                            <button class="site-btn" @click="changePassword">
                                Cập nhật mật khẩu
                            </button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { reactive } from 'vue'

const form = reactive({
    oldPassword: '',
    newPassword: '',
    confirmPassword: ''
})

const changePassword = () => {
    if (!form.oldPassword || !form.newPassword) {
        alert('Vui lòng nhập đầy đủ thông tin')
        return
    }

    if (form.newPassword !== form.confirmPassword) {
        alert('Mật khẩu xác nhận không khớp')
        return
    }

    console.log('Đổi mật khẩu:', form)
}
</script>
