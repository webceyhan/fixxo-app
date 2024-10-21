<script setup lang="ts">
defineProps<{
  label?: string;
}>();
</script>

<template>
  <a class="link hover:text-white">
    <slot> {{ label }} </slot>
  </a>
</template>
