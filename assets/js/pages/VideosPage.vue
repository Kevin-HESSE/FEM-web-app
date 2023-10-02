<template>
  <VideosListLayout>
    <CarouselComponent v-show="videoStore.showList" :videos-list="trendingList">
      Trending
    </CarouselComponent>
    <VideosSection v-show="videoStore.showList" :videos-list="videoList">
      Recommended for you
    </VideosSection>
  </VideosListLayout>
</template>

<script setup>
import { onBeforeMount, ref } from 'vue';
import VideosSection from '@/components/organisms/VideosSection.vue';
import CarouselComponent from '@/components/molecules/CarouselComponent.vue';
import { useVideoStore } from '@/store/VideosStore';
import VideosListLayout from '@/layout/VideosListLayout.vue';

const videoStore = useVideoStore();
const trendingList = ref([]);
const videoList = ref([]);

onBeforeMount(async () => {
  await videoStore.fetchAllVideos();

  trendingList.value = videoStore.list.filter((video) => video.isTrending);
  videoList.value = videoStore.list.filter((video) => !video.isTrending);
});

</script>
