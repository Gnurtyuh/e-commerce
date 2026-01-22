<template>
  <div>
    <Breadcrumb title="Blog" />

    <!-- Blog Section Begin -->
    <section class="blog spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-7">
            <div class="row">
              <BlogCard 
                v-for="blog in blogPosts" 
                :key="blog.id" 
                :blog="blog" 
              />
            </div>
            <div class="product__pagination blog__pagination">
              <a href="#">1</a>
              <a href="#">2</a>
              <a href="#"><i class="fa fa-long-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Blog Section End -->
  </div>
</template>

<script setup>
import Breadcrumb from '@/components/layout/Breadcrumb.vue'
import BlogCard from '@/components/ui/BlogCard.vue'
import { blogPosts } from '@/data/blogs'
</script>
