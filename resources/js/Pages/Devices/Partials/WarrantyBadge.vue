<script setup lang="ts">
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps<{
  status: keyof typeof states; // TODO: define type
}>();

const states = {
  // TODO: extract to a shared file
  na: {
    label: "N/A",
    icon: "dash-circle-fill",
    color: "neutral",
  },
  valid: {
    label: "Valid",
    icon: "check-circle-fill",
    color: "success",
  },
  expired: {
    label: "Expired",
    icon: "exclamation-circle-fill",
    color: "error",
  },
};
</script>

<template>
  <StatusBadge v-bind="states[status]" />
</template>
