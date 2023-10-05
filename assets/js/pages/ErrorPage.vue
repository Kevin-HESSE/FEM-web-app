<template>
  <div class="message notification lost">
    <h1>{{ errorTitle }}</h1>

    <p>{{ errorMessage }}</p>

    <LinkComponent
      url="/"
    >
      <img src="/build/images/icon-nav-home.svg">
      <p>Back to the main page !</p>
    </LinkComponent>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { getStatusCode } from '@/services/page-context';
import LinkComponent from '@/components/atoms/LinkComponent.vue';

const statusCode = getStatusCode();

const errorTitle = computed(() => {
  if (statusCode === '404') {
    return 'Resource not found';
  }

  return 'An error has occurred';
});

const errorMessage = computed(() => {
  if (statusCode === '404') {
    return 'The resource, you are looking for, seems to be nonexistent.';
  }

  return 'An internal error has occurred. Please contact the admin at the following address email : kev.hesse@gmail.com';
});
</script>
