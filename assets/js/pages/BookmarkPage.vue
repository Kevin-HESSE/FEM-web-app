<template>
  <VideosListLayout>
    <VideosSection v-if="filmVideoList.length !== 0" :videos-list="filmVideoList">
      Bookmarked Videos
    </VideosSection>
    <VideosSection v-if="seriesVideoList.length !== 0" :videos-list="seriesVideoList">
      Bookmarked TV Series
    </VideosSection>
  </VideosListLayout>
</template>

<script setup>
import { computed, onBeforeMount } from 'vue';
import { useVideoStore } from '@/store/VideosStore';
import VideosSection from '@/components/organisms/VideosSection.vue';
import VideosListLayout from '@/layout/VideosListLayout.vue';

const videoStore = useVideoStore();

const filmVideoList = computed(() => (
  videoStore.list.filter(
    (video) => video.category.slug === 'movies',
  )
));
const seriesVideoList = computed(() => (
  videoStore.list.filter(
    (video) => video.category.slug === 'tv-series',
  )
));

onBeforeMount(async () => {
  await videoStore.fetchAllVideos();
});

</script>
