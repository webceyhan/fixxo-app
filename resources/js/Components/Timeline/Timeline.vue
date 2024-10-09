<script setup>
const props = defineProps({
  vertical: Boolean,
});
</script>

<template>
  <ul
    :class="[
      'timeline timeline-compact timeline-snap-icon',
      {
        'timeline-vertical': vertical,
      },
    ]"
  >
    <slot />
  </ul>
</template>
