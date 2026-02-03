<template>
    <div class="product__discount">
        <div class="section-title product__discount__title">
            <h2>Sale Off</h2>
        </div>

        <Swiper class="product__discount__slider" :modules="[Navigation]" :slides-per-view="3" :space-between="30"
            :speed="600" :navigation="{
                nextEl: '.product__discount__slider .swiper-button-next',
                prevEl: '.product__discount__slider .swiper-button-prev'
            }" :breakpoints="{
        0: { slidesPerView: 1 },
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 }
    }">
            <SwiperSlide v-for="item in products" :key="item.id">
                <div class="product__discount__item">
                    <div class="product__discount__item__pic" :style="{ backgroundImage: `url(${item.image})` }">
                        <div class="product__discount__percent">
                            -{{ item.discount }}%
                        </div>

                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>

                    <div class="product__discount__item__text">
                        <span>{{ item.category }}</span>
                        <h5>{{ item.name }}</h5>
                        <div class="product__item__price">
                            ${{ item.price }}
                            <span>${{ item.oldPrice }}</span>
                        </div>
                    </div>
                </div>
            </SwiperSlide>

            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </Swiper>
    </div>
</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Navigation } from 'swiper/modules'
import 'swiper/css'
import 'swiper/css/navigation'

defineProps({
    products: Array
})
</script>
