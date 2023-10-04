<template>
  <div
    class="message"
    :class="{
      error: !isSuccess,
      success: isSuccess,
    }"
    role="alert"
  >
    <p><slot /></p>
  </div>
</template>

<script setup>

defineProps({
  isSuccess: {
    type: Boolean,
    default: false,
  },
});
</script>
