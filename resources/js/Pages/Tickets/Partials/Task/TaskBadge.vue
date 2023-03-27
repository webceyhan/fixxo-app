<script setup>
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps({
  completed: Boolean,
});

const states = {
  false: {
    label: "Pending",
    theme: "warning",
  },
  true: {
    label: "Completed",
    theme: "success",
  },
};
</script>

<template>
  <StatusBadge v-bind="states[completed]" />
</template>
