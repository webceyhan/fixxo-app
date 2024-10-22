<script setup>
defineProps({
  label: String,
});
</script>

<template>
  <th
    class="px-6 py-3 border-b border-gray-200 dark:border-gray-900 bg-gray-50 dark:bg-gray-700/50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
  >
    <slot> {{ label }} </slot>
  </th>
<themplate>
