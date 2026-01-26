<template>
  <div>
    <HeroSearch />
    <Breadcrumb title="Cửa hàng" />

    <!-- Product Section Begin -->
    <section class="product spad">
      <div class="container">
        <div class="row">
          <!-- SIDEBAR -->
          <div class="col-lg-3 col-md-5">
            <div class="sidebar">

              <!-- Department -->
              <div class="sidebar__item">
                <h4>Danh mục</h4>
                <ul>
                  <li><a href="#">Thịt tươi sống</a></li>
                  <li><a href="#">Rau củ</a></li>
                  <li><a href="#">Quà trái cây & hạt</a></li>
                  <li><a href="#">Quả mọng tươi</a></li>
                  <li><a href="#">Hải sản</a></li>
                  <li><a href="#">Bơ & Trứng</a></li>
                </ul>
              </div>

              <!-- Price -->
              <div class="sidebar__item">
                <h4>Giá</h4>
                <div class="price-range-wrap">
                  <p>
                    Giá:
                    {{ priceRange[0] }}$ - {{ priceRange[1] }}$
                  </p>
                </div>
              </div>

              <!-- Popular Size -->
              <PopularSizeFilter />

              <!-- Latest Products -->
              <LatestProductsSlider :products="latestProducts" />

            </div>
          </div>

          <!-- PRODUCT LIST -->
          <div class="col-lg-9 col-md-7">

            <!-- Sale -->
            <SaleOffSlider :products="saleProducts" />

            <!-- Filter -->
            <div class="filter__item">
              <div class="row">
                <div class="col-lg-4 col-md-5">
                  <div class="filter__sort">
                    <span>Sắp xếp theo</span>
                    <select v-model="sortBy" style="margin-left: 15px; border: none; font-weight: bold;">
                      <option value="default">Mặc định</option>
                      <option value="price-low">
                        Giá: Thấp → Cao
                      </option>
                      <option value="price-high">
                        Giá: Cao → Thấp
                      </option>
                    </select>
                  </div>
                </div>

                <div class="col-lg-4 col-md-4">
                  <div class="filter__found">
                    <h6>
                      Tìm thấy
                      <span>{{ sortedProducts.length }}</span>
                      sản phẩm
                    </h6>
                  </div>
                </div>
              </div>
            </div>

            <!-- Products -->
            <div class="row">
              <ProductCard v-for="product in sortedProducts" :key="product.id" :product="product" />
            </div>

            <!-- Pagination -->
            <div class="product__pagination">
              <a href="#" class="active">1</a>
              <a href="#">2</a>
              <a href="#">
                <i class="fa fa-long-arrow-right"></i>
              </a>
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
