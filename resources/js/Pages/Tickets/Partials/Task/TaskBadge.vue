<script setup>
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps({
  status: String,
});

const states = {
  pending: {
    label: "Pending",
    theme: "warning",
  },
  done: {
    label: "Done",
    theme: "success",
  },
};
</script>

<template>
  <StatusBadge v-bind="states[status]" />
</template>
