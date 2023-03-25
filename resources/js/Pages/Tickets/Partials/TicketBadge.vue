<script setup>
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps({
  status: String,
});

const states = {
  open: {
    label: "Open",
    theme: "secondary",
  },
  in_progress: {
    label: "In Progress",
    theme: "primary",
  },
  on_hold: {
    label: "On Hold",
    theme: "warning",
  },
  resolved: {
    label: "Resolved",
    theme: "success",
  },
  closed: {
    label: "Closed",
    theme: "secondary",
  },
};
</script>

<template>
  <StatusBadge v-bind="states[status]" />
</template>
