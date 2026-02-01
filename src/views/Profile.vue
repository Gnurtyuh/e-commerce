<template>
    <section class="profile spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <!-- THÔNG TIN NGƯỜI DÙNG -->
                    <div class="profile__box">
                        <h3 class="profile__title">Thông tin người dùng</h3>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="profile__group">
                                    <label>Họ và tên</label>
                                    <input v-model="user.name" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="profile__group">
                                    <label>Email</label>
                                    <input v-model="user.email" disabled />
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="profile__group">
                                    <label>Số điện thoại</label>
                                    <input v-model="user.phone" />
                                </div>
                            </div>
                        </div>

                        <div class="profile__action">
                            <button class="site-btn" @click="updateProfile">
                                Cập nhật thông tin
                            </button>
                        </div>
                    </div>

                    <!-- ĐỊA CHỈ GIAO HÀNG -->
                    <div class="profile__box mt-4">
                        <h3 class="profile__title">Địa chỉ giao hàng</h3>

                        <div class="profile__group">
                            <label>Tên người nhận</label>
                            <input v-model="address.name" placeholder="Tên người nhận" />
                        </div>

                        <div class="profile__group">
                            <label>Số điện thoại</label>
                            <input v-model="address.phone" placeholder="Số điện thoại" />
                        </div>

                        <div class="profile__group">
                            <label>Địa chỉ chi tiết</label>
                            <input v-model="address.detail"
                                placeholder="Số nhà, phường/xã, quận/huyện, tỉnh/thành phố" />
                        </div>

                        <div class="profile__action">
                            <button class="site-btn" @click="saveAddress">
                                Lưu địa chỉ
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

const user = reactive({
    name: 'Nguyễn Văn A',
    email: 'test@gmail.com',
    phone: ''
})

const address = reactive({
    name: '',
    phone: '',
    detail: ''
})

const updateProfile = () => {
    console.log('Cập nhật thông tin người dùng:', user)
}

const saveAddress = () => {
    console.log('Lưu địa chỉ giao hàng:', address)
}
</script>
