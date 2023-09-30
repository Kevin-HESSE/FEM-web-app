<template>
  <picture>
    <source
      v-if="!isTrending"
      media="(min-width: 1200px)"
      :srcset="directoryImage('large')"
    />
    <source
      v-if="!isTrending"
      media="(min-width: 765px)"
      :srcset="directoryImage('medium')"
    />
    <source
      v-if="isTrending"
      media="(min-width: 765px)"
      :srcset="directoryImage('large')"
    />
    <img
      class="thumbnail__image"
      :src="directoryImage('small')"
      :alt="videoItem.title"
    >
  </picture>
</template>

<script setup>

const props = defineProps({
  isTrending: {
    type: Boolean,
    default: false,
  },
  videoItem: {
    type: Object,
  },
});

/**
 * Return the correct directory depending on the trending
 * @type {ComputedRef<string>}
 * @return String
 */
function directoryImage(size) {
  const directory = props.isTrending
    ? `/build/images/thumbnails/${props.videoItem.slug}/trending`
    : `/build/images/thumbnails/${props.videoItem.slug}/regular`;

  return `${directory}/${size}.jpg`;
}
</script>
