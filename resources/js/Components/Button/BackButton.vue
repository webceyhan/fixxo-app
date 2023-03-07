<script setup>
import Icon from "../Icon.vue";
import SecondaryButton from "./SecondaryButton.vue";

const back = () => window.history.back();
</script>

<template>
  <SecondaryButton @click="back" class="gap-2">
    <slot>
      <Icon name="chevron-left" />

      <span class="hidden md:inline"> Back </span>
    </slot>
  </SecondaryButton>
</template>
