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
  inactive: {
    label: "Inactive",
    theme: "secondary",
  },
};
</script>

<template>
  <StatusBadge v-bind="states[status]" />
</template>
