<script setup>
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps({
  status: String,
});

const states = {
  new: {
    label: "New",
    theme: "secondary",
  },
  completed: {
    label: "Completed",
    theme: "success",
  },
  cancelled: {
    label: "Cancelled",
    theme: "danger",
  },
};
</script>

<template>
  <StatusBadge v-bind="states[status]" />
</template>
