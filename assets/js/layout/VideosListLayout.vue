<template>
  <MainLayout>
    <SearchForm />

    <LoadingComponent v-show="videoStore.isLoading" />

    <slot v-if="!showSearch"/>

    <VideosSection v-else-if="showSearch" :videos-list="videoStore.list">
      {{ titleList }}
    </VideosSection>
  </MainLayout>
</template>

<script setup>

import { computed } from 'vue';
import MainLayout from '@/layout/MainLayout.vue';
import LoadingComponent from '@/components/atoms/LoadingComponent.vue';
import SearchForm from '@/components/molecules/SearchForm.vue';
import { useVideoStore } from '@/store/VideosStore';
import VideosSection from '@/components/organisms/VideosSection.vue';
import { searchTitleConstructor } from '@/helpers/sectionTitleConstructor';

const videoStore = useVideoStore();

const showSearch = computed(() => (videoStore.searchTerm !== '' || videoStore.list.length === 0) && !videoStore.isLoading);
const titleList = computed(() => searchTitleConstructor(videoStore.list, videoStore.searchTerm));

</script>
