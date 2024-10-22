<script setup lang="ts">
import iconMap from "@/Shared/icons";

defineProps<{
  name: string;
}>();
</script>

<template>
  <i :class="`icon bi-${(iconMap as any)[name] ?? name}`" />
</template>
