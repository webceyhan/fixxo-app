<script setup lang="ts">
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps<{
  status: keyof typeof states; // TODO: define type
}>();

const states = {
  // TODO: extract to a shared file
  checked_in: {
    label: "Checked In",
    icon: "clock-fill",
    color: "neutral",
  },
  in_repair: {
    label: "In Repair",
    icon: "play-circle-fill",
    color: "info",
  },
  on_hold: {
    label: "On Hold",
    icon: "pause-circle-fill",
    color: "warning",
  },
  finished: {
    label: "Finished",
    icon: "check-circle-fill",
    color: "success",
  },
  checked_out: {
    label: "Checked Out",
    icon: "dash-circle-fill",
    color: "neutral",
  },
};
</script>

<template>
  <StatusBadge v-bind="states[status]" />
</template>
