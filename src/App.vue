<template>
  <div>
    <!-- Page Preloader -->
    <div id="preloder" v-show="isLoading">
      <div class="loader"></div>
    </div>

    <!-- Hamburger Menu -->
    <HumbergerMenu />

    <!-- Header -->
    <Header />

    <!-- Main Content -->
    <RouterView />

    <!-- Footer -->
    <Footer />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { RouterView } from 'vue-router'
import Header from '@/components/layout/Header.vue'
import HumbergerMenu from '@/components/layout/HumbergerMenu.vue'
import Footer from '@/components/layout/Footer.vue'

const isLoading = ref(true)

onMounted(() => {
  // Hide preloader after page loads
  setTimeout(() => {
    isLoading.value = false
  }, 500)
})
</script>

<style>
/* Add any global Vue-specific styles here */
</style>
