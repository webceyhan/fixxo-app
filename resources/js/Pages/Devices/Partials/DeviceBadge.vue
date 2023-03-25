<script setup>
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps({
  status: String,
});

const states = {
  checked_in: {
    label: "Checked In",
    theme: "secondary",
  },
  diagnosing: {
    label: "Diagnosing",
    theme: "primary",
  },
  pending_parts: {
    label: "Pending Parts",
    theme: "warning",
  },
  repairing: {
    label: "Repairing",
    theme: "primary",
  },
  fixed: {
    label: "Fixed",
    theme: "success",
  },
  unfixable: {
    label: "Unfixable",
    theme: "danger",
  },
  checked_out: {
    label: "Checked Out",
    theme: "secondary",
  },
};
</script>

<template>
  <StatusBadge v-bind="states[status]" />
</template>
