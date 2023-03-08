<script setup>
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps({
  status: String,
});

const states = {
  in_progress: {
    label: "In Progress",
    // icon: "play-circle-fill",
    theme: "primary",
  },
  ready: {
    label: "Ready",
    // icon: "check-circle-fill",
    theme: "success",
  },
  returned: {
    label: "Returned",
    // icon: "dash-circle-fill",
    theme: "secondary",
  },
};
</script>

<template>
  <StatusBadge v-bind="states[status]" />
</template>
