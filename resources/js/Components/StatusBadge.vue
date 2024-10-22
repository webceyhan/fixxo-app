<script setup lang="ts">
import Badge from "@/Components/Badge.vue";
import Icon from "@/Components/Icon.vue";

defineProps<{
  color: string;
  label: string;
  icon: string;
  compact?: boolean;
}>();
</script>

<template>
  <Badge class="text-nowrap" :color :compact>
    <Icon v-if="compact" :name="icon" />
    <span v-else v-html="label" />
  </Badge>
</template>
