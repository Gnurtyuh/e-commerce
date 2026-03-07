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
                                    <input v-model="user.fullName" />
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
                            <input v-model="address.receiverName " placeholder="Tên người nhận" />
                        </div>

                        <div class="profile__group">
                            <label>Số điện thoại</label>
                            <input v-model="address.phone" placeholder="Số điện thoại" />
                        </div>

                        <div class="profile__group">
                            <label>Địa chỉ chi tiết</label>
                            <input v-model="address.address"
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
import { reactive, onMounted } from 'vue'
import axios from 'axios'

const API_BASE = "http://localhost:8080"

const user = reactive({
  userId: '',
  fullName: '',
  email: '',
  phone: ''
})

const address = reactive({
  receiverName: '',
  phone: '',
  address: ''
})

/* ======================
   LOAD USER INFO
====================== */
const loadUser = async () => {
  try {

    const email = localStorage.getItem("email")

    const res = await axios.get(
        `${API_BASE}/users/user/info`,
        { params: { email } }
    )
    user.userId = res.data.userId
    user.fullName = res.data.fullName
    user.email = res.data.email
    user.phone = res.data.phone
    console.log(user.userId)
  } catch (err) {
    console.error(err)
  }
}

const loadAddress = async () => {
  try {

    const res = await axios.get(
        `${API_BASE}/users/${user.userId}/address`,

        {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`
          }
        }
  )
    // nếu không có địa chỉ
    if (!res.data) {
      console.log("Người dùng chưa có địa chỉ")
      return
    }

    address.phone = res.data.phone || ""
    address.receiverName = res.data.receiverName || ""
    address.address = res.data.address || ""

  } catch (err) {

    // nếu backend trả 404 thì coi như chưa có địa chỉ
    if (err.response && err.response.status === 404) {
      console.log("Người dùng chưa có địa chỉ")
      return
    }

    console.error("Lỗi load address:", err)
  }
}

/* ======================
   UPDATE PROFILE
====================== */
const updateProfile = async () => {
  try {

    await axios.post(
        `${API_BASE}/users/user`,
        {
          fullName: user.fullName,
          email: user.email,
          phone: user.phone
        }
    )

    alert("Cập nhật thông tin thành công")

  } catch (err) {
    console.error(err)
  }
}


/* ======================
   SAVE ADDRESS
====================== */
const saveAddress = async () => {
  try {

    const payload = {
      receiverName: address.receiverName,
      phone: address.phone,
      address: address.address,
      userId: user.userId
    }

    if (address.addressId) {

      // UPDATE
      await axios.put(
          `${API_BASE}/users/${user.userId}/address/${address.addressId}`,
          {
            ...payload,
          }
      )

      alert("Cập nhật địa chỉ thành công")

    } else {

      // CREATE
      const res = await axios.post(
          `${API_BASE}/users/${user.userId}/address`,
          {
            receiverName: address.receiverName,
            phone: address.phone,
            address: address.address,
            userId: user.userId
          }
      )

      address.addressId = res.data.addressId

      alert("Đã tạo địa chỉ")

    }

  } catch (err) {
    console.error(err)
  }
}

/* ======================
   LOAD WHEN PAGE OPEN
====================== */
onMounted(async () => {
  await loadUser()
  await loadAddress()
})
</script>
