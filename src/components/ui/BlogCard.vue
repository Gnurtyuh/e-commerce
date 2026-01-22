<template>
  <div class="col-lg-4 col-md-4 col-sm-6">
    <div class="blog__item">
      <div class="blog__item__pic">
        <img :src="blog.image" :alt="blog.title">
      </div>
      <div class="blog__item__text">
        <ul>
          <li><i class="fa fa-calendar-o"></i> {{ blog.date }}</li>
          <li><i class="fa fa-comment-o"></i> {{ blog.comments }}</li>
        </ul>
        <h5>
          <router-link :to="`/blog/${blog.id}`">{{ blog.title }}</router-link>
        </h5>
        <p>{{ blog.excerpt }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  blog: {
    type: Object,
    required: true
  }
})
</script>
