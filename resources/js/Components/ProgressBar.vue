<script setup>
defineProps({
  value: Number,
});
</script>

<template>
  <div class="h-1 bg-gray-200/50 dark:bg-gray-800/50">
    <span
      class="h-full bg-blue-500/50 dark:bg-blue-500/50"
      :style="{ width: `${value}%` }"
    />
  </div>
</template>
