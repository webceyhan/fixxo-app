<script setup>
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps({
  status: String,
});

const states = {
  active: {
    label: "Active",
    theme: "primary",
  },
  on_leave: {
    label: "On Leave",
    theme: "warning",
  },
  suspended: {
    label: "Suspended",
    theme: "danger",
  },
  terminated: {
    label: "Terminated",
    theme: "secondary",
  },
};
</script>

<template>
  <StatusBadge v-bind="states[status]" />
</template>
