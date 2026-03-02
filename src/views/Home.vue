<template>
  <div>
    <!-- Hero Section Begin -->
    <section class="hero">
  <div class="container">
    <div class="row">

      <!-- DANH MỤC -->
      <div class="col-lg-3">
        <CategoriesMenu 
          :categories="categories" 
          :initiallyOpen="true" 
          @selectCategory="goCategory"
        />
      </div>

      <!-- SEARCH + BANNER -->
      <div class="col-lg-9">
        <div class="hero__search">
          <SearchBar :initialKeyword="''" :autoRoute="true" />
          <div class="hero__search__phone">
            <div class="hero__search__phone__icon">
              <i class="fa fa-phone"></i>
            </div>
            <div class="hero__search__phone__text">
              <h5>+84 356 998 469</h5>
              <span>Hỗ trợ 24/7</span>
            </div>
          </div>
        </div>

        <div
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
                      <span>
                        ${{ Number(product.price || product.variants?.[0]?.price || 0).toFixed(2) }}
                      </span>
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
                      <span>
                        ${{ product.price ? product.price.toFixed(2) : '0.00' }}
                      </span>
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
                      <span>
                        ${{ product.variants?.[0]?.price
                          ? product.variants[0].price.toFixed(2)
                        : '0.00' }}
                      </span>
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
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import ProductCard from '@/components/ui/ProductCard.vue'
import BlogCard from '@/components/ui/BlogCard.vue'
import CategoriesMenu from '@/components/ui/CategoriesMenu.vue'
import SearchBar from '@/components/ui/SearchBar.vue'
import { blogPosts } from '@/data/blogs'

const products = ref([])
const categories = ref([])

const selectedFilter = ref('*')
const router = useRouter()
onMounted(async () => {
  try {
    const productRes = await axios.get('http://localhost:8080/products')
    products.value = productRes.data

    const categoryRes = await axios.get('http://localhost:8080/categories')
    categories.value = categoryRes.data
  } catch (err) {
    console.error(err)
  }
})
const filteredProducts = computed(() => {
  let result = products.value

  // filter theo category nếu có
  if (selectedFilter.value !== '*') {
    result = result.filter(p => p.category === selectedFilter.value)
  }

  return result
})

const goCategory = (categoryId) => {
  if (categoryId) {
    router.push({ path: '/shop', query: { category: categoryId } })
  }
}
</script>
<style scoped>
</style>