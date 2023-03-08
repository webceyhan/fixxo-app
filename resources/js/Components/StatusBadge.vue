<script setup>
import Badge from "./Badge.vue";
import Icon from "./Icon.vue";

defineProps({
  label: String,
  icon: String,
  theme: String,
});

// common icons by theme
const iconMap = {
  primary: "play-circle-fill", // work in progress
  warning: "pause-circle-fill", // on hold
  success: "check-circle-fill", // done with success
  danger: "x-circle-fill", // done with error
  secondary: "dash-circle-fill", // inactive
};
</script>

<template>
  <Badge :theme="theme" class="whitespace-nowrap">
    <!-- icon only visible as badge on mobile -->
    <Icon :name="icon ?? iconMap[theme]" class="lg:hidden" />
    <!-- label only visible on larger screens -->
    <span class="hidden lg:inline">{{ label }}</span>
  </Badge>
</template>
