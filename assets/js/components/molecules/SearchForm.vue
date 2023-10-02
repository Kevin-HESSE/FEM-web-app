<template>
  <form class="form-filter" @submit.prevent>
    <button type="submit">
      <img src="/build/images/icon-search.svg" alt="Search">
    </button>
    <SearchInput
      label="Search for movies or TV series"
      @search-video="handleInput"
    />
  </form>
</template>
<script setup>

import { useVideoStore } from '@/store/VideosStore';
import SearchInput from '@/components/atoms/form/SearchInputComponent.vue';

const videoStore = useVideoStore();
async function handleInput(term) {
  videoStore.$patch({
    searchTerm: term,
    isLoading: true,
  });

  await videoStore.fetchAllVideos();
}
</script>
