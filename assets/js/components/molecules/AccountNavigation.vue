<template>
  <ul class="sub-nav-wrapper">
    <li>
      <LinkComponent url="/profile" is-avatar>
        <img class="img-avatar" src="/build/images/image-avatar.png" alt="Avatar of the user">
        <p>Profile</p>
      </LinkComponent>
    </li>
    <li>
      <LinkComponent url="/logout">
        <img src="/build/images/icon-logout.svg" alt="Disconnect from the site">
        <p>Disconnect</p>
      </LinkComponent>
    </li>
  </ul>
</template>
<script setup>
import LinkComponent from '@/components/atoms/LinkComponent.vue';
</script>
