<template>
  <div>
    <!-- Hero Section Begin -->
    <section class="hero">
      <div class="container">
        <div class="row">
          <!-- Danh mục -->
          <div class="col-lg-3">
            <div class="hero__categories">
              <div class="hero__categories__all">
                <i class="fa fa-bars"></i>
                <span>Tất cả danh mục</span>
              </div>
              <ul>
                <li><a href="#">Thịt tươi sống</a></li>
                <li><a href="#">Rau củ</a></li>
                <li><a href="#">Quà trái cây & hạt</a></li>
                <li><a href="#">Quả mọng tươi</a></li>
                <li><a href="#">Hải sản</a></li>
                <li><a href="#">Bơ & Trứng</a></li>
                <li><a href="#">Thức ăn nhanh</a></li>
                <li><a href="#">Hành tươi</a></li>
                <li><a href="#">Đu đủ & đồ ăn vặt</a></li>
                <li><a href="#">Yến mạch</a></li>
                <li><a href="#">Chuối tươi</a></li>
              </ul>
            </div>
          </div>

          <!-- Tìm kiếm + Banner -->
          <div class="col-lg-9">
            <div class="hero__search">
              <div class="hero__search__form">
                <form @submit.prevent="handleSearch">
                  <div class="hero__search__categories">
                    Tất cả ngành hàng
                    <span class="arrow_carrot-down"></span>
                  </div>
                  <input v-model="searchQuery" type="text" placeholder="Bạn đang tìm sản phẩm gì?">
                  <button type="submit" class="site-btn">
                    TÌM KIẾM
                  </button>
                </form>
              </div>

              <div class="hero__search__phone">
                <div class="hero__search__phone__icon">
                  <i class="fa fa-phone"></i>
                </div>
                <div class="hero__search__phone__text">
                  <h5>+65 11.188.888</h5>
                  <span>Hỗ trợ 24/7</span>
                </div>
              </div>
            </div>

            <div class="hero__item set-bg" data-setbg="/img/hero/banner.jpg"
              style="background-image: url('/img/hero/banner.jpg')">
              <div class="hero__text">
                <span>TRÁI CÂY TƯƠI</span>
                <h2>
                  Rau củ <br />100% hữu cơ
                </h2>
                <p>Miễn phí giao hàng & nhận tại cửa hàng</p>
                <router-link to="/shop" class="primary-btn">
                  MUA NGAY
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Hero Section End -->

    <!-- Categories Section Begin -->
    <section class="categories">
      <div class="container">
        <div class="row">
          <div class="categories__slider owl-carousel">
            <div v-for="category in categories" :key="category.id" class="col-lg-3">
              <div class="categories__item set-bg" :data-setbg="category.image"
                :style="{ backgroundImage: `url(${category.image})` }">
                <h5><a href="#">{{ category.name }}</a></h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Categories Section End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="section-title">
              <h2>Sản phẩm nổi bật</h2>
            </div>

            <div class="featured__controls">
              <ul>
                <li :class="{ active: selectedFilter === '*' }" @click="selectedFilter = '*'">
                  Tất cả
                </li>
                <li :class="{ active: selectedFilter === 'oranges' }" @click="selectedFilter = 'oranges'">
                  Trái cây
                </li>
                <li :class="{ active: selectedFilter === 'fresh-meat' }" @click="selectedFilter = 'fresh-meat'">
                  Thịt tươi
                </li>
                <li :class="{ active: selectedFilter === 'vegetables' }" @click="selectedFilter = 'vegetables'">
                  Rau củ
                </li>
                <li :class="{ active: selectedFilter === 'fastfood' }" @click="selectedFilter = 'fastfood'">
                  Thức ăn nhanh
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="row featured__filter">
          <ProductCard v-for="product in filteredProducts" :key="product.id" :product="product" />
        </div>
      </div>
    </section>
    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="banner__pic">
              <img src="/img/banner/banner-1.jpg" alt="">
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="banner__pic">
              <img src="/img/banner/banner-2.jpg" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6">
            <div class="latest-product__text">
              <h4>Sản phẩm mới nhất</h4>
              <div class="latest-product__slider">
                <div class="latest-product__slider__item" v-for="product in products.slice(0, 3)" :key="product.id">
                  <router-link :to="`/shop/${product.id}`" class="latest-product__item">
                    <div class="latest-product__item__pic">
                      <img :src="product.image" alt="">
                    </div>
                    <div class="latest-product__item__text">
                      <h6>{{ product.name }}</h6>
                      <span>${{ product.price.toFixed(2) }}</span>
                    </div>
                  </router-link>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="latest-product__text">
              <h4>Sản phẩm bán chạy</h4>
              <div class="latest-product__slider">
                <div class="latest-product__slider__item" v-for="product in products.slice(0, 3)" :key="product.id">
                  <router-link :to="`/shop/${product.id}`" class="latest-product__item">
                    <div class="latest-product__item__pic">
                      <img :src="product.image" alt="">
                    </div>
                    <div class="latest-product__item__text">
                      <h6>{{ product.name }}</h6>
                      <span>${{ product.price.toFixed(2) }}</span>
                    </div>
                  </router-link>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="latest-product__text">
              <h4>Sản phẩm đánh giá cao</h4>
              <div class="latest-product__slider">
                <div class="latest-product__slider__item" v-for="product in products.slice(0, 3)" :key="product.id">
                  <router-link :to="`/shop/${product.id}`" class="latest-product__item">
                    <div class="latest-product__item__pic">
                      <img :src="product.image" alt="">
                    </div>
                    <div class="latest-product__item__text">
                      <h6>{{ product.name }}</h6>
                      <span>${{ product.price.toFixed(2) }}</span>
                    </div>
                  </router-link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Latest Product Section End -->

    <!-- Blog Section Begin -->
    <section class="from-blog spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="section-title from-blog__title">
              <h2>Bài viết mới</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <BlogCard v-for="blog in blogPosts.slice(0, 3)" :key="blog.id" :blog="blog" />
        </div>
      </div>
    </section>
    <!-- Blog Section End -->
  </div>
</template>


<script setup>
import { ref, computed } from 'vue'
import ProductCard from '@/components/ui/ProductCard.vue'
import BlogCard from '@/components/ui/BlogCard.vue'
import { products, categories } from '@/data/products'
import { blogPosts } from '@/data/blogs'

const searchQuery = ref('')
const selectedFilter = ref('*')

const filteredProducts = computed(() => {
  if (selectedFilter.value === '*') {
    return products
  }
  return products.filter(p => p.category === selectedFilter.value)
})

const handleSearch = () => {
  if (searchQuery.value) {
    alert(`Searching for: ${searchQuery.value}`)
  }
}
</script>
