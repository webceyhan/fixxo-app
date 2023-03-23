<script setup>
import Badge from "./Badge.vue";
import Icon from "./Icon.vue";

defineProps({
  label: String,
  icon: String,
  theme: String,
  compact: Boolean, // no label on mobile
  compactMax: String, // no label until this breakpoint
});

// common icons by theme
const iconMap = {
  primary: "play-circle-fill", // work in progress
  warning: "pause-circle-fill", // on hold
  success: "check-circle-fill", // done with success
  danger: "x-circle-fill", // done with error
  secondary: "dash-circle-fill", // inactive
};

const badgeCompactMap = {
  sm: "max-sm:!p-0",
  md: "max-md:!p-0",
  lg: "max-lg:!p-0",
  xl: "max-xl:!p-0",
};

const iconCompactMap = {
  sm: "sm:hidden",
  md: "md:hidden",
  lg: "lg:hidden",
  xl: "xl:hidden",
};

const labelCompactMap = {
  sm: "max-sm:hidden",
  md: "max-md:hidden",
  lg: "max-lg:hidden",
  xl: "max-xl:hidden",
};
</script>

<template>
  <!-- <Badge :theme="theme" class="whitespace-nowrap" :class="{ '!p-0': compact }">
    <Icon v-if="compact" :name="icon ?? iconMap[theme]" />
    <span v-if="!compact">{{ label }}</span>
  </Badge> -->

  <Badge
    :theme="theme"
    class="whitespace-nowrap"
    :class="[badgeCompactMap[compactMax], !compactMax && compact ? '!p-0' : '']"
  >
    <Icon
      :name="icon ?? iconMap[theme]"
      :class="[iconCompactMap[compactMax], !compactMax && !compact ? 'hidden' : '']"
    />
    <span
      v-html="label"
      :class="[labelCompactMap[compactMax], !compactMax && compact ? 'hidden' : '']"
    />
  </Badge>
</template>
