<template>
  <header class="header">
    <img src="/build/images/logo.svg" alt="Logo">
    <nav class="nav">
      <LinkComponent url="/">
        <img src="/build/images/icon-nav-home.svg" alt="Homepage">
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
      </LinkComponent>
      <LinkComponent url="/bookmarks">
        <img src="/build/images/icon-nav-bookmark.svg" alt="List of all bookmarks videos">
      </LinkComponent>
    </nav>
    <div class="nav">
      <LinkComponent url="/logout">
        <img src="/build/images/icon-logout.svg" alt="Disconnect from the site">
      </LinkComponent>
      <!--      {{ component('navLink', {-->
      <!--      route: 'app_auth_logout',-->
      <!--      image: asset('build/images/icon-logout.svg'),-->
      <!--      description: 'Log out'-->
      <!--    }) }}-->
      <img class="img-avatar" src="/build/images/image-avatar.png" alt="Avatar of the user">
    </div>

  </header>
</template>
<script setup>
import LinkComponent from '@/components/LinkComponent.vue';
import { getCategories } from '@/services/page-context';

const categories = getCategories();
</script>
