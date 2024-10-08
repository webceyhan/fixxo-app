<script setup>
defineProps({
  text: String,
});
</script>

<template>
  <div class="stat-title">
    <slot>
      {{ text }}
    </slot>
  </div>
</template>
