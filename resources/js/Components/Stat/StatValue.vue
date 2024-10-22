<script setup>
defineProps({
  text: [String, Number],
});
</script>

<template>
  <div class="stat-value">
    <slot>
      {{ text }}
    </slot>
  </div>
</template>
