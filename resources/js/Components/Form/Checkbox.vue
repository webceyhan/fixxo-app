<script setup lang="ts">
const model = defineModel<boolean>();
</script>

<template>
  <input type="checkbox" class="checkbox" v-model="model" />
</template>
