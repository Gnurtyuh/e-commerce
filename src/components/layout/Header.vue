<template>
  <header class="header">
    <!-- Header Top -->
    <div class="header__top">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6">
            <div class="header__top__left">
              <ul>
                <li><i class="fa fa-envelope"></i> nkocnox2004@gmail.com</li>
                <li>Miễn phí vận chuyển cho đơn hàng từ 2 triệu</li>
              </ul>
            </div>
          </div>
          <div class="col-lg-6 col-md-6">
            <div class="header__top__right">
              <div class="header__top__right__social">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-linkedin"></i></a>
                <a href="#"><i class="fa fa-pinterest-p"></i></a>
              </div>

              <div class="header__top__right__auth">
                <!-- Chưa đăng nhập -->
                <router-link v-if="!isLoggedIn" to="/login">
                  <i class="fa fa-user"></i> Đăng nhập
                </router-link>

                <!-- Đã đăng nhập -->
                <div v-else class="header__user">
                  <router-link to="/profile" class="header__user__info" :class="{ active: isProfileRoute }">
                    <i class="fa fa-user-circle"></i>
                    <span>{{ user.name }}</span>
                  </router-link>

                  <a href="#" @click.prevent="logout" class="header__logout">
                    Đăng xuất
                  </a>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Header Main -->
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="header__logo">
            <router-link to="/">
              <img src="/img/logo.png" alt="Ogani">
            </router-link>
          </div>
        </div>

        <div class="col-lg-6">
          <nav class="header__menu">
            <ul>
              <li :class="{ active: currentRoute === '/' }">
                <router-link to="/">Trang chủ</router-link>
              </li>
              <li :class="{ active: currentRoute === '/shop' }">
                <router-link to="/shop">Cửa hàng</router-link>
              </li>
              <li :class="{ active: currentRoute.includes('/blog') }">
                <router-link to="/blog">Blog</router-link>
              </li>
              <li :class="{ active: currentRoute === '/contact' }">
                <router-link to="/contact">Liên hệ</router-link>
              </li>
            </ul>
          </nav>
        </div>

        <div class="col-lg-3">
          <div class="header__cart">
            <ul>
              <li>
                <a href="#">
                  <i class="fa fa-heart"></i>
                  <span>{{ wishlistCount }}</span>
                </a>
              </li>
              <li>
                <router-link to="/cart">
                  <i class="fa fa-shopping-bag"></i>
                  <span>{{ cartCount }}</span>
                </router-link>
              </li>
            </ul>
            <div class="header__cart__price">
              Tổng tiền:
              <span>${{ cartTotal.toFixed(2) }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="humberger__open" @click="toggleMobileMenu">
        <i class="fa fa-bars"></i>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useCart } from '@/composables/useCart'

/* ================= ROUTER ================= */
const route = useRoute()
const router = useRouter()
const currentRoute = computed(() => route.path)

/* ================= CART ================= */
const { cartCount, cartTotal } = useCart()
const wishlistCount = computed(() => 1)

/* ================= AUTH ================= */
const user = ref(null)

const loadUser = () => {
  const storedUser = localStorage.getItem('user')
  user.value = storedUser ? JSON.parse(storedUser) : null
}

onMounted(() => {
  loadUser()
  window.addEventListener('auth-changed', loadUser)
})

onBeforeUnmount(() => {
  window.removeEventListener('auth-changed', loadUser)
})

const isLoggedIn = computed(() => !!user.value)

const logout = () => {
  localStorage.removeItem('user')
  localStorage.removeItem('token')
  window.dispatchEvent(new Event('auth-changed'))
  router.push('/login')
}


/* ================= MOBILE MENU ================= */
const isMobileMenuOpen = ref(false)

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value

  const menu = document.querySelector('.humberger__menu__wrapper')
  const overlay = document.querySelector('.humberger__menu__overlay')

  if (menu && overlay) {
    menu.classList.toggle(
      'show__humberger__menu__wrapper',
      isMobileMenuOpen.value
    )
    overlay.classList.toggle('active', isMobileMenuOpen.value)
  }
}
const isProfileRoute = computed(() => {
  return (
    currentRoute.value.startsWith('/profile') ||
    currentRoute.value.startsWith('/orders') ||
    currentRoute.value.startsWith('/change-password') ||
    currentRoute.value.startsWith('/address')
  )
})
</script>
