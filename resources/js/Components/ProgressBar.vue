<script setup>
defineProps({
  value: Number,
});
</script>

<template>
  <div class="h-1 bg-gray-300/50 dark:bg-gray-700">
    <div
      class="h-full bg-gray-500/50"
      :style="{ width: `${value}%` }"
    />
  </div>
</template>
