<script setup>
import Badge from "@/Components/Badge.vue";
import Icon from "@/Components/Icon.vue";

defineProps({
  label: String,
  icon: String,
  color: String,
  compact: Boolean, // no label on mobile
});
</script>

<template>
  <Badge class="text-nowrap" :color :compact>
    <Icon v-if="compact" :name="icon" />
    <span v-else v-html="label" />
  </Badge>
</template>
