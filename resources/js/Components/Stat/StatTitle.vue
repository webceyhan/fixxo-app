<script setup lang="ts">
defineProps<{
  text?: string;
}>();
</script>

<template>
  <div class="stat-title">
    <slot>
      {{ text }}
    </slot>
  </div>
</template>
