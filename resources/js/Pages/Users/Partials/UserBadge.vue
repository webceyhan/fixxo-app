<script setup lang="ts">
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps<{
  status: keyof typeof states; // TODO: define type
}>();

// TODO: extract to shared file
const states = {
  active: {
    label: "Active",
    icon: "play-circle-fill",
    color: "info",
  },
  on_leave: {
    label: "On Leave",
    icon: "pause-circle-fill",
    color: "warning",
  },
  suspended: {
    label: "Suspended",
    icon: "stop-circle-fill",
    color: "error",
  },
  terminated: {
    label: "Terminated",
    icon: "dash-circle-fill",
    color: "neutral",
  },
};
</script>

<template>
  <StatusBadge v-bind="states[status]" />
</template>
