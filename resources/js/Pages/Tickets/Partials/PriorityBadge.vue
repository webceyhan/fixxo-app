<script setup>
import { computed } from "vue";
import Icon from "@/Components/Icon.vue";
import Badge from "@/Components/Badge.vue";

const props = defineProps({
  value: String,
});

const states = {
  high: {
    label: "High",
    theme: "danger",
    icon: "chevron-compact-up",
  },
  normal: {
    label: "Normal",
    theme: "warning",
    icon: "pause rotate-90",
  },
  low: {
    label: "Low",
    theme: "primary",
    icon: "chevron-compact-down",
  },
};

const priority = computed(() => states[props.value]);
</script>

<template>
  <Badge :theme="priority.theme" class="whitespace-nowrap">
    <Icon :name="priority.icon" />
    <span v-html="priority.label" class="text-gray-400" />
  </Badge>
</template>
