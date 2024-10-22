<script setup lang="ts">
import StatusBadge from "@/Components/StatusBadge.vue";
import { invoiceStatus } from "./shared";

defineProps<{
  status: keyof typeof invoiceStatus; // TODO: define type
}>();
</script>

<template>
  <StatusBadge v-bind="invoiceStatus[status]" />
</template>
