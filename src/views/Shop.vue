<template>
  <div>
    <HeroSearch />
    <Breadcrumb title="Shop Grid" />

    <!-- Product Section Begin -->
    <section class="product spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-5">
            <div class="sidebar">
              <div class="sidebar__item">
                <h4>Department</h4>
                <ul>
                  <li><a href="#">Fresh Meat</a></li>
                  <li><a href="#">Vegetables</a></li>
                  <li><a href="#">Fruit & Nut Gifts</a></li>
                  <li><a href="#">Fresh Berries</a></li>
                  <li><a href="#">Ocean Foods</a></li>
                  <li><a href="#">Butter & Eggs</a></li>
                </ul>
              </div>
              <div class="sidebar__item">
                <h4>Price</h4>
                <div class="price-range-wrap">
                  <p>Price: ${{ priceRange[0] }} - ${{ priceRange[1] }}</p>
                </div>
              </div>

              <!-- POPULAR SIZE -->
              <PopularSizeFilter />
              <!-- LATEST PRODUCTS -->
              <LatestProductsSlider :products="latestProducts" />

            </div>
          </div>
          <div class="col-lg-9 col-md-7">
            <SaleOffSlider :products="saleProducts" />
            <div class="filter__item">
              <div class="row">
                <div class="col-lg-4 col-md-5">
                  <div class="filter__sort">
                    <span>Sort By</span>
                    <select v-model="sortBy" style="margin-left: 15px; border: none; font-weight: bold;">
                      <option value="default">Default</option>
                      <option value="price-low">Price: Low to High</option>
                      <option value="price-high">Price: High to Low</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4">
                  <div class="filter__found">
                    <h6><span>{{ sortedProducts.length }}</span> Products found</h6>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <ProductCard v-for="product in sortedProducts" :key="product.id" :product="product" />
            </div>
            <div class="product__pagination">
              <a href="#" class="active">1</a>
              <a href="#">2</a>
              <a href="#"><i class="fa fa-long-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Product Section End -->
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import Breadcrumb from '@/components/layout/Breadcrumb.vue'
import HeroSearch from '@/components/layout/HeroSearch.vue'
import ProductCard from '@/components/ui/ProductCard.vue'
import SaleOffSlider from '@/components/ui/SaleOffSlider.vue'
import PopularSizeFilter from '@/components/ui/PopularSizeFilter.vue'
import LatestProductsSlider from '@/components/ui/LatestProductsSlider.vue'
import { saleProducts } from '@/data/saleProducts'
import { products } from '@/data/products'
import { latestProducts } from '@/data/latestProducts'


const sortBy = ref('default')
const priceRange = ref([0, 100])

const sortedProducts = computed(() => {
  let result = [...products]

  if (sortBy.value === 'price-low') {
    result.sort((a, b) => a.price - b.price)
  } else if (sortBy.value === 'price-high') {
    result.sort((a, b) => b.price - a.price)
  }

  return result
})
</script>
