<script setup>
defineProps({
  label: String,
});
</script>
<template>
  <h3
    class="px-4 py-2 text-xs font-medium tracking-wider text-gray-400 dark:text-gray-500 uppercase"
  >
    <slot>{{ label }}</slot>
  </h3>
</template>
