<template>
  <form class="form-filter" @submit.prevent>
    <button type="submit">
      <img src="/build/images/icon-search.svg" alt="Search">
    </button>
    <SearchInput
      :label="label"
      @search-video="handleInput"
    />
  </form>
</template>
<script setup>

import { computed } from 'vue';
import { useVideoStore } from '@/store/VideosStore';
import SearchInput from '@/components/atoms/form/SearchInputComponent.vue';
import { categoryTitleConstructor } from '@/helpers/sectionTitleConstructor';

const videoStore = useVideoStore();

const label = computed(() => {
  if (window.location.pathname === '/bookmarks') {
    return 'Search for bookmarked videos';
  }

  if (window.location.pathname === '/') {
    return 'Search for movies or TV series';
  }

  return `Search for ${categoryTitleConstructor()}`;
});

async function handleInput(term) {
  videoStore.$patch({
    searchTerm: term,
    isLoading: true,
  });

  await videoStore.fetchAllVideos();
}
</script>
