<script setup>
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps({
  status: String,
});

const states = {
  new: {
    label: "New",
    icon: "clock-fill",
    color: "neutral",
  },
  completed: {
    label: "Completed",
    icon: "check-circle-fill",
    color: "success",
  },
  cancelled: {
    label: "Cancelled",
    icon: "x-circle-fill",
    color: "error",
  },
};
</script>

<template>
  <StatusBadge v-bind="states[status]" />
</template>
