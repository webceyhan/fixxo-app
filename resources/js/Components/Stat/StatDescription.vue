<script setup lang="ts">
defineProps<{
  text?: string;
}>();
</script>

<template>
  <div class="stat-desc">
    <slot>
      {{ text }}
    </slot>
  </div>
</template>
