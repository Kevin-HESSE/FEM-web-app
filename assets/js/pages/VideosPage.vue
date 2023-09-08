<template>
  <div :class="classComponent">
    <NavSidebar
      is-extended
      @extend-sidebar="handleExtendSidebar"
    />

    <main class="content">
      <form class="form-filter">
        <button type="submit">
          <img src="/build/images/icon-search.svg" alt="Search">
        </button>
        <SearchInput
          label="Search for movies or TV series"
          @search-video="handleInput"
        />
      </form>
      <VideosList v-show="showTrendingList" is-trending :videos-list="trendingList">
        Trending
      </VideosList>
      <VideosList :videos-list="videosList">
        {{ titleList }}
      </VideosList>
    </main>
  </div>
</template>

<script setup>
import { computed, onBeforeMount, ref } from 'vue';
import { getVideos } from '@/services/video-service';
import VideosList from '@/layout/VideosList.vue';
import SearchInput from '@/components/form/SearchInput.vue';
import NavSidebar from '@/layout/NavSidebar.vue';

const videosList = ref([]);
const trendingList = ref([]);
const searchTerm = ref('');
const isExtended = ref(false);

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
});

const showTrendingList = computed(() => searchTerm.value === '');

const titleList = computed(() => {
  if (videosList.value.length === 0) {
    return 'Sorry, we found no videos !';
  }

  const wordResult = videosList.value.length === 1 ? 'result' : 'results';

  if (searchTerm.value !== '') {
    return `Found ${videosList.value.length} ${wordResult} for '${searchTerm.value}'`;
  }

  return 'Recommended for you';
});
const classComponent = computed(() => (isExtended.value ? 'container is-extended' : 'container'));

async function handleInput(term) {
  searchTerm.value = term;

  videosList.value = await loadVideos();
}

function handleExtendSidebar() {
  isExtended.value = !isExtended.value;
}
</script>
