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
  in_repair: {
    label: "In Repair",
    theme: "primary",
  },
  on_hold: {
    label: "On Hold",
    theme: "warning",
  },
  fixed: {
    label: "Fixed",
    theme: "success",
  },
  defect: {
    label: "Defect",
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
