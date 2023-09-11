<template>
  <section class="section-video">
    <h2 class="section-video__title"><slot /></h2>
    <div :class="classComponent">
      <ThumbnailComponent
        v-for="videoItem in videosList"
        :key="videoItem.title"
        :video-item="videoItem"
      />
    </div>
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
