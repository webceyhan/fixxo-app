<script setup>
import Icon from "@/Components/Icon.vue";
</script>

<template>
  <label class="swap swap-rotate btn btn-ghost btn-circle">
    <!-- this hidden checkbox controls the state -->
    <input type="checkbox" class="theme-controller" value="light" />

    <!-- dark mode -->
    <Icon name="sun" class="text-2xl swap-on" />

    <!-- light mode -->
    <Icon name="moon" class="text-2xl swap-off" />
  </label>
</template>
