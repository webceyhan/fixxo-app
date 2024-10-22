<script setup lang="ts">
defineProps<{
  title: string;
}>();
</script>

<template>
  <li>
    <h2 class="menu-title uppercase">
      {{ title }}
    </h2>

    <ul>
      <slot />
    </ul>
  </li>
</template>
