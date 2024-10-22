<script setup>
defineProps(["value"]);
</script>

<template>
  <div
    class="flex items-center border border-gray-300 bg-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-md px-4"
  >
    <slot>{{ value }}</slot>
  </div>
</template>
