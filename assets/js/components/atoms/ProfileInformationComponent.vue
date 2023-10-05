<template>
  <div class="profile-information__frame">
    <p class="profile-information__label">{{ label }} :</p>
    <p class="profile-information__data">{{ userInfo }}</p>
  </div>
</template>

<script setup>
defineProps({
  label: {
    type: String,
    required: true,
  },
  userInfo: {
    type: String,
    required: true,
    default: 'No data found',
  },
});
</script>
