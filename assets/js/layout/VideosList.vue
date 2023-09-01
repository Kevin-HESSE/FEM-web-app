<template>
  <h2><slot></slot></h2>
  <section :class="classComponent">
    <ThumbnailComponent
      v-for="videoItem in videosList"
      :key="videoItem.title"
      :video-item="videoItem"
    />
  </section>
</template>

<script setup>
import axios from 'axios';
import { computed, onMounted, ref } from 'vue';
import ThumbnailComponent from '@/components/ThumbnailComponent.vue';

const props = defineProps({
  isTrending: {
    type: Boolean,
    default: false,
  },
});

const videosList = ref([]);

const classComponent = computed(() => {
  const classArray = ['list'];

  if (props.isTrending) {
    classArray.push('is-trending');
  }
  return classArray;
});

onMounted(async () => {
  const apiUrl = props.isTrending ? '/api/videos?page=1&isTrending=true' : '/api/videos?page=1';
  const response = await axios(apiUrl);

  videosList.value = response.data['hydra:member'];
});

</script>
