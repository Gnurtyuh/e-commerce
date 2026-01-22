<template>
  <!-- Humberger Menu Overlay -->
  <div class="humberger__menu__overlay" @click="closeMobileMenu"></div>
  
  <!-- Humberger Menu Wrapper -->
  <div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
      <router-link to="/" @click="closeMobileMenu">
        <img src="/img/logo.png" alt="Ogani">
      </router-link>
    </div>
    
    <div class="humberger__menu__cart">
      <ul>
        <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
        <li>
          <router-link to="/cart" @click="closeMobileMenu">
            <i class="fa fa-shopping-bag"></i> <span>{{ cartCount }}</span>
          </router-link>
        </li>
      </ul>
      <div class="header__cart__price">item: <span>${{ cartTotal.toFixed(2) }}</span></div>
    </div>
    
    <div class="humberger__menu__widget">
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
        <a href="#"><i class="fa fa-user"></i> Login</a>
      </div>
    </div>
    
    <nav class="humberger__menu__nav mobile-menu">
      <ul>
        <li :class="{ active: currentRoute === '/' }">
          <router-link to="/" @click="closeMobileMenu">Home</router-link>
        </li>
        <li :class="{ active: currentRoute === '/shop' }">
          <router-link to="/shop" @click="closeMobileMenu">Shop</router-link>
        </li>
        <li :class="{ active: currentRoute.includes('/blog') }">
          <router-link to="/blog" @click="closeMobileMenu">Blog</router-link>
        </li>
        <li :class="{ active: currentRoute === '/contact' }">
          <router-link to="/contact" @click="closeMobileMenu">Contact</router-link>
        </li>
      </ul>
    </nav>
    
    <div id="mobile-menu-wrap"></div>
    
    <div class="header__top__right__social">
      <a href="#"><i class="fa fa-facebook"></i></a>
      <a href="#"><i class="fa fa-twitter"></i></a>
      <a href="#"><i class="fa fa-linkedin"></i></a>
      <a href="#"><i class="fa fa-pinterest-p"></i></a>
    </div>
    
    <div class="humberger__menu__contact">
      <ul>
        <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
        <li>Free Shipping for all Order of $99</li>
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
  document.querySelector('.humberger__menu__wrapper')?.classList.remove('show__humberger__menu__wrapper')
  document.querySelector('.humberger__menu__overlay')?.classList.remove('active')
}
</script>
