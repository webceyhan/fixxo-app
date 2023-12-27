<script setup>
import BaseButton from "./BaseButton.vue";
</script>

<template>
  <BaseButton type="submit" class="btn-primary">
    <slot />
  </BaseButton>
</template>
