<script setup lang="ts">
defineProps<{
  id: string;
  alignEnd?: boolean;
  responsive?: boolean;
}>();
</script>

<template>
  <div
    :class="[
      'drawer',
      {
        'drawer-end': alignEnd,
        'lg:drawer-open': responsive,
      },
    ]"
  >
    <!-- internal toggle -->
    <input :id type="checkbox" class="drawer-toggle" />

    <div class="drawer-content">
      <!-- default -->
      <slot />
    </div>

    <div class="drawer-side shadow-md">
      <!-- overlay -->
      <label :for="id" aria-label="close sidebar" class="drawer-overlay" />

      <!-- aside -->
      <slot name="aside" />
    </div>
  </div>
</template>
