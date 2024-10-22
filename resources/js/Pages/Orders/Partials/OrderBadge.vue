<script setup lang="ts">
import StatusBadge from "@/Components/StatusBadge.vue";
import { orderStatus } from "./shared";

defineProps<{
  status: keyof typeof orderStatus; // TODO: define type
}>();
</script>

<template>
  <StatusBadge v-bind="orderStatus[status]" />
</template>
