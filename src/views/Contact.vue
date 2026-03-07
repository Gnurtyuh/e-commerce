<template>
  <div>
    <Breadcrumb title="Liên hệ" />

    <!-- Contact Section Begin -->
    <section class="contact spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-6 text-center">
            <div class="contact__widget">
              <span class="icon_phone"></span>
              <h4>Điện thoại</h4>
              <p>+84 356 998 469</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 text-center">
            <div class="contact__widget">
              <span class="icon_pin_alt"></span>
              <h4>Địa chỉ</h4>
              <p>Trường Đại học Kiến Trúc Hà Nội</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 text-center">
            <div class="contact__widget">
              <span class="icon_clock_alt"></span>
              <h4>Giờ làm việc</h4>
              <p>10:00 sáng – 23:00 tối</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 text-center">
            <div class="contact__widget">
              <span class="icon_mail_alt"></span>
              <h4>Email</h4>
              <p>nkocnox2004@gmail.com</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Contact Section End -->

    <!-- Contact Form Begin -->
    <div class="contact-form spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="contact__form__title">
              <h2>Gửi lời nhắn cho chúng tôi</h2>
            </div>
          </div>
        </div>

        <form @submit.prevent="handleSubmit">
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <input
                v-model="form.name"
                type="text"
                placeholder="Họ và tên"
                required
              >
            </div>

            <div class="col-lg-6 col-md-6">
              <input
                v-model="form.email"
                type="email"
                placeholder="Email của bạn"
                required
              >
            </div>

            <div class="col-lg-12 text-center">
              <textarea
                v-model="form.message"
                placeholder="Nội dung tin nhắn"
                required
              ></textarea>

              <button type="submit" class="site-btn">
                GỬI TIN NHẮN
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Contact Form End -->
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Breadcrumb from '@/components/layout/Breadcrumb.vue'

const form = ref({
  name: '',
  email: '',
  message: ''
})

const handleSubmit = () => {
  alert('Gửi tin nhắn thành công!')
  form.value = {
    name: '',
    email: '',
    message: ''
  }
}
</script>
