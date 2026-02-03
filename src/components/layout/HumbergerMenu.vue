<template>
  <!-- Overlay -->
  <div class="humberger__menu__overlay" @click="closeMobileMenu"></div>

  <!-- Wrapper -->
  <div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
      <router-link to="/" @click="closeMobileMenu">
        <img src="/img/logo.png" alt="Ogani">
      </router-link>
    </div>

    <!-- Cart -->
    <div class="humberger__menu__cart">
      <ul>
        <li>
          <router-link to="/cart" @click="closeMobileMenu">
            <i class="fa fa-shopping-bag"></i>
            <span>{{ cartCount }}</span>
          </router-link>
        </li>
      </ul>
    </div>

    <!-- Widget -->
    <div class="humberger__menu__widget">

      <div class="header__top__right__auth">
        <router-link to="/login" @click="closeMobileMenu">
          <i class="fa fa-user"></i> Đăng nhập
        </router-link>
      </div>
    </div>

    <!-- Menu -->
    <nav class="humberger__menu__nav mobile-menu">
      <ul>
        <li :class="{ active: currentRoute === '/' }">
          <router-link to="/" @click="closeMobileMenu">
            Trang chủ
          </router-link>
        </li>
        <li :class="{ active: currentRoute === '/shop' }">
          <router-link to="/shop" @click="closeMobileMenu">
            Cửa hàng
          </router-link>
        </li>
        <li :class="{ active: currentRoute.includes('/blog') }">
          <router-link to="/blog" @click="closeMobileMenu">
            Blog
          </router-link>
        </li>
        <li :class="{ active: currentRoute === '/contact' }">
          <router-link to="/contact" @click="closeMobileMenu">
            Liên hệ
          </router-link>
        </li>
      </ul>
    </nav>

    <div id="mobile-menu-wrap"></div>

    <!-- Social -->
    <div class="header__top__right__social">
      <a href="#"><i class="fa fa-facebook"></i></a>
      <a href="#"><i class="fa fa-twitter"></i></a>
      <a href="#"><i class="fa fa-linkedin"></i></a>
      <a href="#"><i class="fa fa-pinterest-p"></i></a>
    </div>

    <!-- Contact -->
    <div class="humberger__menu__contact">
      <ul>
        <li>
          <i class="fa fa-envelope"></i> hello@colorlib.com
        </li>
        <li>
          Miễn phí vận chuyển cho đơn hàng từ $99
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import { useCart } from '@/composables/useCart'

const route = useRoute()
const { cartCount, cartTotal } = useCart()

const currentRoute = computed(() => route.path)

const closeMobileMenu = () => {
  document
    .querySelector('.humberger__menu__wrapper')
    ?.classList.remove('show__humberger__menu__wrapper')

  document
    .querySelector('.humberger__menu__overlay')
    ?.classList.remove('active')
}
</script>
