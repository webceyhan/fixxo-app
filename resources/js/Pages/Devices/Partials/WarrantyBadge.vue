<script setup>
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps({
  status: String,
});

const states = {
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
