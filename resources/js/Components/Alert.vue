<script setup lang="ts">
import Icon from "@/Components/Icon.vue";

defineProps<{
  message?: string;
}>();
</script>

<template>
  <div role="alert" class="alert">
    <icon name="info-circle" class="text-2xl text-primary" />

    <slot> {{ message }}</slot>
  </div>
</template>
