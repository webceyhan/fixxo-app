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
