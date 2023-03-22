<script setup>
import Badge from "./Badge.vue";
import Icon from "./Icon.vue";

defineProps({
  label: String,
  icon: String,
  theme: String,
  compact: Boolean, // no label on mobile
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
  <Badge :theme="theme" class="whitespace-nowrap" :class="{ 'max-xl:!p-0': !compact }">
    <!-- icon only visible as badge on mobile -->
    <Icon :name="icon ?? iconMap[theme]" :class="{ 'xl:hidden': !compact }" />
    <!-- label only visible on larger screens -->
    <span v-if="!compact" class="hidden xl:inline">{{ label }}</span>
  </Badge>
</template>
