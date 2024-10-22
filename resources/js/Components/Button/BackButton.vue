<script setup lang="ts">
import SecondaryButton from "./SecondaryButton.vue";

const back = () => window.history.back();
</script>

<template>
  <SecondaryButton icon="chevron-left" @click="back">
    <span class="max-md:hidden"> Back </span>
  </SecondaryButton>
</template>
