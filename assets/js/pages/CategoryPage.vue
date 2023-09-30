<template>
  <MainLayout>
    <form class="form-filter">
      <button type="submit">
        <img src="/build/images/icon-search.svg" alt="Search">
      </button>
      <SearchInput
          label="Search for movies or TV series"
          @search-video="handleInput"
      />
    </form>

    <LoadingComponent v-show="isLoading" />

    <VideosList v-show="!isLoading" :videos-list="videosList">
      {{ titleList }}
    </VideosList>
  </MainLayout>
</template>

<script setup>
import { computed, onBeforeMount, ref } from 'vue';
import { getVideos } from '@/services/video-service';
import VideosList from '@/components/organisms/VideosList.vue';
import SearchInput from '@/components/atoms/form/SearchInputComponent.vue';
import { sectionTitleConstructor } from '@/helpers/sectionTitleConstructor';
import LoadingComponent from '@/components/atoms/LoadingComponent.vue';
import MainLayout from '@/layout/MainLayout.vue';

const videosList = ref([]);
const trendingList = ref([]);
const searchTerm = ref('');
const isLoading = ref(true);

async function loadVideos() {
  let videosData;

  try {
    videosData = await getVideos(searchTerm.value);
  } catch (e) {
    console.log(e);

    return;
  }

  // eslint-disable-next-line consistent-return
  return videosData.data['hydra:member'];
}

onBeforeMount(async () => {
  videosList.value = await loadVideos();

  trendingList.value = videosList.value.filter((video) => video.isTrending);

  isLoading.value = false;
});

const titleList = computed(() => sectionTitleConstructor(videosList.value, searchTerm.value));

async function handleInput(term) {
  searchTerm.value = term;

  isLoading.value = true;

  videosList.value = await loadVideos();

  isLoading.value = false;
}

</script>
