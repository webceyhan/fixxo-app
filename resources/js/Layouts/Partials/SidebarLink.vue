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
      'flex items-center pl-6 py-3 mb-1': true,
      // border
      'border-l-2 border-transparent hover:border-gray-700': true,
      // text
      'text-base font-semibold leading-5 text-gray-400 hover:text-gray-100': true,
      // background
      'hover:bg-gray-800 hover:bg-opacity-50': true,
      // animation
      'transition duration-100 ease-in-out': true,
      // active
      '!border-indigo-600 !text-gray-100': active,
    }"
  >
    <Icon :name="icon" class="text-3xl mr-4" />
    <span>{{ label }}</span>
  </Link>
</template>
