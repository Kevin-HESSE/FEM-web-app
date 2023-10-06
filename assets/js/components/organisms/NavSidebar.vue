<template>
  <header class="header">
    <div class="banner">
      <img src="/build/images/logo.svg" alt="Logo">
      <button class="banner--cta mobile" @click="$emit('extend-sidebar', !isExtended)">
        Expand navigation bar
      </button>
    </div>
    <nav class="nav">
      <ul class="nav-wrapper">
        <li>
          <LinkComponent url="/">
            <img src="/build/images/icon-nav-home.svg" alt="Homepage">
            <p>Home</p>
          </LinkComponent>
        </li>
        <li
          v-for="category in categories"
          :key="category['@id']"
        >
          <LinkComponent
            :url="`/category/${category.slug}`"
          >
            <img
              :src="`/build/images/icon-nav-${ category.slug }.svg`"
              :alt="`List of all ${category.name.toLowerCase()}`"
            >
            <p>{{ category.name }}</p>
          </LinkComponent>
        </li>
        <li>
          <LinkComponent url="/bookmarks">
            <img src="/build/images/icon-nav-bookmark.svg" alt="List of all bookmarks videos">
            <p>Bookmark</p>
          </LinkComponent>
        </li>
        <li>
          <AccountNavigation />
        </li>
      </ul>
    </nav>

    <button class="banner--cta desktop" @click="$emit('extend-sidebar', !isExtended)">
      <img src="/build/images/icon-arrow.svg" alt="Extend the sidebar">
    </button>
  </header>
</template>

<script setup>
import LinkComponent from '@/components/atoms/LinkComponent.vue';
import { getCategories } from '@/services/page-context';
import AccountNavigation from '@/components/molecules/AccountNavigation.vue';

const categories = getCategories();
defineEmits(['extend-sidebar']);

defineProps({
  isExtended: {
    type: Boolean,
    required: true,
  },
});
</script>
