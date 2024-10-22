<script setup>
import { Link } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";

defineProps({
  label: String,
  icon: String,
  active: Boolean,
});
</script>

<template>
  <Link
    :class="{
      // base
      'flex items-center px-6 py-4': true,
      // border
      'border-l-2 border-transparent hover:border-gray-600': true,
      // text
      'text-lg font-semibold leading-5 text-gray-400 hover:text-gray-100': true,
      // background
      'hover:bg-gray-800/50': true,
      // active
      '!border-indigo-600 !text-gray-100': active,
    }"
  >
    <span class="flex items-center justify-center w-7 h-7 mr-4">
      <Icon :name="icon" class="text-2xl" />
    </span>

    <span>{{ label }}</span>
  </Link>
</template>
