<script setup lang="ts">
import StatusBadge from "@/Components/StatusBadge.vue";

defineProps<{
  type: keyof typeof states; // TODO: define type
}>();

const states = {
  // TODO: extract to shared file
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
