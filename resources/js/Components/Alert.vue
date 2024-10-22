<script setup>
import Icon from "@/Components/Icon.vue";

defineProps({
  message: String,
});
</script>

<template>
  <div role="alert" class="alert">
    <icon name="info-circle" class="text-2xl text-primary" />
    <slot> {{ message }}</slot>
  </div>
</template>
