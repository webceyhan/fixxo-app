<script setup>
import iconMap from "@/Shared/icons";

defineProps({
  name: String,
});
</script>

<template>
  <i :class="`icon bi-${iconMap[name] ?? name}`" />
</template>
