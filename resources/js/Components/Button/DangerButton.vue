<script setup>
import BaseButton from "./BaseButton.vue";
</script>

<template>
  <BaseButton type="submit" class="btn-error">
    <slot />
  </BaseButton>
</template>
