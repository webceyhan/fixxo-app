<script setup lang="ts">
/**
 * Color:
 * - badge-neutral
 * - badge-primary
 * - badge-secondary
 * - badge-accent
 * - badge-info
 * - badge-success
 * - badge-warning
 * - badge-error
 */
defineProps<{
  color?: string;
  compact?: boolean;
}>();
</script>

<template>
  <span
    :class="[
      'badge badge-outline bg-base-100 border-0',
      {
        [`badge-${color}`]: color,
        'p-1': compact,
      },
    ]"
  >
    <slot />
  </span>
</template>

<style scoped>
/* color correction on neutral outline */
.badge-neutral.badge-outline {
  --n: var(--bc);
}
</style>
