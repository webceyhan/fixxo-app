<script setup>
defineProps({
  label: String,
  value: String,
});
</script>

<template>
  <div
    class="even:bg-gray-50 dark:even:bg-gray-700/25 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
  >
    <dt class="font-medium text-gray-500">
      <slot name="label">{{ label }}</slot>
    </dt>

    <dd class="mt-1 text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0">
      <slot>{{ value }}</slot>
    </dd>
  </div>
</template>
