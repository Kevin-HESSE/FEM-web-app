<template>
  <div class="thumbnail">
    <PictureComponent :is-trending="isTrending" :videoItem="videoItem" />

    <BookmarkFlagComponent :is-bookmarked="isBookmarked" @update-bookmark="handleUpdateBookmark"/>

    <div class="thumbnail__description">
      <p class="thumbnail__description-information">
        {{ yearRelease }}
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
import { computed, onMounted, ref } from 'vue';
import PictureComponent from '@/components/atoms/PictureComponent.vue';
import BookmarkFlagComponent from '@/components/atoms/BookmarkFlagComponent.vue';
import { getCurrentUser } from '@/services/page-context';
import { useVideoStore } from '@/store/VideosStore';

const props = defineProps({
  videoItem: {
    type: Object,
    required: true,
  },
  isTrending: {
    type: Boolean,
    default: false,
  },
});

const store = useVideoStore();

const yearRelease = computed(() => {
  const date = new Date(props.videoItem.releaseAt);

  return date.getFullYear();
});

const isBookmarked = ref(false);

onMounted(() => {
  const currentUser = getCurrentUser();

  isBookmarked.value = props.videoItem.users[0] === currentUser;
});

async function handleUpdateBookmark() {
  const method = isBookmarked.value ? 'delete' : 'post';
  isBookmarked.value = !isBookmarked.value;
  await store.removeFromBookmark(method, props.videoItem.id);
}

</script>
