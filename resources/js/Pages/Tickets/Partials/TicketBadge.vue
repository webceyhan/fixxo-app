<script setup lang="ts">
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps<{
  status: keyof typeof states; // TODO: define type
}>();

const states = {
  // TODO: extract to shared file
  new: {
    label: "New",
    icon: "clock-fill",
    color: "neutral",
  },
  in_progress: {
    label: "In Progress",
    icon: "play-circle-fill",
    color: "info",
  },
  on_hold: {
    label: "On Hold",
    icon: "pause-circle-fill",
    color: "warning",
  },
  resolved: {
    label: "Resolved",
    icon: "check-circle-fill",
    color: "success",
  },
  closed: {
    label: "Closed",
    icon: "dash-circle-fill",
    color: "neutral",
  },
};
</script>

<template>
  <StatusBadge v-bind="states[status]" />
</template>
