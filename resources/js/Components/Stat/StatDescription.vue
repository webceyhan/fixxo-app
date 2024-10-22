<script setup>
defineProps({
  text: String,
});
</script>

<template>
  <div class="stat-desc">
    <slot>
      {{ text }}
    </slot>
  </div>
</template>
