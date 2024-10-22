<script setup lang="ts">
import { computed } from "vue";
import Icon from "@/Components/Icon.vue";
import Badge from "@/Components/Badge.vue";

const props = defineProps<{
  value: keyof typeof states; // TODO: define type
}>();

const states = {
  // TODO: extract to shared file
  high: {
    label: "High",
    color: "error",
    icon: "chevron-compact-up",
  },
  normal: {
    label: "Normal",
    color: "warning",
    icon: "pause rotate-90",
  },
  low: {
    label: "Low",
    color: "primary",
    icon: "chevron-compact-down",
  },
};

const priority = computed(() => states[props.value]);
</script>

<template>
  <Badge :color="priority.color" class="whitespace-nowrap">
    <Icon :name="priority.icon" />
    <span v-html="priority.label" class="text-gray-400" />
  </Badge>
</template>
