<template>
    <div class="sidebar__item">
        <div class="latest-product__text">
            <h4>Latest Products</h4>

            <Swiper direction="vertical" :slides-per-view="3" :space-between="20" @swiper="swiperRef = $event"
                class="latest-product__slider">
                <SwiperSlide v-for="product in products" :key="product.id" class="latest-product__slider__item">
                    <a href="#" class="latest-product__item">
                        <div class="latest-product__item__pic">
                            <img :src="product.image" />
                        </div>
                        <div class="latest-product__item__text">
                            <h6>{{ product.name }}</h6>
                            <span>${{ product.price }}</span>
                        </div>
                    </a>
                </SwiperSlide>
            </Swiper>

            <div class="latest-product__slider__nav" style="display: flex;">
                <span @click="swiperRef.slidePrev()" style="margin-right: 20px;">
                    <i class="fa fa-angle-up"></i>
                </span>
                <span @click="swiperRef.slideNext()">
                    <i class="fa fa-angle-down"></i>
                </span>
            </div>
        </div>
    </div>
</template>


<!-- <script setup>
import { Swiper, SwiperSlide } from 'swiper/vue'
// import { Navigation } from 'swiper/modules'
import 'swiper/css'
import 'swiper/css/navigation'

defineProps({
    products: Array
})
</script> -->
<script setup>
import { ref } from 'vue'
import { Swiper, SwiperSlide } from 'swiper/vue'
import 'swiper/css'

const swiperRef = ref(null)

defineProps({
    products: Array
})
</script>
