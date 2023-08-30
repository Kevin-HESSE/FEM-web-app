<template>
  <section class="list is-trending">
    <h1>Trending</h1>

    <ThumbnailComponent
      v-for="videoItem in videosList"
      :key="videoItem.title"
      :video-item="videoItem"/>
  </section>
</template>

<script setup>
import ThumbnailComponent from '@/components/ThumbnailComponent.vue';

const videosList = [
  {
    id: 1,
    title: 'Beyond Earth',
    slug: 'beyond-earth',
    releasedAt: '2019-01-01',
    isTrending: true,
    isBookmarked: true,
    category: {
      name: 'Movies',
    },
    rating: {
      name: 'PG',
    },
  },
  {
    id: 2,
    title: 'Bottom Gear',
    slug: 'bottom-gear',
    releasedAt: '2021-01-01',
    isTrending: true,
    isBookmarked: true,
    category: {
      name: 'Movies',
    },
    rating: {
      name: 'PG',
    },
  },
  {
    id: 3,
    title: 'Undiscovered Cities',
    slug: 'undiscovered-cities',
    releasedAt: '2019-01-01',
    isTrending: true,
    isBookmarked: false,
    category: {
      name: 'Movies',
    },
    rating: {
      name: '18+',
    },
  },
  {
    id: 4,
    title: '1998',
    slug: '1998',
    releasedAt: '2021-01-01',
    isTrending: true,
    isBookmarked: false,
    category: {
      name: 'Movies',
    },
    rating: {
      name: 'PG',
    },
  },
  {
    id: 5,
    title: 'Dark Side of the moon',
    slug: 'dark-side-of-the-moon',
    releasedAt: '2018-01-01',
    isTrending: false,
    isBookmarked: true,
    category: {
      name: 'Movies',
    },
    rating: {
      name: 'PG',
    },
  },
];
</script>
