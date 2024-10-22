<script setup lang="ts">
defineProps<{
  vertical?: boolean;
}>();
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
