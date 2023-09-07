<template>
  <input
    type="search"
    v-model="searchTerm"
    :placeholder="label"
    @input="handleSubmit"
    v-bind="$attrs"
  />
</template>

<script setup>

import { ref } from 'vue';

const searchTimeout = ref(null);
const emit = defineEmits(['search-video']);
const searchTerm = ref(null);

defineProps({
  label: {
    type: String,
    required: true,
  },
  modelValue: {
    type: String,
    default: '',
  },
});

function handleSubmit() {
  if (searchTimeout.value) {
    clearTimeout(searchTimeout.value);
  }

  searchTimeout.value = setTimeout(() => {
    emit('search-video', searchTerm.value);
    searchTimeout.value = null;
  }, 500);
}

</script>
