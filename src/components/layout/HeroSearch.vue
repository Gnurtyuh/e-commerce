<template>
  <section :class="normal ? 'hero hero-normal' : 'hero'">
    <div class="container">
      <div class="row">

        <!-- DANH MỤC -->
        <div class="col-lg-3">
          <div class="hero__categories">
            <div
              class="hero__categories__all"
              @click="toggleDropdown"
            >
              <i class="fa fa-bars"></i>
              <span>Tất cả danh mục</span>
            </div>

            <transition name="slide">
              <ul v-show="isOpen">
                <li>
                  <a href="#" @click.prevent="goAll">
                    Tất cả
                  </a>
                </li>
                <li
                  v-for="cat in categories"
                  :key="cat.categoryId"
                >
                  <a
                    href="#"
                    @click.prevent="goCategory(cat.categoryId)"
                  >
                    {{ cat.name }}
                  </a>
                </li>
              </ul>
            </transition>
          </div>
        </div>

        <!-- SEARCH -->
        <div class="col-lg-9">
          <div class="hero__search">
            <div class="hero__search__form">
              <form @submit.prevent="handleSearch">
                <input
                  v-model="keyword"
                  type="text"
                  placeholder="Bạn đang tìm sản phẩm gì?"
                />
                <button type="submit" class="site-btn">
                  TÌM KIẾM
                </button>
              </form>
            </div>
          </div>
          <!-- Banner chỉ hiện ở Home -->
          <div
            v-if="!normal"
            class="hero__item"
            style="background-image: url('/img/hero/banner.jpg')"
          >
            <div class="hero__text">
              <span>TRÁI CÂY TƯƠI</span>
              <h2>Rau củ <br />100% hữu cơ</h2>
              <p>Miễn phí giao hàng cho đơn từ 2 triệu</p>
              <router-link to="/shop" class="primary-btn">
                MUA NGAY
              </router-link>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

defineProps({
  normal: {
    type: Boolean,
    default: false
  },
  categories: {
    type: Array,
    default: () => []
  }
})

const router = useRouter()
const keyword = ref('')
const isOpen = ref(true) // mở sẵn giống template

const toggleDropdown = () => {
  isOpen.value = !isOpen.value
}

const handleSearch = () => {
  if (!keyword.value.trim()) return

  router.push({
    path: '/shop',
    query: { q: keyword.value }
  })
}

const goAll = () => {
  router.push('/shop')
}

const goCategory = (id) => {
  router.push({
    path: '/shop',
    query: { category: id }
  })
}
</script>

<style scoped>
.slide-enter-active,
.slide-leave-active {
  transition: all 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>