<template>
  <div>
    <Breadcrumb :title="blog?.title || 'Blog Details'" />

    <!-- Blog Details Section Begin -->
    <section class="blog-details spad" v-if="blog">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="blog__details__pic">
              <img :src="blog.image" :alt="blog.title">
            </div>
          </div>
          <div class="col-lg-12">
            <div class="blog__details__content">
              <div class="blog__details__share">
                <span>share</span>
                <ul>
                  <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                  <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                  <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                  <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                  <li><a href="#"><i class="fa fa-envelope"></i></a></li>
                </ul>
              </div>
              <div class="blog__details__text">
                <div v-html="blog.content"></div>
              </div>
              <div class="blog__details__content__item">
                <p>Posted by: {{ blog.author }} | {{ blog.date }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Blog Details Section End -->
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import Breadcrumb from '@/components/layout/Breadcrumb.vue'
import { blogPosts } from '@/data/blogs'

const route = useRoute()

const blog = computed(() => {
  return blogPosts.find(b => b.id === parseInt(route.params.id))
})
</script>
