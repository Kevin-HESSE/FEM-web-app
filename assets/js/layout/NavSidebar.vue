<template>
  <header class="header">
    <div class="banner">
      <img src="/build/images/logo.svg" alt="Logo">
      <button class="banner--cta mobile" @click="$emit('extend-sidebar', !isExtended)">
        Expand navigation bar
      </button>
    </div>
    <nav class="nav">
      <LinkComponent url="/">
        <img src="/build/images/icon-nav-home.svg" alt="Homepage">
        <p>Home</p>
      </LinkComponent>
      <LinkComponent
        v-for="category in categories"
        :key="category['@id']"
        :url="`/category/${category.slug}`"
      >
        <img
          :src="`/build/images/icon-nav-${ category.slug }.svg`"
          :alt="`List of all ${category.name.toLowerCase()}`"
        >
        <p>{{ category.name }}</p>
      </LinkComponent>
      <LinkComponent url="/bookmarks">
        <img src="/build/images/icon-nav-bookmark.svg" alt="List of all bookmarks videos">
        <p>Bookmark</p>
      </LinkComponent>
      <LinkComponent url="/logout">
        <img src="/build/images/icon-logout.svg" alt="Disconnect from the site">
        <p>Disconnect</p>
      </LinkComponent>
    </nav>

    <button class="banner--cta desktop" @click="$emit('extend-sidebar', !isExtended)">
      Expand navigation bar
    </button>
    <!--      <img class="img-avatar" src="/build/images/image-avatar.png" alt="Avatar of the user">-->
  </header>
</template>

<script setup>
import LinkComponent from '@/components/navigation/LinkComponent.vue';
import { getCategories } from '@/services/page-context';

const categories = getCategories();
defineEmits(['extend-sidebar']);

defineProps({
  isExtended: {
    type: Boolean,
    required: true,
  },
});
</script>
