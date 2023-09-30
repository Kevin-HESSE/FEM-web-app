<template>
  <a
    :href="url"
    :class="classComponent"
  >
    <slot></slot>
  </a>
</template>

<script setup>

import { computed } from 'vue';

const props = defineProps({
  url: {
    type: String,
    required: true,
  },
});

const classComponent = computed(() => {
  const classArray = ['nav__item'];

  if (props.url === window.location.pathname) {
    classArray.push('is-active');
  }

  return classArray;
});
</script>
