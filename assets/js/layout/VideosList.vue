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
import { computed } from 'vue';
import ThumbnailComponent from '@/components/ThumbnailComponent.vue';

const props = defineProps({
  isTrending: {
    type: Boolean,
    default: false,
  },
  videosList: {
    type: Array,
    required: true,
  },
});

const classComponent = computed(() => {
  const classArray = ['list'];

  if (props.isTrending) {
    classArray.push('is-trending');
  }
  return classArray;
});

</script>
