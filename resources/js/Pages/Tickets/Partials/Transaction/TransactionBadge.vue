<script setup>
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps({
  type: String,
});

const states = {
  payment: {
    label: "Payment",
    color: "success",
    icon: "arrow-right-circle-fill",
  },
  discount: {
    label: "Discount",
    color: "warning",
    icon: "arrow-down-circle-fill",
  },
  claim: {
    label: "Claim",
    color: "info",
    icon: "dash-circle-fill",
  },
  refund: {
    label: "Refund",
    color: "error",
    icon: "arrow-left-circle-fill",
  },
};
</script>

<template>
  <StatusBadge v-bind="states[type]" />
</template>
