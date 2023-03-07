<script setup>
import { Link } from "@inertiajs/vue3";
import Icon from "../Icon.vue";

defineProps({
  label: String,
  icon: String,
});
</script>

<template>
  <component
    :is="$attrs.href ? Link : 'li'"
    class="flex justify-between items-center p-4 sm:px-6 space-x-4 sm:space-x-6"
    :class="{
      'hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:bg-opacity-30': $attrs.href,
    }"
  >
    <!-- icon -->
    <div v-if="icon" class="flex items-center justify-center opacity-50">
      <div
        class="text-white bg-gray-900 rounded-full w-12 h-12 flex items-center justify-center"
      >
        <Icon :name="icon" class="text-2xl" />
      </div>
    </div>

    <slot> {{ label }} </slot>

    <!-- browse icon -->
    <Icon v-if="$attrs.href" name="chevron-right" class="text-sm opacity-25" />
  </component>
</template>
