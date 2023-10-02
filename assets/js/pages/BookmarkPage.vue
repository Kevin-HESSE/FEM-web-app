<template>
  <VideosListLayout>
    <VideosSection v-show="videoStore.showList" :videos-list="filmVideoList">
      Bookmarked Videos
    </VideosSection>
    <VideosSection v-show="videoStore.showList" :videos-list="seriesVideoList">
      Bookmarked TV Series
    </VideosSection>
  </VideosListLayout>
</template>

<script setup>
import { onBeforeMount, ref } from 'vue';
import { useVideoStore } from '@/store/VideosStore';
import VideosSection from '@/components/organisms/VideosSection.vue';
import VideosListLayout from '@/layout/VideosListLayout.vue';

const videoStore = useVideoStore();
const filmVideoList = ref([]);
const seriesVideoList = ref([]);

onBeforeMount(async () => {
  await videoStore.fetchAllVideos();

  filmVideoList.value = videoStore.list.filter((video) => video.category.slug === 'movies');
  seriesVideoList.value = videoStore.list.filter((video) => video.category.slug === 'tv-series');
});

</script>
