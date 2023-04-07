<script setup>
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps({
  status: String,
});

const states = {
  na: {
    label: "N/A",
    theme: "secondary",
  },
  valid: {
    label: "Valid",
    theme: "success",
  },
  expired: {
    label: "Expired",
    theme: "warning",
  },
};
</script>

<template>
  <StatusBadge v-bind="states[status]" />
</template>
