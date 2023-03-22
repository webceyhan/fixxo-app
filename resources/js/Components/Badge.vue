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
    :class="{
      // base (leading-none fixing vertical alignment issue with icons)
      'inline-flex items-center text-sm leading-none dark:bg-gray-900/50 rounded-full px-2.5 py-1 gap-1.5': true,

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
