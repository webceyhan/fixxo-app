<script setup>
import { Link } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";
import Avatar from "@/Components/Avatar.vue";

defineProps({
  label: String,
  icon: String,
});
</script>

<template>
  <component
    :is="$attrs.href ? Link : 'li'"
    class="relative flex justify-between items-center p-4 sm:px-6 space-x-4 sm:space-x-6"
    :class="{
      'hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:bg-opacity-30': $attrs.href,
    }"
  >
    <!-- avatar -->
    <Avatar v-if="icon" :icon="icon" class="opacity-50" />

    <slot> {{ label }} </slot>

    <!-- badge -->
    <!-- badge will be visible on the left corner of list icon on mobile
    and moved to the right end of the list item on larger screens -->
    <div
      v-if="$slots.badge"
      class="absolute left-0 bottom-3 lg:relative lg:bottom-0 lg:w-2/12 text-center"
    >
      <slot name="badge" />
    </div>

    <!-- browse icon -->
    <Icon v-if="$attrs.href" name="chevron-right" class="text-sm opacity-25" />
  </component>
</template>
