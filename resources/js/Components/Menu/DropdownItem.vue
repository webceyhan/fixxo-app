<script setup>
import { Link } from "@inertiajs/vue3";
import { MenuItem } from "@headlessui/vue";
import Icon from "@/Components/Icon.vue";

defineProps({
  label: String,
  icon: String,
});
</script>

<template>
  <MenuItem v-slot="{ active }">
    <slot>
      <Link
        as="button"
        :class="{
          'group flex w-full items-center px-4 py-2 space-x-4': true,
          'focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800': true,
          'transition duration-150 ease-in-out': true,
          'text-gray-700 dark:text-gray-300': true,
          'bg-gray-100 dark:bg-gray-700 ': active, // hover
        }"
      >
        <Icon
          v-if="icon"
          :name="icon"
          :active="active"
          class="text-lg"
          aria-hidden="true"
        />
        <span>{{ label }}</span>
      </Link>
    </slot>
  </MenuItem>
</template>
