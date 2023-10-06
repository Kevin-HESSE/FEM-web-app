<template>
  <div :class="classComponent">
    <NavSidebar
      is-extended
      @extend-sidebar="handleExtendSidebar"
    />

    <main class="content">
      <slot />
    </main>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import NavSidebar from '@/components/organisms/NavSidebar.vue';

const isExtended = ref(false);

const classComponent = computed(() => (isExtended.value ? 'container is-extended' : 'container'));

function handleExtendSidebar() {
  isExtended.value = !isExtended.value;
}
</script>
