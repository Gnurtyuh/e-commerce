<template>
  <div>
    <section class="hero hero-normal">
      <div class="container">
        <div class="row">
          <div class="col-lg-3">
            <CategoriesMenu 
              :categories="categories" 
              :initiallyOpen="false" 
              :showAllOption="true"
              @selectCategory="handleCategorySelect" 
            />
          </div>
          <div class="col-lg-9">
            <div class="hero__search">
              <SearchBar 
                :initialKeyword="searchQuery" 
                :autoRoute="false"
                @search="handleSearch" 
              />
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
          </div>
        </div>
      </div>
    </section>

    <Breadcrumb title="Sản phẩm" />

    <section class="product spad">
      <div class="container">
        <div class="row">

          <!-- SIDEBAR -->
          <div class="col-lg-3 col-md-5">
            <div class="sidebar">

              <div class="sidebar__item">
                <h4>Danh mục</h4>

                <ul>
                  <li>
                    <a href="#" @click.prevent="fetchAllProducts" :class="{ 'font-weight-bold': !route.query.category && !activeCategoryId }">
                      Tất cả
                    </a>
                  </li>

                  <li
                    v-for="cat in categories"
                    :key="cat.categoryId"
                  >
                    <a
                      href="#"
                      @click.prevent="fetchProductsByCategory(cat.categoryId)"
                      :class="{ 'font-weight-bold': route.query.category == cat.categoryId || activeCategoryId == cat.categoryId }"
                    >
                      {{ cat.name }}
                    </a>
                  </li>
                </ul>
              </div>

            </div>
          </div>

          <!-- PRODUCT LIST -->
          <div class="col-lg-9 col-md-7">
            <div class="row" ref="productListRef">
              <div v-if="paginatedProducts.length === 0" class="col-12 text-center my-5">
                <h4>Không tìm thấy sản phẩm nào!</h4>
              </div>
              <ProductCard
                v-for="product in paginatedProducts"
                :key="product.productId || product.productId"
                :product="product"
              />
            </div>

            <!-- PAGINATION -->
            <div class="product__pagination" v-if="totalPages > 1">
              <a href="#" @click.prevent="goToPage(currentPage - 1)"><i class="fa fa-long-arrow-left"></i></a>
              <a href="#" 
                 v-for="page in totalPages" 
                 :key="page"
                 :class="{ active: page === currentPage }"
                 @click.prevent="goToPage(page)">{{ page }}</a>
              <a href="#" @click.prevent="goToPage(currentPage + 1)"><i class="fa fa-long-arrow-right"></i></a>
            </div>
          </div>

        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'
import { useRoute, useRouter } from 'vue-router'

import Breadcrumb from '@/components/layout/Breadcrumb.vue'
import CategoriesMenu from '@/components/ui/CategoriesMenu.vue'
import SearchBar from '@/components/ui/SearchBar.vue'
import ProductCard from '@/components/ui/ProductCard.vue'

const route = useRoute()
const router = useRouter()
const searchQuery = ref(route.query.q || '')

const categories = ref([])
const products = ref([])
const activeCategoryId = ref(null)
const productListRef = ref(null)

const API_BASE = 'http://localhost:8080'
const attachProductData = async (productList) => {
  return await Promise.all(
    productList.map(async (product) => {
      try {
        const [variantRes, imageRes] = await Promise.all([
          axios.get(`${API_BASE}/by-product/${product.productId}`),
          axios.get(`${API_BASE}/products/${product.productId}/images`)
        ])

        return {
          ...product,
          variants: variantRes.data || [],
          images: imageRes.data || []
        }
      } catch (err) {
        console.error('Lỗi load variants/images:', err)
        return {
          ...product,
          variants: [],
          images: []
        }
      }
    })
  )
}

/* ======================
   PAGINATION STATE
====================== */
const currentPage = ref(1)
const itemsPerPage = 9

/* ======================
   FETCH DATA
====================== */

const fetchCategories = async () => {
  try {
    const res = await axios.get(`${API_BASE}/categories`)
    categories.value = res.data
  } catch (err) {
    console.error('Lỗi lấy danh mục:', err)
  }
}

const fetchAllProducts = async () => {
  try {
    const res = await axios.get(`${API_BASE}/products`)

    products.value = await attachProductData(res.data)
    activeCategoryId.value = null
    currentPage.value = 1

  } catch (err) {
    console.error('Lỗi lấy sản phẩm:', err)
  }
}

const fetchProductsByCategory = async (categoryId) => {
  try {
    const res = await axios.get(
      `${API_BASE}/products/by-category/${categoryId}`
    )

    products.value = await attachProductData(res.data)

    activeCategoryId.value = categoryId
    currentPage.value = 1

  } catch (err) {
    console.error('Lỗi lọc theo category:', err)
  }
}

/* ======================
   HANDLERS
====================== */

const handleCategorySelect = (categoryId) => {
  if (categoryId) {
    router.push({ path: '/shop', query: { category: categoryId } })
  } else {
    router.push({ path: '/shop' })
  }
}

const handleSearch = (keyword) => {
  searchQuery.value = keyword
  currentPage.value = 1
  router.push({ path: '/shop', query: { q: keyword } })
}

/* ======================
   LIFECYCLE
====================== */

onMounted(async () => {
  await fetchCategories()
  
  if (route.query.category) {
    await fetchProductsByCategory(route.query.category)
  } else {
    await fetchAllProducts()
  }
})

/* ======================
   WATCH QUERY SEARCH & CATEGORY
====================== */

watch(
  () => route.query.q,
  (newQ) => {
    searchQuery.value = newQ || ''
    currentPage.value = 1
  }
)

watch(
  () => route.query.category,
  (newCat) => {
    if (newCat) {
      if (newCat != activeCategoryId.value) {
        fetchProductsByCategory(newCat)
      }
    } else {
      if (activeCategoryId.value !== null) {
        fetchAllProducts()
      }
    }
  }
)

/* ======================
   FILTER SEARCH
====================== */

const filteredProducts = computed(() => {
  if (!searchQuery.value) return products.value

  return products.value.filter(p =>
    p.name?.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
})

/* ======================
   PAGINATION LOGIC
====================== */

const totalPages = computed(() => {
  return Math.ceil(filteredProducts.value.length / itemsPerPage)
})

const paginatedProducts = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage
  const end = start + itemsPerPage
  return filteredProducts.value.slice(start, end)
})

const goToPage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page
    
    // Tự động cuộn lên đầu danh sách sản phẩm
    if (productListRef.value) {
      const topPos = productListRef.value.getBoundingClientRect().top + window.pageYOffset - 100
      window.scrollTo({ top: topPos, behavior: 'smooth' })
    }
  }
}
</script>

<style scoped>
.font-weight-bold {
  font-weight: bold;
  color: #7fad39 !important;
}
.product__pagination a {
  cursor: pointer;
}
/* Active state if Tailwind classes break for some reason */
.product__pagination a.active {
    background: #7fad39;
    border-color: #7fad39;
    color: #ffffff;
}
</style>