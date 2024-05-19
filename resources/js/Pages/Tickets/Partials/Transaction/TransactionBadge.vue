<script setup>
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps({
  type: String,
});

const states = {
  payment: {
    label: "Payment",
    theme: "success",
    icon: "plus-lg",
  },
  discount: {
    label: "Discount",
    theme: "warning",
    icon: "percent",
  },
  claim: {
    label: "Claim",
    theme: "primary",
    icon: "shield-check",
  },
  refund: {
    label: "Refund",
    theme: "danger",
    icon: "dash-lg",
  },
};
</script>

<template>
  <StatusBadge v-bind="states[type]" />
</template>
