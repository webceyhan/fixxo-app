<script setup>
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps({
  status: String,
});

const states = {
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
