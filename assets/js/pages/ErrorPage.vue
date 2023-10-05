<template>
  <MainLayout>
    <h1>{{ errorTitle }}</h1>

    <p>{{ errorMessage }}</p>
  </MainLayout>
</template>

<script setup>
import { computed } from 'vue';
import MainLayout from '@/layout/MainLayout.vue';
import { getStatusCode } from '@/services/page-context';

const statusCode = getStatusCode();

const errorTitle = computed(() => {
  if (statusCode === 404) {
    return 'Resource not found';
  }

  return 'An error has occurred';
});

const errorMessage = computed(() => {
  if (statusCode === 404) {
    return 'The resource, you are looking for, seems to be nonexistent.';
  }

  return 'An internal error has occurred. Please contact the admin at the following address email : kev.hesse@gmail.com';
});
</script>
