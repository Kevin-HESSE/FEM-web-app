<template>
  <div class="thumbnail">
    <PictureComponent :is-trending="videoItem.isTrending" :videoItem="videoItem" />

    <BookmarkFlagComponent is-bookmarked/>

    <div class="thumbnail__description">
      <p class="thumbnail__description-information">
        2019
        <span class="category">
          <img src="/build/images/icon-nav-movies.svg" alt="Icon of movies">
          {{ videoItem.category.name}}
        </span>
        {{ videoItem.rating.name }}
      </p>
      <p class="thumbnail__description-title">{{ videoItem.title }}</p>
    </div>
  </div>
</template>

<script setup>
import PictureComponent from '@/components/PictureComponent.vue';
import BookmarkFlagComponent from '@/components/BookmarkFlagComponent.vue';

defineProps({
  videoItem: {
    type: Object,
  },
});

</script>
