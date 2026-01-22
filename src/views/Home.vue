<template>
  <div>
    <!-- Hero Section Begin -->
    <section class="hero">
      <div class="container">
        <div class="row">
          <div class="col-lg-3">
            <div class="hero__categories">
              <div class="hero__categories__all">
                <i class="fa fa-bars"></i>
                <span>All departments</span>
              </div>
              <ul>
                <li><a href="#">Fresh Meat</a></li>
                <li><a href="#">Vegetables</a></li>
                <li><a href="#">Fruit & Nut Gifts</a></li>
                <li><a href="#">Fresh Berries</a></li>
                <li><a href="#">Ocean Foods</a></li>
                <li><a href="#">Butter & Eggs</a></li>
                <li><a href="#">Fastfood</a></li>
                <li><a href="#">Fresh Onion</a></li>
                <li><a href="#">Papayaya & Crisps</a></li>
                <li><a href="#">Oatmeal</a></li>
                <li><a href="#">Fresh Bananas</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-9">
            <div class="hero__search">
              <div class="hero__search__form">
                <form @submit.prevent="handleSearch">
                  <div class="hero__search__categories">
                    All Categories
                    <span class="arrow_carrot-down"></span>
                  </div>
                  <input v-model="searchQuery" type="text" placeholder="What do you need?">
                  <button type="submit" class="site-btn">SEARCH</button>
                </form>
              </div>
              <div class="hero__search__phone">
                <div class="hero__search__phone__icon">
                  <i class="fa fa-phone"></i>
                </div>
                <div class="hero__search__phone__text">
                  <h5>+65 11.188.888</h5>
                  <span>support 24/7 time</span>
                </div>
              </div>
            </div>
            <div class="hero__item set-bg" data-setbg="/img/hero/banner.jpg" style="background-image: url('/img/hero/banner.jpg')">
              <div class="hero__text">
                <span>FRUIT FRESH</span>
                <h2>Vegetable <br />100% Organic</h2>
                <p>Free Pickup and Delivery Available</p>
                <router-link to="/shop" class="primary-btn">SHOP NOW</router-link>
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
              <div class="categories__item set-bg" :data-setbg="category.image" :style="{ backgroundImage: `url(${category.image})` }">
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
              <h2>Featured Product</h2>
            </div>
            <div class="featured__controls">
              <ul>
                <li :class="{ active: selectedFilter === '*' }" @click="selectedFilter = '*'">All</li>
                <li :class="{ active: selectedFilter === 'oranges' }" @click="selectedFilter = 'oranges'">Oranges</li>
                <li :class="{ active: selectedFilter === 'fresh-meat' }" @click="selectedFilter = 'fresh-meat'">Fresh Meat</li>
                <li :class="{ active: selectedFilter === 'vegetables' }" @click="selectedFilter = 'vegetables'">Vegetables</li>
                <li :class="{ active: selectedFilter === 'fastfood' }" @click="selectedFilter = 'fastfood'">Fastfood</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row featured__filter">
          <ProductCard 
            v-for="product in filteredProducts" 
            :key="product.id" 
            :product="product" 
          />
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
              <h4>Latest Products</h4>
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
              <h4>Top Rated Products</h4>
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
              <h4>Review Products</h4>
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
              <h2>From The Blog</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <BlogCard 
            v-for="blog in blogPosts.slice(0, 3)" 
            :key="blog.id" 
            :blog="blog" 
          />
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
