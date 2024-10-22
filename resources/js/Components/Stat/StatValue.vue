<script setup lang="ts">
defineProps<{
  text?: string | number;
}>();
</script>

<template>
  <div class="stat-value">
    <slot>
      {{ text }}
    </slot>
  </div>
</template>
