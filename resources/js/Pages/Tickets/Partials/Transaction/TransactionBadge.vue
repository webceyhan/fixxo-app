<script setup>
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps({
  type: String,
});

const states = {
  charge: {
    label: "Charge",
    theme: "success",
    icon: 'plus-lg'
  },
  refund: {
    label: "Refund",
    theme: "danger",
    icon: 'dash-lg'
  },
  discount: {
    label: "Discount",
    theme: "warning",
    icon: 'percent'
  },
  warranty: {
    label: "Warranty",
    theme: "primary",
    icon: 'shield-check'
  },
};
</script>

<template>
  <StatusBadge v-bind="states[type]" />
</template>
