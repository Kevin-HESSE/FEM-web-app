<template>
  <div class="thumbnail">
    <PictureComponent :is-trending="videoItem.isTrending" :videoItem="videoItem" />

    <BookmarkFlagComponent :is-bookmarked="isBookmarked" @update-bookmark="handleUpdateBookmark"/>

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
import { onMounted, ref } from 'vue';
import PictureComponent from '@/components/PictureComponent.vue';
import BookmarkFlagComponent from '@/components/BookmarkFlagComponent.vue';
import { getCurrentUser } from '@/services/page-context';
import { updateBookmark } from '@/services/video-service';

const props = defineProps({
  videoItem: {
    type: Object,
  },
});

const isBookmarked = ref(false);

onMounted(() => {
  const currentUser = getCurrentUser();

  isBookmarked.value = props.videoItem.users[0] === currentUser;
});

async function handleUpdateBookmark() {
  const method = isBookmarked.value ? 'delete' : 'post';
  isBookmarked.value = !isBookmarked.value;
  console.log(method);
  await updateBookmark(method, props.videoItem.id);
}

</script>
