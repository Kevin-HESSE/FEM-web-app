<template>
  <VideosListLayout>
    <VideosSection v-show="videoStore.showList" :videos-list="videoStore.list">
      {{ titleList }}
    </VideosSection>
  </VideosListLayout>
</template>

<script setup>
import { computed, onBeforeMount } from 'vue';
import { useVideoStore } from '@/store/VideosStore';
import { categoryTitleConstructor } from '@/helpers/sectionTitleConstructor';
import VideosSection from '@/components/organisms/VideosSection.vue';
import VideosListLayout from '@/layout/VideosListLayout.vue';

const videoStore = useVideoStore();

onBeforeMount(async () => {
  await videoStore.fetchAllVideos();
});

const titleList = computed(() => categoryTitleConstructor());

</script>
