<template>
  <section class="breadcrumb-section set-bg" :data-setbg="backgroundImage">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="breadcrumb__text">
            <h2>{{ title }}</h2>
            <div class="breadcrumb__option">
              <router-link to="/">Trang chủ</router-link>
              <span>{{ title }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { onMounted } from 'vue'

defineProps({
  title: {
    type: String,
    required: true
  },
  backgroundImage: {
    type: String,
    default: '/img/breadcrumb.jpg'
  }
})

onMounted(() => {
  // Set background image using jQuery-like approach
  const bgElement = document.querySelector('.breadcrumb-section.set-bg')
  if (bgElement) {
    const bg = bgElement.getAttribute('data-setbg')
    if (bg) {
      bgElement.style.backgroundImage = `url(${bg})`
    }
  }
})
</script>
