<template>
  <footer class="footer spad">
    <div class="container">
      <div class="row">
        <!-- Giới thiệu -->
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="footer__about">
            <div class="footer__about__logo">
              <router-link to="/">
                <img src="/img/logo.png" alt="Ogani">
              </router-link>
            </div>
            <ul>
              <li>Địa chỉ: Trường Đại học Kiến Trúc Hà Nội</li>
              <li>Điện thoại: +84 337114003</li>
              <li>Email: nkocnox2004@gmail.com</li>
            </ul>
          </div>
        </div>

        <!-- Liên kết -->
        <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
          <div class="footer__widget">
            <h6>Liên kết hữu ích</h6>
            <ul>
              <li><a href="#">Về chúng tôi</a></li>
              <li><a href="#">Về cửa hàng</a></li>
              <li><a href="#">Mua sắm an toàn</a></li>
              <li><a href="#">Thông tin giao hàng</a></li>
              <li><a href="#">Chính sách bảo mật</a></li>
              <li><a href="#">Sơ đồ trang web</a></li>
            </ul>
            <ul>
              <li><a href="#">Chúng tôi là ai</a></li>
              <li><a href="#">Dịch vụ</a></li>
              <li><a href="#">Dự án</a></li>
              <li><router-link to="/contact">Liên hệ</router-link></li>
              <li><a href="#">Đổi mới</a></li>
              <li><a href="#">Đánh giá</a></li>
            </ul>
          </div>
        </div>

        <!-- Newsletter -->
        <div class="col-lg-4 col-md-12">
          <div class="footer__widget">
            <h6>Đăng ký nhận bản tin</h6>
            <p>Nhận email cập nhật sản phẩm mới và ưu đãi đặc biệt.</p>
            <form @submit.prevent="handleNewsletterSubmit">
              <input
                v-model="email"
                type="email"
                placeholder="Nhập email của bạn"
                required
              >
              <button type="submit" class="site-btn">Đăng ký</button>
            </form>
            <div class="footer__widget__social">
              <a href="#"><i class="fa fa-facebook"></i></a>
              <a href="#"><i class="fa fa-instagram"></i></a>
              <a href="#"><i class="fa fa-twitter"></i></a>
              <a href="#"><i class="fa fa-pinterest"></i></a>
            </div>
          </div>
        </div>
      </div>

      <!-- Copyright -->
      <div class="row">
        <div class="col-lg-12">
          <div class="footer__copyright">
            <div class="footer__copyright__text">
            </div>
            <div class="footer__copyright__payment">
              <img src="/img/payment-item.png" alt="Phương thức thanh toán">
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { ref, computed } from 'vue'

const email = ref('')
const currentYear = computed(() => new Date().getFullYear())

const handleNewsletterSubmit = () => {
  if (email.value) {
    alert(`Cảm ơn bạn đã đăng ký với email: ${email.value}`)
    email.value = ''
  }
}
</script>
