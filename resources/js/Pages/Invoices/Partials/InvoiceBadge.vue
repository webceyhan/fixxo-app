<script setup>
import StatusBadge from "@/Components/StatusBadge.vue";
import { invoiceStatus } from "./shared";

defineProps({
  status: String,
});
</script>

<template>
  <StatusBadge v-bind="invoiceStatus[status]" />
</template>
