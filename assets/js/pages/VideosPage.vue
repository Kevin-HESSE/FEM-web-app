<template>
  <VideosList is-trending :videos-list="trendingList">
    Trending
  </VideosList>
  <VideosList :videos-list="videosList">
    Recommended for you
  </VideosList>
</template>

<script setup>
import { onBeforeMount, ref } from 'vue';
import VideosList from '@/layout/VideosList.vue';
import { getVideos } from '@/services/video-service';

const videosList = ref([]);
const trendingList = ref([]);

onBeforeMount(async () => {
  let videosData;

  try {
    videosData = await getVideos();
  } catch (e) {
    console.log(e);
  }

  videosList.value = videosData.data['hydra:member'];

  trendingList.value = videosList.value.filter((video) => video.isTrending);
});
</script>
