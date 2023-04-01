<script setup>
import StatusBadge from "@/Components/StatusBadge.vue";
import { orderStatus } from "./shared";

defineProps({
  status: String,
});
</script>

<template>
  <StatusBadge v-bind="orderStatus[status]" />
</template>
