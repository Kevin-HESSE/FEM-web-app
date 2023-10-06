<template>
  <section class="section-video">
    <h2 class="section-video__title"><slot /></h2>
    <swiper
      :slides-per-view="'auto'"
      :space-between="40"
      :free-mode="true"
      :modules='modules'
    >
      <swiper-slide
        v-for="videoItem in videosList"
        :key="videoItem.id"
      >
        <ThumbnailComponent
          :video-item="videoItem"
          is-trending
        />
      </swiper-slide>
    </swiper>
  </section>
</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { FreeMode } from 'swiper/modules';

import ThumbnailComponent from '@/components/molecules/ThumbnailComponent.vue';

const modules = [FreeMode];

defineProps({
  videosList: {
    type: Array,
    required: true,
  },
});

</script>
