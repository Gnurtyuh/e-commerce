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
                <li>Free Shipping for all Order of 99$</li>
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
              <div class="header__top__right__language">
                <img src="/img/language.png" alt="">
                <div>English</div>
                <span class="arrow_carrot-down"></span>
                <ul>
                  <li><a href="#">Spanish</a></li>
                  <li><a href="#">English</a></li>
                </ul>
              </div>
              <div class="header__top__right__auth">
                <!-- Chưa login -->
                <router-link v-if="!isLoggedIn" to="/login">
                  <i class="fa fa-user"></i> Login
                </router-link>

                <!-- Đã login -->
                <div v-else class="d-flex align-items-center">
                  <i class="fa fa-user-circle mr-2"></i>
                  <span class="mr-2">{{ user.name }}</span>
                  <a href="#" @click.prevent="logout" class="text-danger">
                    Logout
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
            <router-link to="/"><img src="/img/logo.png" alt="Ogani"></router-link>
          </div>
        </div>
        <div class="col-lg-6">
          <nav class="header__menu">
            <ul>
              <li :class="{ active: currentRoute === '/' }">
                <router-link to="/">Home</router-link>
              </li>
              <li :class="{ active: currentRoute === '/shop' }">
                <router-link to="/shop">Shop</router-link>
              </li>
              <li :class="{ active: currentRoute.includes('/blog') }">
                <router-link to="/blog">Blog</router-link>
              </li>
              <li :class="{ active: currentRoute === '/contact' }">
                <router-link to="/contact">Contact</router-link>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-lg-3">
          <div class="header__cart">
            <ul>
              <li><a href="#"><i class="fa fa-heart"></i> <span>{{ wishlistCount }}</span></a></li>
              <li>
                <router-link to="/cart">
                  <i class="fa fa-shopping-bag"></i> <span>{{ cartCount }}</span>
                </router-link>
              </li>
            </ul>
            <div class="header__cart__price">item: <span>${{ cartTotal.toFixed(2) }}</span></div>
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
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useCart } from '@/composables/useCart'

/* ================= ROUTER ================= */
const route = useRoute()
const router = useRouter()
const currentRoute = computed(() => route.path)

/* ================= CART ================= */
const { cartCount, cartTotal } = useCart()
const wishlistCount = computed(() => 1) // TODO: replace bằng wishlist store

/* ================= AUTH ================= */
const user = ref(null)

onMounted(() => {
  const storedUser = localStorage.getItem('user')
  if (storedUser) {
    user.value = JSON.parse(storedUser)
  }
})

const isLoggedIn = computed(() => !!user.value)

const logout = () => {
  localStorage.removeItem('user')
  user.value = null
  router.push('/login')
}

/* ================= MOBILE MENU ================= */
const isMobileMenuOpen = ref(false)

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value

  const menu = document.querySelector('.humberger__menu__wrapper')
  const overlay = document.querySelector('.humberger__menu__overlay')

  if (menu && overlay) {
    menu.classList.toggle('show__humberger__menu__wrapper', isMobileMenuOpen.value)
    overlay.classList.toggle('active', isMobileMenuOpen.value)
  }
}
</script>
