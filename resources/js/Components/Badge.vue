<script setup>
defineProps({
  theme: {
    type: String,
    default: "secondary",
  },
});
</script>

<template>
  <span
    class="text-sm rounded-full dark:bg-gray-900 dark:bg-opacity-50 p-1 sm:px-2.5 sm:py-0.5"    
    :class="{
      // default color (secondary)
      'bg-gray-200 text-gray-400': theme === 'secondary',

      // primary
      'bg-blue-100 text-blue-500': theme === 'primary',

      // success
      'bg-green-100 text-green-600': theme === 'success',

      // warning
      'bg-yellow-100 text-yellow-600': theme === 'warning',

      // danger
      'bg-red-100 text-red-600': theme === 'danger',
    }"
  >
    <slot />
  </span>
</template>
